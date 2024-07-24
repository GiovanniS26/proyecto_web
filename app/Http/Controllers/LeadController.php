<?php

namespace App\Http\Controllers;

use App\Models\LeadStatus;
use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('user')) {
            $query = Lead::with('status');

            $search = $request->input('search', '');
            $statusFilter = $request->input('status', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('lastname', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('country', 'like', "%$search%")
                        ->orWhere('city', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhereHas('status', function ($q) use ($search) {
                            $q->where('name', 'like', "%$search%"); // Buscar en la tabla lead_statuses
                        });
                });
            }

            // Filtra por el estado seleccionado
            if (!empty($statusFilter)) {
                $status = LeadStatus::where('name', $statusFilter)->first();
                if ($status) {
                    $query->where('status_id', $status->id);
                }
            }

            $pageSize = $request->input('page_size', 5);
            $leads = $query->paginate($pageSize);

            $statuses = LeadStatus::all();

            return view('app.app_pages.leads', compact('leads', 'statuses'));
        }
        return view('app.user_dashboard');
    }

    public function store(Request $request): View
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:15',
            'city' => 'required|string|max:15',
            'phone' => 'required|string|max:15',
        ]);

        $existingLead = Lead::where('email', $validatedData['email'])->first();

        if ($existingLead) {
            // Si el email ya existe, asignar estado "Duplicado"
            $validatedData['status_id'] = 15;
        } else {
            // Si el email no existe, asignar estado "Nuevo"
            $validatedData['status_id'] = 1;
        }

        Lead::create($validatedData);

        return view('pages.info', ['success' => 'Hemos recibido su información. Alguien de nuestro departamento lo contactará pronto.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|integer|exists:lead_statuses,id',
        ]);

        $lead = Lead::find($id);

        if (!$lead) {
            return redirect()->route('leads_page')->with('error', 'Lead no encontrado.');
        }

        $lead->status_id = $request->input('status_id');
        $lead->save();

        return redirect()->route('leads_page')->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);

        if (!$lead) {
            return redirect()->route('leads_page')->with('error', 'Lead no encontrado.');
        }
        
        $lead->delete();
        return redirect()->route('leads_page')->with('success', 'Lead eliminado exitosamente.');
    }
}
