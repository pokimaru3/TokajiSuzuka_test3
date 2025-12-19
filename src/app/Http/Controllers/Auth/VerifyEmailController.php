<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        if (!Auth::check()) {
            Auth::loginUsingId($request->user()->id);
        }

        return redirect()->route('verification.thanks');
    }
}
