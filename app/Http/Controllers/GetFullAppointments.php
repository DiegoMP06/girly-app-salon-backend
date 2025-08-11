<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentCollection;
use App\Models\Appointment;
use Illuminate\Http\Request;

class GetFullAppointments extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $appointments = Appointment::when(
            $request->date,
            fn($builder, $date) =>
            $builder->where('date', $date)
        )
            ->when(
                $request->status,
                fn($builder, $status) =>
                $builder->where('status_appointment_id', $status)
            )
            ->with('services')
            ->with('user')
            ->paginate(20);

        return new AppointmentCollection($appointments);
    }
}
