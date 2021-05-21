<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    }
}
