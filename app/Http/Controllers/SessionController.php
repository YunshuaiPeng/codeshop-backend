<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
            'remember_me' => 'boolean'
        ]);

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (!Auth::attempt($credentials, $request->remember_me)) {
            throw ValidationException::withMessages([
                'email' => '用户名或密码错误'
            ]);
        }

        return response()->json([],201);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
    }
}
