<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailToBeSent extends Model
{
    use HasFactory;

    protected $table = 'emails_to_be_sent';

    protected $fillable = [
        'recipient_email',
        'recipient_name',
        'subject',
        'content',
    ];
}