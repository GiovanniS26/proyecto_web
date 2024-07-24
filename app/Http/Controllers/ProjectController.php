<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de proyecto
     */
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('user')) {
            $query = Project::query();

            $search = $request->input('search', '');
            $status = $request->input('status', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('start_date', 'like', "%$search%")
                        ->orWhere('end_date', 'like', "%$search%");
                });
            }

            if (!empty($status)) {
                $query->where('status', $status);
            }

            if (auth()->user()->hasRole('admin')) {
                $users = User::all();

            } else {
                $role_id = Role::where('name', 'user')->first()->id;
                $users = User::where('role_id', $role_id)->get();
            }

            $pageSize = $request->input('page_size', 5);
            $projects = $query->paginate($pageSize);

            return view('app.app_pages.projects', compact('projects', 'users'));
        } else {
            return view('app.client_dashboard');
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

        $project = Project::create($validatedData);

        // Agregar miembros al proyecto
        if ($request->has('members')) {
            $project->members()->sync($request->input('members'));
        }

        return redirect()->route('projects_page')->with('success', 'Proyecto creado exitosamente.');
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
        $project = Project::findOrFail($id);

        if (!$project) {
            return redirect()->route('projects_page')->with('error', 'Proyecto no encontrado.');
        }

        $project->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        // Actualizar miembros del proyecto
        if ($request->has('members')) {
            $project->members()->sync($request->input('members'));
        } else {
            // Si no hay miembros proporcionados, eliminar todos los miembros del proyecto
            $project->members()->sync([]);
        }

        return redirect()->route('projects_page')->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy($id)
    {  
        $project = Project::findOrFail($id);
        
        if (!$project) {
            return redirect()->route('projects_page')->with('error', 'Proyecto no encontrado.');
        }
        
        $project->members()->sync([]);
        $project->delete();
        return redirect()->route('projects_page')->with('success', 'Proyecto eliminado exitosamente.');
    }

    public function details(Request $request, $id)
    {
        $project = Project::with('members', 'tasks')->findOrFail($id);
        
        if (!$project) {
            return redirect()->route('projects_page')->with('error', 'Proyecto no encontrado.');
        }
        
        $members = $project->members;

        $query = Task::query();

        $search = $request->input('search', '');
        $status = $request->input('status', '');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('due_date', 'like', "%$search%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });
        }

        $query->where('project_id', $id);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $pageSize = $request->input('page_size', 5);
        $tasks = $query->with('project', 'user')->paginate($pageSize);
        
        return view('app.app_pages.project_details', compact('project', 'members', 'tasks'));
    }
}
