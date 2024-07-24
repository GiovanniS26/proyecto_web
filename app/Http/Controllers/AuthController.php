<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AuthController extends Controller
{

    // Devuelve la vista para el login.
    public function login_create(): View
    {
        return view("auth.login");
    }

    /**
     * Hace el login de la aplicación, si las credenciales son correctas
     * redirige hacía el login, sino retorna con un error.
     */
    public function login_store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.',
        ])->onlyInput('email');
    }

    // Devuelve la vista para el registro.
    public function register_create(): View
    {
        //
        return view("auth.register");
    }

    /**
     * Registra a un nuevo usuario, primero se limpia y se valida la información
     * si no existe coincidencia con algún correo existente, se procede a su creación.
     * Luego se redirige de nuevo al login.
     */
    public function register_store(Request $request): RedirectResponse
    {
        //
        $request->merge([
            'name' => trim($request->name),
            'email' => trim($request->email),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'role_id.exists' => 'El rol seleccionado no es válido.'
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('login', absolute: false));
    }

    /**
     * Funcion de logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
