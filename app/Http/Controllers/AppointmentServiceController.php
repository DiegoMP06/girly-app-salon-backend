<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentService;
use Illuminate\Http\Request;

class AppointmentServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Appointment $appointment)
    {
        return $appointment->services()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        if ($appointment->services()->count() === 3) {
            return response()->json(['message' => 'La cita ya tiene 3 servicios.'], 400);
        }

        if ($appointment->services()->where('service_id', $data['service_id'])->exists()) {
            return response()->json(['message' => 'El servicio ya ha sido agregado a la cita.'], 400);
        }

        $appointment->services()->syncWithoutDetaching($data['service_id']);

        $appointment->total = $appointment->services()->sum('price');
        $appointment->save();

        return response()->json(['message' => 'El servicio ha sido agregado a la cita.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment, AppointmentService $appointmentService)
    {
        $appointment->services()->detach($appointmentService->service_id);
        $appointment->total = $appointment->services()->sum('price');
        $appointment->save();
        return response()->json(['message' => 'El servicio ha sido eliminado de la cita.']);
    }
}
