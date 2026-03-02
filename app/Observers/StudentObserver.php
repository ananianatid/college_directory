<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StudentCredentialsNotification;

class StudentObserver
{
    /**
     * Handle the Student "creating" event.
     */
    public function creating(Student $student): void
    {
        // 1. Generate Matricule (Format: DEF-YYYY-XXXX)
        if (!$student->matricule) {
            $year = date('Y');
            $latestStudent = Student::where('matricule', 'like', "DEF-$year-%")
                ->latest('id')
                ->first();

            $sequence = $latestStudent ? (int)substr($latestStudent->matricule, -4) + 1 : 1;
            $student->matricule = "DEF-$year-" . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
        }

        // 2. Generate Academic Email (Format: first_initial.last_name@defitech.tg)
        if (!$student->academic_email) {
            $firstInitial = Str::lower(substr($student->first_names, 0, 1));
            $lastName = Str::slug($student->last_name, '');
            $baseEmail = "{$firstInitial}.{$lastName}";
            $domain = "@defitech.tg";
            $email = $baseEmail . $domain;

            // Handle homonyms
            $count = 1;
            while (Student::where('academic_email', $email)->exists() || User::where('email', $email)->exists()) {
                $email = "{$baseEmail}{$count}{$domain}";
                $count++;
            }

            $student->academic_email = $email;
        }
    }

    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        // 3. Create associated User account if not exists
        if (!$student->user_id) {
            $password = Str::random(12);

            $user = User::create([
                'name' => "{$student->first_names} {$student->last_name}",
                'email' => $student->academic_email,
                'password' => Hash::make($password),
            ]);

            $student->user_id = $user->id;
            $student->saveQuietly();

            // 4. Notify student via personal email (Strategy 1)
            if ($student->personal_email) {
                \Illuminate\Support\Facades\Notification::route('mail', $student->personal_email)
                    ->notify(new StudentCredentialsNotification($student->academic_email, $password));
            }
        }
    }
}