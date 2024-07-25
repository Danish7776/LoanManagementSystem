<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    // Login
    public function login(Request $req)
    {
        try {
            $req->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('username', $req->username)->first();
            if ($user && Hash::check($req->password, $user->password)) {
                $token = $user->createToken($req->username)->plainTextToken;
                session(['token' => $token]);
                Auth::login($user);

                return redirect('/Dashboard');
            }

            return back()->withErrors(['credentials' => 'The provided credentials are incorrect.']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Signup 
    public function signup(Request $req)
    {
        try {
            $req->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|email|unique:users',
                'password' => 'required|string|min:8'
            ]);

            $user = User::create([
                'name' => $req->name,
                'username' => $req->email,
                'password' => Hash::make($req->password)
            ]);

            if ($user) {
                return redirect('/SignIn');
            }

            return back()->withErrors(['signup' => 'Signup failed, please try again.']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred during signup. Please try again later.']);
        }
    }

    // LogOut
    public function logout(Request $req)
    {
        try{
            $user = Auth::user();

            if ($user) {
                $user->tokens()->delete();
                $req->session()->invalidate();
                $req->session()->regenerateToken();
            }

            return redirect('/SignIn');
        } catch (\Exception $e) {
            return response([
                'message' => 'An error occurred during logout. Please try again later.',
                'error' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }
}
