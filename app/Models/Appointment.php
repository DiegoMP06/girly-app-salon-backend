<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'date',
        'time_start',
        'time_end',
        'total',
        'user_id',
        'status_appointment_id',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'appointment_services', 'appointment_id', 'service_id');
    }

    public function statusAppointment()
    {
        return $this->belongsTo(StatusAppointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
