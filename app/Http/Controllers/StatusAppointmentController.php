<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusAppointmentCollection;
use App\Models\StatusAppointment;
use Illuminate\Http\Request;

class StatusAppointmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return new StatusAppointmentCollection(StatusAppointment::all());
    }
}
