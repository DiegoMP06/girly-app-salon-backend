<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class UpdateApointmentStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status_appointment_id' => ['required', 'exists:status_appointments,id'],
        ]);

        $appointment->update([
            'status_appointment_id' => $data['status_appointment_id'],
        ]);

        return response()->json([
            'message' => 'Estatús de cita actualizada.',
        ]);
    }
}
