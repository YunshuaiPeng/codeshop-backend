<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => User::passwordRules()
        ])->after(function ($validator) use ($user, $request) {
            if (!Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add('field', __('The provided password does not match your current password.'));
            }
        })->validate();

        $user->fill([
            'password' => Hash::make($request->password),
        ])->save();

        return response()->json([], 200);
    }

    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages(['status' => trans($status)]);
        }

        return response()->json([], 200);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|max:255',
            'password' => User::passwordRules(),
        ]);

        $credentials = $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );

        $action = function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();

            event(new PasswordReset($user));
        };

        $status = Password::reset($credentials, $action);

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages(['status' => trans($status)]);
        }

        return response()->json([], 200);
    }
}
