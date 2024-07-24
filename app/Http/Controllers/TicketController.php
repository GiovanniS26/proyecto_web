<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Role;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de ticket
     */
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin')) {
            $query = Ticket::query();

            $search = $request->input('search', '');
            $status = $request->input('status', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                });
            }

            if (!empty($status)) {
                $query->where('status', $status);
            }

            $users = User::all();

            $pageSize = $request->input('page_size', 5);
            $tickets = $query->with('user')->paginate($pageSize);

            return view('app.app_pages.tickets', compact('tickets', 'users'));
        } else if (auth()->user()->hasRole('user')) {
            $query = Ticket::with('user');

            // Filtrar por user_id del usuario autenticado
            $userId = auth()->user()->id;
            $query->where('user_id', $userId);

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('status', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                });
            }

            $role_id = Role::where('name', 'user')->first()->id;
            $users = User::where('role_id', $role_id)->get();

            $pageSize = $request->input('page_size', 5);
            $tickets = $query->with('user')->paginate($pageSize);
            
            return view('app.app_pages.tickets', compact('tickets', 'users'));
        } else {
            return view('app.client_dashboard');
        }
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'user_id' => 'nullable|exists:users,id'
        ]);

        // Añade el created_by_user_id después de la validación
        $validatedData['created_by_user_id'] = auth()->user()->id;

        Ticket::create($validatedData);

        return redirect()->route('tickets_page')->with('success', 'Ticket creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
        ]);

        // Encontrar y actualizar el ticket
        $ticket = Ticket::findOrFail($id);
        
        if (!$ticket) {
            return redirect()->route('tickets_page')->with('error', 'Ticket no encontrado.');
        }
        
        $ticket->update([
            'subject' => $validatedData['subject'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'user_id' => $validatedData['user_id']
        ]);

        return redirect()->route('tickets_page')->with('success', 'Ticket actualizado exitosamente.');
    }

    public function resolve($id)
    {
        // Encontrar y actualizar el ticket
        $ticket = Ticket::findOrFail($id);
        
        if (!$ticket) {
            return redirect()->route('tickets_page')->with('error', 'Ticket no encontrado.');
        }
        
        $ticket->update([
            'status' => 'resolved',
        ]);

        return redirect()->route('tickets_page')->with('success', 'Ticket actualizado exitosamente.');
    }

    public function close($id)
    {
        // Encontrar y actualizar el ticket
        $ticket = Ticket::findOrFail($id);
        
        if (!$ticket) {
            return redirect()->route('tickets_page')->with('error', 'Ticket no encontrado.');
        }
        
        $ticket->update([
            'status' => 'closed',
        ]);

        return redirect()->route('tickets_page')->with('success', 'Ticket actualizado exitosamente.');
    }

    public function destroy(Ticket $ticket)
    {  //borrar ticket
        $ticket->delete();
        return redirect()->route('tickets_page')->with('success', 'Ticket eliminado exitosamente.');
    }

}
