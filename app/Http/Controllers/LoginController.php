<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|email',  // adjust if username is not email
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $request->ajax()
                ? response()->json(['error' => 'Invalid credentials.'], 401)
                : back()->withErrors(['username' => 'Invalid credentials.']);
        }

        // Create a new Sanctum token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        if ($request->ajax()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } else {
            // For web, you can log user in session (optional)
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // ✅ Fix here

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
