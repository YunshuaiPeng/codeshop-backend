<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserView;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return new UserView(Auth::user());
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([], 204);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([], 202);
    }
}
