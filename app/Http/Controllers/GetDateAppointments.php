<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentCollection;
use App\Models\Appointment;
use Illuminate\Http\Request;

class GetDateAppointments extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $date)
    {
        $appointments = Appointment::where('date', $date)
            ->where(
                fn($builder) =>
                $builder->where('status_appointment_id', '!=', 3)->where('status_appointment_id', '!=', 4)
            )->get();

        return new AppointmentCollection($appointments);
    }
}
