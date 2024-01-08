<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::all();

        return response([
            'coach' => $coaches,
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'experience_years' => 'required|integer',
            'rate' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $coach = Coach::create([
            'name' => $request->input('name'),
            'image' => $request->input('image'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'experience_years' => $request->input('experience_years'),
            'rate' => $request->input('rate'),
            'description' => $request->input('description'),
        ]);

        return response([
            'coach' => $coach,
        ], 201);
    }

    public function updateRate(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|numeric',
        ]);

        $coach = Coach::findOrFail($id);

        $coach->update([
            'rate' => $request->input('rate'),
        ]);

        return response(['message' => 'Rate updated successfully', 'data' => $coach]);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'experience_years' => 'required|integer',
            'rate' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $coach = Coach::find($id);

        if (!$coach) {
            return response([
                'message' => 'Coach not found.',
            ], 404);
        }

        $coach->update($request->all());

        return response([
            'message' => 'Coach updated successfully.',
        ], 200);
    }

    public function delete($id)
    {
        $coach = Coach::find($id);

        if (!$coach) {
            return response([
                'message' => 'Coach not found.',
            ], 404);
        }

        $coach->delete();

        return response([
            'message' => 'Coach deleted successfully.',
        ], 200);
    }
}
