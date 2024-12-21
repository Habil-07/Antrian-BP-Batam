<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'main_service',
        'sub_service',
        'appointment_date',
        'appointment_time',
        'customer_name',
        'customer_nik',
        'customer_phone',
        'whatsapp',
        'queue_prefix',
        'queue_number',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'date:Y-m-d',
        'appointment_time' => 'datetime:H:i',
    ];
}
