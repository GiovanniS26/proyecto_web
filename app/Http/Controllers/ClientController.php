<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Retorna la vista del dashboard según el rol,
     * si es Admin podrá ver el dashboard de admin, sino
     * se le mostrará el dashboard de cliente
     */
    public function index(Request $request): View
    {
        if (auth()->user()->hasRole('admin')) {
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

        return redirect()->route('clients_page')->with('success', 'Client created successfully.');
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
        $client_updated = $client->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'type' => $validatedData['type'],
            'birthdate' => $validatedData['birthdate']
        ]);

        Log::info('Data from Controller:', [$client_updated]);

        return redirect()->route('clients_page')->with('success', 'Client updated successfully.');
    }

    /*     public function index(){
            $clients = Client::all();
            return view('clientes.index', compact('clients'));
        } */

    public function show(Client $client)
    {
        //$cliente = Client::findOrFail($id); //parametro $id si no funciona de la otra forma, lo mismo va con update, destroy y demas
        //return $cliente
        return view('clientes.show', compact('client'));
    }

    /*     public function create(){
            return view('clientes.create');
        } */
    /*     public function store(Request $request){  //registrar cliente
            $validatedDate = $request->validate([
                'name' => 'required|max:40',
                'email' => 'email|required|unique:users',
                'phone' => 'required|max:11',
                'type' => 'required|in:enterprise,user',
                'direccion'=> 'required|max:200',
                'date' => 'date|required',
            ]);
            Client::create($request->all());
            $clients = Client::all();
            return view('clientes.index', compact('clients'))->with('added', 'client added successfully');
            //return Redirect::to('clientes.index', compact('clients'))->with('success', 'cliente agregado correctamente');
        } */

    public function destroy(Client $client)
    {  //borrar cliente
        $client->delete();
        $clients = Client::all();
        return view('clientes.index', compact('clients'))->with('success', 'client deleted successfully');
    }


    /////////////7777777para los tickets/////////////////////////////////////


}
