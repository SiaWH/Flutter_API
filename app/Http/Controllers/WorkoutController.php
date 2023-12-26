<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index()
    {
        $workouts = Workout::all();
        return response(['workouts' => $workouts], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|string',
            'video' => 'required|string',
            'difficulty' => 'required|integer',
            'type' => 'required|string',
        ]);

        $workouts = Workout::create($request->all());

        return response([
            'Nutrients' => $workouts,
        ], 200);
    }
}
