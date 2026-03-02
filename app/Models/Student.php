<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'matricule',
        'user_id',
        'last_name',
        'first_names',
        'birth_date',
        'birth_place',
        'nationality',
        'gender',
        'photo_path',
        'bac_series',
        'bac_year',
        'previous_establishment',
        'enrollment_level',
        'filiere_id',
        'address',
        'phone',
        'personal_email',
        'academic_email',
        'payment_modality',
        'special_payment_details',
        'payment_status',
        'parent_name',
        'parent_profession',
        'parent_employer',
        'parent_address',
        'parent_office_phone',
        'parent_home_phone',
        'parent_mobile_phone',
        'parent_email',
        'bac_certificate_path',
        'birth_certificate_path',
        'registration_form_path',
        'status',
        'registration_status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the user account associated with the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the filiere associated with the student.
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }
}