<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function users()
    {
        $users = User::all(); 
        return response()->json($users); 
    }

    public function user($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    // public function userUpdate(Request $request, $id)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $id,
    //         'password' => 'sometimes|string|min:8' 
    //     ]);

    //     // Find the user by ID
    //     $user = User::findOrFail($id);

    //     // Update the user's information
    //     $user->name = $request->name;
    //     $user->email = $request->email;

    //     // Update the password only if it's provided
    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->save();

    //     return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
    // }

    public function userUpdate(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|string|min:8'
            ]);
    
            // Find the user by ID or fail with a custom response
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found with the provided ID'], 404);
            }
    
            // Update the user's information
            $user->name = $request->name;
            $user->email = $request->email;
    
            // Update the password only if it's provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            $user->save();
    
            return response()->json(['message' => 'User updated successfully!', 'user' => $user]);
        } catch (\Exception $e) {
            // Return a generic error response
            return response()->json(['error' => 'User not found with the provided ID'], 400);
        }
    }
    


    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User is deleted successfully']);
    }
}
