<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentCollection;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'date' => ['date:Y-m-d'],
            'status' => ['exists:status_appointments,id'],
        ]);

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
            ->paginate(20);

        return new AppointmentCollection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date:Y-m-d'],
            'time_start' => ['required', 'date_format:H:i'],
            'total' => ['required', 'numeric', 'min:0'],
            'services' => ['required', 'array', 'min:1', 'max:3'],
            'services.*' => ['required', 'numeric', 'exists:services,id'],
        ]);

        $timeEnd = Carbon::parse($request->time_start)->addHours(count($request->services));

        $appointment = $request->user()->appointments()->create([
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $timeEnd->format('H:i'),
            'total' => $request->total,
            'status_appointment_id' => 1,
        ]);

        $appointment->services()->sync($request->services);

        return response()->json(['message' => 'La cita ha sido creada.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return new AppointmentCollection([$appointment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
       $request->validate([
            'date' => ['required', 'date:Y-m-d'],
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i'],
        ]);

        $appointment->update([
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ]);

        return response()->json(['message' => 'La cita ha sido actualizada.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
    }
}
