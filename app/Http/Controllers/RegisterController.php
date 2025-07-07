<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:100', 'unique:tbl_adminlogin'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tbl_adminlogin'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Login::create([
            'admin_id' => (string) Str::ulid(),
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
