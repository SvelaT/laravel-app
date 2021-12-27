<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('name', $username)->first();
        $hashedPassword = $user->password;

        if(Hash::check($password, $hashedPassword)){
            return response()->json($user, 200);
        }
        return response()->json(null, 403);        
    }
}
