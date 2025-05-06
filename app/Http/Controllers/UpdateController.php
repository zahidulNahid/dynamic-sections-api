<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateController extends Controller
{

    public function show(){
        
        return response()->json([
            'email' => Auth::user()->email,
            'password' => Auth::user()->password,
            
        ]);
    }

    // Handle the update request
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user = Auth::user();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
