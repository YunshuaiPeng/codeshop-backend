<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserView(Auth::user());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users|max:255',
            'email' => 'required|string|unique:users|email|max:255',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);

        Auth::guard()->login($user);

        return response()->json([], 201);
    }
}
