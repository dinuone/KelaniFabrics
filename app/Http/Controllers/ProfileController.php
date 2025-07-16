<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function show()
    {
        $user = Auth::user(); // Get currently logged-in user
       
        $user->load('roles'); // Load roles if needed
        return view('profile.show', compact('user'));
    }
}
