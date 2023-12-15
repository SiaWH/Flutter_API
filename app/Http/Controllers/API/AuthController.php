<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'message' => 'Incorrect email or password',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

    // public function update(Request $request)
    // {
    //     $attrs = $request->validate([
    //         'name' => 'required|string'
    //     ]);

    //     auth()->user()->update([
    //         'name' => $attrs['name'],
    //     ]);

    //     return response([
    //         'message' => 'User updated.',
    //         'user' => auth()->user()
    //     ], 200);
    // }

    public function update(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,bmp',
        ]);

        $user = auth()->user();

        // Update name
        $user->update([
            'name' => $attrs['name'],
        ]);

        // Update image if provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($user->image) {
                $oldPath = public_path('images') . $user->image;
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // Update user with new image
            $user->update([
                'image' => $imageName,
            ]);
        }

        return response([
            'message' => 'User updated.',
            'user' => $user
        ], 200);
    }

    public function details(Request $request)
    {
        $attrs = $request->validate([
            'age' => 'required|integer',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'basal_metabolism' => 'required|numeric',
            'BMI' => 'required|numeric',
            'gender' => 'required|string',
        ]);

        $user = auth()->user();

        // Update details
        $user->update([
            'age' => $attrs['age'],
            'height' => $attrs['height'],
            'weight' => $attrs['weight'],
            'basal_metabolism' => $attrs['basal_metabolism'],
            'BMI' => $attrs['BMI'],
            'gender' => $attrs['gender'],
        ]);

        return response([
            'message' => "User's details updated.",
            'user' => $user
        ], 200);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user with the old password
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Incorrect password']);
        }

        // If authentication is successful, update the password with the new one
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    public function storeImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpg,png,bmp',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();

        if ($request->hasFile('image')) {
            if ($user->image) {
                $old_path = public_path('images') . $user->image;
                if (File::exists($old_path)) {
                    File::delete($old_path);
                }
            }

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images'), $image_name);
        } else {
            $image_name = $user->image;
        }

        $user->update([
            'image' => $image_name,
        ]);

        return response()->json([
            'message' => "Profile successfully updated $image_name",
            'user' => $user,
        ],200);

    }

    public function showImage($filename)
    {
        $path = storage_path('app/public/images/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);

        return response($file, 200)->header('Content-Type', 'image/jpeg');
    }

}
