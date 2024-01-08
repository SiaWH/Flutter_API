<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();

        return response([
            'food' => $foods,
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fats' => 'required|numeric',
            'fiber' => 'required|numeric',
        ]);

        $food = Food::create([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'protein' => $request->input('protein'),
            'carbs' => $request->input('carbs'),
            'fats' => $request->input('fats'),
            'fiber' => $request->input('fiber'),
        ]);

        return response([
            'food' => $food,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fats' => 'required|numeric',
            'fiber' => 'required|numeric',
        ]);

        $food = Food::find($id);

        $food->update($request->all());

        return response([
            'food' => $food,
        ], 200);
    }

    public function delete($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response([
                'message' => 'Food not found.',
            ], 404);
        }

        $food->delete();

        return response([
            'message' => 'Food deleted successfully.',
        ], 200);
    }
}
