<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function sendEmailPasswordReset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => ["No se pudo enviar el enlace de restablecimiento de contraseña."],
            ]);
        }

        return response()->json(['message' => "Se ha enviado un correo de restablecimiento de contraseña."]);
    }

    public function index(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
        ]);

        return view('Auth.ResetPassword', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->string('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => ["La contraseña no ha sido restablecida."],
            ]);
        }

        return back()->with('status', 'La contraseña ha sido restablecida.');
    }
}
