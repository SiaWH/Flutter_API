<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'user_id',
        'appointment_date_time',
        'status',
        'rate',
    ];
}
