<?php

namespace App\Http\Controllers;

use App\Models\NutrientIntake;
use Illuminate\Http\Request;

class NutrientController extends Controller
{
    public function update(Request $request, $userId)
    {
        $request->validate([
            'kcal' => 'required|integer',
            'protein' => 'required|integer',
            'carbs' => 'required|integer',
            'fibre' => 'required|integer',
            'fats' => 'required|integer',
            'water' => 'required|integer',
        ]);

        // Find the nutrient intake record based on user_id
        $nutrientIntake = NutrientIntake::where('user_id', $userId)->first();

        if (!$nutrientIntake) {
            return response(['message' => 'Nutrient intake not found for the specified user.'], 404);
        }

        // Update the nutrient details
        $nutrientIntake->update($request->all());

        return response([
            'message' => 'Nutrient details updated.',
            'Nutrients' => $nutrientIntake,
        ], 200);
    }

}
