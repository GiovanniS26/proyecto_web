<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de cliente
     */
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin')) {

            // Obtener el tamaño de la página desde la solicitud, o usar un valor predeterminado
            $pageSize = $request->input('page_size', 5);
            $users = User::with('role')->paginate($pageSize);

            $roles = Role::all();

            return view('app.app_pages.users', compact('users', 'roles'));
        }

        return view('app.user_dashboard');
    }

    /**
     * Registra a un nuevo usuario, primero se limpia y se valida la información
     * si no existe coincidencia con algún correo existente, se procede a su creación.
     * Luego se redirige de nuevo al login.
     */
    public function store(Request $request): RedirectResponse
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
            'email.unique' => 'Este Email ya está en uso.',
            'role_id.exists' => 'El rol seleccionado no es válido.'
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users_page')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Actualiza la información de un usuario 
     * @param $id del usuario
     * Primero se validan los datos y que no hayan coincidencias, se puede actualizar sin la contraseña.
     * Luego se procede a actualizar y redirigir al dashboard con el fin de actualizar
     * la información en pantalla.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->route('users_page')->with('error', 'Usuario no encontrado.');
        }

        if ($request->email !== $user->email) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'role_id' => ['required', 'exists:roles,id'],
                'password' => ['nullable', Rules\Password::defaults()],
            ], [
                'email.unique' => 'Este Email ya está en uso.',
                'role_id.exists' => 'El rol seleccionado no es válido.'
            ]);
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ];
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'role_id' => ['required', 'exists:roles,id'],
                'password' => ['nullable', Rules\Password::defaults()],
            ], [
                'role_id.exists' => 'El rol seleccionado no es válido.'
            ]);
            $userData = [
                'name' => $request->name,
                'role_id' => $request->role_id,
            ];
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users_page')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Elimina un usuario
     * @param $id del usuario a eliminar.
     * Retorna un json con un mensaje para imprimirlon por pantalla.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->route('users_page')->with('error', 'Usuario no encontrado.');
        }

        $user->delete();
        return redirect()->route('users_page')->with('success', 'Usuario borrado correctamente');
    }
}
