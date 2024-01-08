<?php

namespace App\Http\Controllers;

use App\Models\NutrientIntake;
use Illuminate\Http\Request;

class NutrientController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'kcal' => 'required|integer',
            'protein' => 'required|integer',
            'carbs' => 'required|integer',
            'fibre' => 'required|integer',
            'fats' => 'required|integer',
            'water' => 'required|integer',
            'grams' => 'required|numeric',
            'intake_time' => 'required|date',
        ]);

        $user = auth()->user();

        $nutrientIntake = NutrientIntake::create([
            'user_id' => $user->id,
            'food_id' => $request->input('food_id'),
            'kcal' => $request->input('kcal'),
            'protein' => $request->input('protein'),
            'carbs' => $request->input('carbs'),
            'fibre' => $request->input('fibre'),
            'fats' => $request->input('fats'),
            'water' => $request->input('water'),
            'grams' => $request->input('grams'),
            'intake_time' => $request->input('intake_time'),
        ]);

        return response([
            'message' => 'Nutrient details updated.',
            'Nutrients' => $nutrientIntake,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $attrs = $request->validate([
            'kcal' => 'required|integer',
            'protein' => 'required|integer',
            'carbs' => 'required|integer',
            'fibre' => 'required|integer',
            'fats' => 'required|integer',
            'water' => 'required|integer',
            'grams' => 'required|numeric',
        ]);

        $user = auth()->user();

        // Find the nutrient intake record based on user_id and id
        $nutrientIntake = NutrientIntake::where('user_id', $user->id)->where('id', $id)->first();

        if (!$nutrientIntake) {
            return response(['message' => 'Nutrient intake not found for the specified user.'], 404);
        }

        // Update the nutrient details
        $nutrientIntake->update([
            'kcal' => $attrs['kcal'],
            'protein' => $attrs['protein'],
            'carbs' => $attrs['carbs'],
            'fibre' => $attrs['fibre'],
            'fats' => $attrs['fats'],
            'water' => $attrs['water'],
            'grams' => $attrs['grams'],
        ]);

        return response([
            'message' => 'Nutrient details updated.'
        ], 200);
    }

    public function getNutrientById()
    {
        $user = auth()->user();
        // Find the nutrient intake records based on user_id and select specific columns
        $nutrientIntakes = NutrientIntake::where('user_id', $user->id)
            ->select('id', 'food_id','kcal', 'protein', 'carbs', 'fibre', 'fats', 'water', 'grams', 'intake_time')
            ->get();

        return response([
            'message' => 'Nutrient intake data retrieved successfully.',
            'nutrientIntakes' => $nutrientIntakes,
        ], 200);
    }

    public function delete($id)
    {
        $user = auth()->user();
        // Find the nutrient intake record based on user_id and id
        $nutrientIntake = NutrientIntake::where('user_id', $user->id)->where('id', $id)->first();

        if (!$nutrientIntake) {
            return response(['message' => 'Nutrient intake not found for the specified user and id.'], 404);
        }

        // Delete the nutrient intake record
        $nutrientIntake->delete();

        return response(['message' => 'Nutrient details deleted.'], 200);
    }

}
