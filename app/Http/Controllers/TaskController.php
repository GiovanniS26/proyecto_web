<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    // Mostrar lista de tareas
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('user')) {
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
                        })
                        ->orWhereHas('project', function ($query) use ($search) {
                            $query->where('title', 'like', "%$search%");
                        });
                });
            }

            if (!empty($status)) {
                $query->where('status', $status);
            }

            $users = User::all();

            $pageSize = $request->input('page_size', 5);
            $tasks = $query->with('project', 'user')->paginate($pageSize);

            return view('app.app_pages.tasks', compact('tasks', 'users'));
        } else {
            return view('app.client_dashboard');
        }
    }

    // Mostrar formulario para crear nueva tarea
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    // Guardar nueva tarea
    public function store(Request $request, $project_id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $validatedData['project_id'] = $project_id;

        Task::create($validatedData);

        return redirect()->route('project_details', ['id' => $project_id])->with('success', 'Tarea creada exitosamente.');
    }

    // Actualizar tarea existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);
        $task = Task::findOrFail($id);
        
        if (!$task) {
            return redirect()->route('project_details', ['id' => $task->project_id])->with('error', 'Tarea no encontrada.');
        }
        
        $task->update($request->all());

        return redirect()->route('project_details', ['id' => $task->project_id])->with('success', 'Tarea actualizada exitosamente.');
    }

    // Eliminar tarea existente
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        
        if (!$task) {
            return redirect()->route('project_details', ['id' => $task->project_id])->with('error', 'Tarea no encontrada.');
        }
        
        $task->delete();

        return redirect()->route('project_details', ['id' => $task->project_id])->with('success', 'Tarea eliminada exitosamente.');
    }

    public function change_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = Task::findOrFail($id);
        
        if (!$task) {
            return redirect()->route('project_details', ['id' => $task->project_id])->with('error', 'Tarea no encontrada.');
        }
        
        $task->update(['status' => $request['status']]);

        return redirect()->route('project_details', ['id' => $task->project_id])->with('success', 'Tarea actualizada exitosamente.');
    }
}
