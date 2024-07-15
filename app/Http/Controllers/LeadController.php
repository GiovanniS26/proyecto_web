<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de proyecto
     */
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin')) {
            $query = Lead::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('status', 'like', strtolower($search) === 'activo' ? 'active' : (strtolower($search) === 'detenido' ? 'paused' : 'dropped'))
                        ->orWhere('start_date', 'like', "%$search%")
                        ->orWhere('end_date', 'like', "%$search%");
                });
            }

            $users = User::all();

            $pageSize = $request->input('page_size', 5);
            $projects = $query->paginate($pageSize);

            return view('app.app_pages.projects', compact('projects', 'users'));
        } else if (auth()->user()->hasRole('user')) {
            $query = Lead::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%")
                        ->orWhere('start_date', 'like', "%$search%")
                        ->orWhere('end_date', 'like', "%$search%");
                });
            }

            // Obtener el ID del rol "users"
            $role_id = Role::where('name', 'user')->first()->id;

            // Obtener la lista de usuarios con el rol "users"
            $users = User::where('role_id', $role_id)->get();

            $pageSize = $request->input('page_size', 5);
            $projects = $query->paginate($pageSize);

            return view('app.app_pages.projects', compact('projects', 'users'));
        } else {
            return view('app.user_dashboard');
        }
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:projects',
            'description' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ], [
            'title.unique' => 'Ya existe un Proyecto con este titulo.'
        ]);

        // Añade el created_by_user_id después de la validación
        $validatedData['created_by_user_id'] = auth()->user()->id;

        $lead = Lead::create($validatedData);

        // Agregar miembros al proyecto
        if ($request->has('members')) {
            $lead->members()->sync($request->input('members'));
        }

        Lead::create($validatedData);

        return redirect()->route('projects_page')->with('success', 'lead created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:projects,title,' . $id,
            'description' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ], [
            'title.unique' => 'Ya existe un Proyecto con este titulo.'
        ]);

        // Encontrar y actualizar el proyecto
        $lead = Lead::findOrFail($id);
        $project_updated = $lead->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        // Actualizar miembros del proyecto
        if ($request->has('members')) {
            $lead->members()->sync($request->input('members'));
        } else {
            // Si no hay miembros proporcionados, eliminar todos los miembros del proyecto
            $lead->members()->sync([]);
        }

        Log::info('Data from Controller:', [$project_updated]);

        return redirect()->route('projects_page')->with('success', 'lead updated successfully.');
    }

    public function members($id)
    {
        $lead = Lead::findOrFail($id);

        // Obtener la lista de usuarios asignados al proyecto
        $assignedUsers = $lead->members->pluck('id')->toArray();

        return response()->json([
            'assignedUsers' => $assignedUsers,
        ]);
    }

    public function destroy(Lead $lead)
    {  //borrar proyecto
        $lead->members()->sync([]);
        $lead->delete();
        return redirect()->route('projects_page')->with('success', 'Project deleted successfully.');
    }

}
