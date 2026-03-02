<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('sent_emails', 'emails_to_be_sent');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('emails_to_be_sent', 'sent_emails');
    }
};