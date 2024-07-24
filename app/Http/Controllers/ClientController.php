<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('user')) {
            $query = Client::query();

            $search = $request->input('search', '');
            $type = $request->input('type', '');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhere('birthdate', 'like', "%$search%");
                });
            }

            if (!empty($type)) {
                $query->where('type', $type);
            }

            $pageSize = $request->input('page_size', 5);
            $clients = $query->paginate($pageSize);

            return view('app.app_pages.clients', compact('clients'));
        }
        return view('app.user_dashboard');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'birthdate' => 'nullable|date',
        ], [
            'name.email' => 'Ya existe un cliente con este correo electrónico.'
        ]);

        Client::create($validatedData);

        return redirect()->route('clients_page')->with('success', 'Cliente creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'birthdate' => 'nullable|date',
        ], [
            'name.email' => 'Ya existe un cliente con este correo electrónico.'
        ]);

        // Encontrar y actualizar el cliente
        $client = Client::findOrFail($id);

        if (!$client) {
            return redirect()->route('clients_page')->with('error', 'Cliente no encontrado.');
        }
        
        $client_updated = $client->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'type' => $validatedData['type'],
            'birthdate' => $validatedData['birthdate']
        ]);

        Log::info('Data from Controller:', [$client_updated]);

        return redirect()->route('clients_page')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        if (!$client) {
            return redirect()->route('clients_page')->with('error', 'Cliente no encontrado.');
        }
        
        $client->delete();
        return redirect()->route('clients_page')->with('success', 'Cliente eliminado exitosamente.');
    }
}
