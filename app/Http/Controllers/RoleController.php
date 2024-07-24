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

class RoleController extends Controller
{
    /**
     * Rertorna todos los roles
     */
    public function index(Request $request): View
    {
        $query = Role::query();
        $pageSize = $request->input('page_size', 5);
        $roles = $query->paginate($pageSize);

        return view('app.app_pages.roles', compact('roles'));
    }
    /**
     * Crea un nuevo rol, primero se valida que no exista uno con el mismo nombre.
     * De no ser el caso, se procede a su creación y redirección al dashboard, con
     * el fin de actualizar la información en pantalla.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
        ], [
            'name.unique' => 'Ya existe un rol con este nombre.'
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('roles_page')->with('success', 'Rol creado correctamente.');
    }

    /**
     * Actualizar un rol
     * @param $id del rol a actualizar
     * Se verifica y valida que no haya coincidencia con otro rol
     * También se verifica que no existan usuarios bajo ese rol antes de poder cambiarlo
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
        ], [
            'name.unique' => 'Ya existe un rol con este nombre.'
        ]);

        $role = Role::where('id', $id)->first();
        $users = $role->users;
        if ($users->count() > 0) {
            return redirect()->route('roles_page')->with('error', 'No puedes actualizar un Rol con usuarios adjuntos.');
        } else {
            $role->update([
                'name' => $request->name,
            ]);
            return redirect()->route('roles_page')->with('success', 'Rol actualizado correctamente.');
        }
    }

    /**
     * Elimina un rol en base a su id
     * @param $id del rol a eliminar
     * Si existen usuarios adjuntos a ese rol, no se podrá eliminar el rol.
     */
    public function destroy($id)
    {
        $role = Role::where('id', $id)->first();
        $users = $role->users;
        if ($users->count() > 0) {
            return redirect()->route('roles_page')->with('error', 'No puedes borrar un rol con usuarios adjuntos.');
        } else {
            $role->delete();
            return redirect()->route('roles_page')->with('success', 'Rol eliminado con éxito.');
        }
    }
}
