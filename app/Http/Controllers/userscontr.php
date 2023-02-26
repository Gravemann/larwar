<?php

namespace App\Http\Controllers;

use App\Http\Requests\usersreq;
use App\Jobs\EmailVerificationJob;
use App\Jobs\PasswordResetLinkJob;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;


class userscontr extends Controller
{
    
    public function register(usersreq $request)
    {
        $user = User::create([
            "name"     => $request["name"],
            "email"    => $request["email"],
            "password" => bcrypt($request["password"])
        ]);

        if ($user) {
            dispatch(new EmailVerificationJob($user));
            auth("web")->login($user);
        }

        return redirect()->route('verification.notice');
    }


    public function login(Request $request)
    {
        $data = $request->validate([
            "email"    => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if (auth("web")->attempt($data)) {
            if (auth()->user()->hasVerifiedEmail()) {
                $request->session()->regenerate();
                return redirect()->route('brands');
            } else {
                $request->session()->regenerate();
                return redirect()->route('verification.notice');
            }
        }

        return back()->withErrors(
            ["email" => "User not found or credentials do not match"]
        );
    }

    public function logout()
    {
        auth("web")->logout();

        return redirect()->route('login');
    }

    public function password_reset_email(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->only('email');

        PasswordResetLinkJob::dispatch($email);

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function password_update(Request $request)
    {
        $request->validate([
            'token'    => ["required"],
            'email'    => ["required", "email"],
            'password' => [
                "required",
                "confirmed",
                RulesPassword::default()
            ]
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
