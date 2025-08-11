<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function password(Request $request)
    {
        $validate = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        $isCorrectPassword = Hash::check($validate['current_password'], $user->password);

        if (!$isCorrectPassword) {
            throw ValidationException::withMessages([
                'current_password' => ["Contraseña Incorrecta"],
            ]);
        }

        $user->password = Hash::make($validate['password']);
        $user->save();

        return response()->json([
            'message' => 'La contraseña ha sido cambiada.'
        ]);
    }

    public function profile(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->update([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
        ]);

        return response()->json(['message' => 'El perfil ha sido actualizado.']);
    }
}
