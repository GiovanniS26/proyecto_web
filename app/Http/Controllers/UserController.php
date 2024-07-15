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

class UserController extends Controller
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
            'email' => 'Email o contraseña incorrectos.',
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
            'email.unique' => 'Este Email ya está en uso.',
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
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de cliente
     */
    public function users(Request $request): View
    {
        if (auth()->user()->hasRole('admin')) {

            // Obtener el tamaño de la página desde la solicitud, o usar un valor predeterminado
            $pageSize = $request->input('page_size', 5);
            $users = User::with('role')->paginate($pageSize);

            return view('app.app_pages.users', compact('users'));
        }

        return view('app.user_dashboard');
    }

    /**
     * Crea un nuevo rol, primero se valida que no exista uno con el mismo nombre.
     * De no ser el caso, se procede a su creación y redirección al dashboard, con
     * el fin de actualizar la información en pantalla.
     */
    public function create_roles(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
        ], [
            'name.unique' => 'Ya existe un rol con este nombre.'
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Actualiza la información de un usuario 
     * @param $id del usuario
     * Primero se validan los datos y que no hayan coincidencias, se puede actualizar sin la contraseña.
     * Luego se procede a actualizar y redirigir al dashboard con el fin de actualizar
     * la información en pantalla.
     */
    public function update_users(Request $request, $id)
    {
        $user = User::findOrFail($id);
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

        return redirect()->route('dashboard')->with('response', 'Usuario actualizado correctamente');
    }
    /**
     * Actualizar un rol
     * @param $id del rol a actualizar
     * Se verifica y valida que no haya coincidencia con otro rol
     * También se verifica que no existan usuarios bajo ese rol antes de poder cambiarlo
     */
    public function update_roles(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
        ], [
            'name.unique' => 'Ya existe un rol con este nombre.'
        ]);

        $role = Role::where('id', $id)->first();
        $users = $role->users;
        if ($users->count() > 0) {
            return redirect()->route('dashboard')->with('response', 'No puedes actualizar un Rol con usuarios adjuntos.');
        } else {
            $role->update([
                'name' => $request->name,
            ]);
            return redirect()->route('dashboard')->with('response', 'Rol actualizado correctamente.');
        }
    }

    /**
     * Elimina un usuario
     * @param $id del usuario a eliminar.
     * Retorna un json con un mensaje para imprimirlon por pantalla.
     */
    public function destroy_users($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Usuario borrado con éxito.',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'No se ha podido borrar el usuario.',
        ]);
    }

    /**
     * Elimina un rol en base a su id
     * @param $id del rol a eliminar
     * Si existen usuarios adjuntos a ese rol, no se podrá eliminar el rol.
     */
    public function destroy_roles($id)
    {
        $role = Role::where('id', $id)->first();
        $users = $role->users;
        if ($users->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes borrar un rol con usuarios adjuntos.',
            ]);
        } else {
            $role->delete();
            return response()->json([
                'success' => true,
                'message' => 'Rol eliminado con éxito.',
            ]);
        }
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

    /**
     * Retorna todos los usuarios
     */
    public function get_users()
    {
        $users = User::with('role')->all();

        return $users;
    }

    /**
     * Rertorna todos los roles
     */
    public function get_roles()
    {
        $roles = Role::all();

        return $roles;
    }


}
