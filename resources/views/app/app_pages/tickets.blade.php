<script>
    var tickets = @json($tickets);
</script>

<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="rounded bg-white p-4">
            <div class="flex items-center justify-center">
                <h1 class="text-4xl">Tickets</h1>
            </div>
            <!-- Response message -->
            <div id="response-message" class="flex flex-col items-center justify-center">
                {{ session('success') }}
            </div>
            <!--display errors-->
            @if ($errors->any())
                <!-- Errors -->
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- User Table -->
            <div id="ticket-table-container" class="mb-8 flex flex-col justify-center items-center">
                <div class="flex items-start my-4 gap-4">
                    <!-- Filter input -->
                    <form class="flex gap-4 m-0" action="{{ route('get_tickets') }}" method="GET">
                        <div class="flex flex-col gap-2">
                            <div class="flex gap-2">
                                <input class="border-black border-2 rounded-md p-1" type="text" name="search"
                                    placeholder="Buscar proyectos..." value="{{ request('search') }}">
                                <button
                                    class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto"
                                    type="submit">Search</button>
                            </div>
                            <div class="flex flex-col">
                                <Label class="font-bold" for="type">Estado del Ticket</Label>
                                <select class="border-black border-2 rounded-md p-1" name="status">
                                    <option value="">Todos</option>
                                    <option value="active" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>
                                    <option value="paused" {{ request('status') == 'resolved' ? 'selected' : '' }}>
                                        Resuelto
                                    </option>
                                    <option value="dropped" {{ request('status') == 'closed' ? 'selected' : '' }}>
                                        Cerrado
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button
                                class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500"
                                id="refresh_table_button" name="actualizar" type="submit">
                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                    <path fill="white"
                                        d="M480-160q-134 0-227-93t-93-227q0-134 93-227t227-93q69 0 132 28.5T720-690v-110h80v280H520v-80h168q-32-56-87.5-88T480-720q-100 0-170 70t-70 170q0 100 70 170t170 70q77 0 139-44t87-116h84q-28 106-114 173t-196 67Z" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Create button -->
                    <button id="create_ticket_button"
                        class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500">
                        Create ticket
                    </button>
                </div>

                <!-- tickets table -->
                <div class="overflow-auto w-full flex items-center lg:justify-center flex-col">
                    <div class="overflow-auto w-fit flex flex-col items-center max-h-80">
                        <table id="ticket_table">
                            <tr>
                                <td class="first:rounded-l px-4 py-2 bg-red-500 text-white">Asunto</td>
                                <td class="px-4 py-2 bg-red-500 text-white">Descripción</td>
                                <td class="px-4 py-2 bg-red-500 text-white">Estado</td>
                                <td class="px-4 py-2 bg-red-500 text-white">Asignado</td>
                                <td class="px-4 py-2 bg-red-500 text-white">Fecha de creación</td>
                                <td class="bg-red-500 text-white rounded-r px-4 py-2"></td>

                            </tr>
                            @if($tickets->count())
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $ticket->subject }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative break-all max-w-80">
                                            {{ $ticket->description }}
                                        </td>
                                        <td
                                            class="border-b border-gray-300 p-4 bg-gray-100 relative text-{{$ticket->status === 'resolved' ? 'emerald' : ($ticket->status === 'closed' ? 'red' : 'yellow')}}-500">
                                            @if ($ticket->status === 'pending')
                                                Pendiente
                                            @elseif ($ticket->status === 'resolved')
                                                Resuelto
                                            @else
                                                Cerrado
                                            @endif
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            @if ($ticket->user)
                                                {{ $ticket->user->email }}
                                            @else
                                                Sin Asignar
                                            @endif
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $ticket->created_at }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            @if (Auth::user()->role->name == "admin")
                                                <div class="flex flex-wrap gap-2">
                                                    <div>
                                                        <button id="edit_ticket" name="editar"
                                                            class="relative inline-flex w-fit text-center justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500">
                                                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                <path fill="white"
                                                                    d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <form class="m-0" action="{{ route('destroy_tickets', $ticket->id) }}"
                                                        method="DELETE" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button id="delete_ticket" name="eliminar"
                                                            class="inline-flex w-fit text-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500"
                                                            type="submit">
                                                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                <path fill="white"
                                                                    d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                @if ($ticket->status === 'pending')
                                                    <div class="m-0 flex flex-wrap gap-2">
                                                        <form action="{{ route('resolve_tickets', $ticket->id) }}" method="POST">
                                                            @csrf
                                                            <button id="resolve_ticket" name="resolver" type="submit"
                                                                class="relative inline-flex w-fit text-center justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500">
                                                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                    <path fill="white"
                                                                        d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z" />
                                                                </svg>
                                                            </button>
                                                            <form class="m-0 flex flex-wrap gap-2"
                                                                action="{{ route('close_tickets', $ticket->id) }}" method="POST">
                                                                <button id="close_ticket" name="cerrar" type="submit"
                                                                    class="relative inline-flex w-fit text-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500">
                                                                    <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                        <path fill="white"
                                                                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>

                    @if($tickets->count())
                        <div class="flex items-center justify-center w-full mt-8 gap-8">
                            {{$tickets->appends(request()->except('page'))->links('vendor.pagination.tailwind')}}
                            @if ($tickets->lastPage() > 1 || $tickets->count() > 5)
                                <form class="flex items-center justify-center gap-2" method="GET"
                                    action="{{ route('tickets_page') }}" class="mb-4">
                                    <label for="page_size">Elementos:</label>
                                    <select id="page_size" class="border-black border-2 rounded-md p-1" name="page_size"
                                        onchange="this.form.submit()">
                                        <option value="5" {{ request('page_size') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('page_size') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('page_size') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('page_size') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </form>
                            @endif
                        </div>
                    @endif
                    @if(!$tickets->count())
                        <div>
                            <h1>* No hay Datos *</h1>
                        </div>
                    @endif
                    @if ($errors->any())
                        <!-- Edit/Create ticket dialog -->
                        <x-ticket_dialog id="ticket_dialog" class="block" :users="$users"></x-ticket_dialog>
                    @else
                        <!-- Edit/Create ticket dialog -->
                        <x-ticket_dialog id="ticket_dialog" class="hidden" :users="$users"></x-ticket_dialog>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/tickets.js') }}"></script>