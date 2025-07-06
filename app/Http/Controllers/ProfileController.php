<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->string('password')),
        ]);

        return response()->json(['message' => 'La contraseña ha sido actualizada.']);
    }

    public function profile(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        $request->user()->update([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
        ]);

        return response()->json(['message' => 'El perfil ha sido actualizado.']);
    }
}
