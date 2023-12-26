<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutrientIntake extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'food_name',
        'kcal',
        'protein',
        'carbs',
        'fibre',
        'fats',
        'water',
        'grams',
        'intake_time',
    ];
}
