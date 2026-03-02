<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // [Matricule] - Auto-generated unique identifier
            $table->string('matricule')->unique();

            // [Personal Information]
            $table->string('last_name'); // UpperCase
            $table->string('first_names');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('nationality');
            $table->enum('gender', ['M', 'F']);
            $table->string('photo_path')->nullable();

            // [Academic Background]
            $table->string('bac_series');
            $table->year('bac_year');
            $table->string('previous_establishment');

            // [Current Enrollment]
            $table->enum('enrollment_level', ['1ere annee', '2eme annee', '3eme annee']);
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('restrict');

            // [Contact & Generated Emails]
            $table->string('address');
            $table->string('phone');
            $table->string('personal_email')->unique();
            $table->string('academic_email')->unique(); //nomprenom@ecole.edu


            // [Payment Information]
            $table->enum('payment_modality', ['Comptant', '3 Tranches', '7 Tranches']);
            $table->text('special_payment_details')->nullable();
            $table->string('payment_status')->default('pending');

            // [Parent / Guardian (Contact d'Urgence)]
            $table->string('parent_name');
            $table->string('parent_profession');
            $table->string('parent_employer')->nullable();
            $table->string('parent_address');
            $table->string('parent_office_phone')->nullable();
            $table->string('parent_home_phone')->nullable();
            $table->string('parent_mobile_phone');
            $table->string('parent_email')->nullable();

            // [Document Uploads]
            $table->string('bac_certificate_path')->nullable()->comment('L\'attestation du bac');
            $table->string('birth_certificate_path')->nullable()->comment('L\'acte de naissance');
            $table->string('registration_form_path')->nullable()->comment('La fiche d\'inscription scannée');

            // [Status & Soft Deletes]
            $table->enum('status', ['actif', 'suspendu', 'diplome', 'abandon'])->default('actif');
            $table->enum('registration_status', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};