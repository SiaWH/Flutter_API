<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        $feedback = Feedback::all();

        return response([
            'feedback' => $feedback,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'sometimes',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $user = auth()->user();

        $feedback = Feedback::create([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully', 
            'data' => $feedback
        ], 201);
    }

    public function delete($id)
    {
        $feedback = Feedback::find($id);

        $feedback->delete();

        return response([
            'message' => 'Feedback deleted successfully.',
        ], 200);
    }
}
