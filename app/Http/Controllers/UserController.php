<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserView;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserView(Auth::user());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|unique:users|email|max:255',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::guard()->login($user);

        return response()->json([], 201);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        if ($request->email !== $user->email) {
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => null,
            ])->save();

            $user->sendEmailVerificationNotification();
        } else {
            $user->forceFill([
                'name' => $request->name,
            ])->save();
        }

        $user->fresh();

        return new UserView($user);
    }
}
