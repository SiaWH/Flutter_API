<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'coach_id' => 'required|exists:coaches,id',
            'appointment_date_time' => 'required|date',
        ]);

        $user = auth()->user();

        $appointment = Appointment::create([
            'coach_id' => $request->input('coach_id'),
            'user_id' => $user->id,
            'appointment_date_time' => $request->input('appointment_date_time'),
        ]);

        return response(['message' => 'Appointment created successfully', 'data' => $appointment], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,canceled',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => $request->input('status'),
        ]);

        return response(['message' => 'Appointment updated successfully', 'data' => $appointment]);
    }

    public function updateRate(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|numeric',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'rate' => $request->input('rate'),
        ]);

        return response(['message' => 'Rate updated successfully', 'data' => $appointment]);
    }

    public function indexByUser()
    {
        $user = auth()->user();

        $appointments = Appointment::where('user_id', $user->id)->get();

        return response(['appointment' => $appointments]);
    }

    public function getRatings($coach_id)
    {
        $ratings = Appointment::where('coach_id', $coach_id)
                        ->whereNotNull('rate')
                        ->get();

        return response(['appointment' => $ratings]);
    }
}
