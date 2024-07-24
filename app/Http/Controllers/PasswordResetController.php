<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Muestra el formulario para solicitar el restablecimiento de contraseña
    public function requestReset()
    {
        return view('auth.passwords.email');
    }

    // Envía el enlace de restablecimiento de contraseña
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $response = Password::sendResetLink($request->only('email'));

        return $response === Password::RESET_LINK_SENT
                    ? back()->with('status', "Te hemos enviado un correo con el link de reestablecimiento")
                    : back()->withErrors(['error' => "Error al enviar el link de reestablecimiento"]);
    }

    // Muestra el formulario para restablecer la contraseña
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Procesa el restablecimiento de la contraseña
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $response === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __('Tu contraseña ha sido reestablecida!'))
                    : back()->withErrors(['email' => [__($response)]]);
    }
}

