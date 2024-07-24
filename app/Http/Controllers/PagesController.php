<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\Lead;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de cliente
     */
    public function dashboard(): View
    {
        if (auth()->user()->hasRole('admin')) {
            $projects = Project::all()->count();
            $tasks = Task::where('status', 'pending')->count();
            $clients = Client::all()->count();
            $tickets = Ticket::all()->count();

            $leads = Lead::with('status')->orderBy('created_at', 'desc')->get();

            return view('app.admin_dashboard', compact('projects', 'tasks', 'clients', 'tickets', 'leads'));
        }

        return view('app.user_dashboard');
    }
}
