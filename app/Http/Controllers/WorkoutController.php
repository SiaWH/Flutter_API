<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index()
    {
        $workouts = Workout::select('id', 'name', 'gif', 'difficulty', 'type')->get();
        return response(['workouts' => $workouts], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gif' => 'required|string',
            'difficulty' => 'required|integer',
            'type' => 'required|string',
        ]);

        $workout = Workout::create($request->all());

        return response([
            'workout' => $workout,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'gif' => 'required|string',
            'difficulty' => 'required|integer',
            'type' => 'required|string',
        ]);

        $workout = Workout::find($id);

        $workout->update($request->all());

        return response([
            'workout' => $workout,
        ], 200);
    }

    public function delete($id)
    {
        $workout = Workout::find($id);

        if (!$workout) {
            return response([
                'message' => 'Food not found.',
            ], 404);
        }

        $workout->delete();

        return response([
            'message' => 'Food deleted successfully.',
        ], 200);
    }
}
