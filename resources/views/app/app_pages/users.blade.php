<script>
    var users = @json($users);
</script>

<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="rounded bg-white p-4">
            <div class="flex items-center justify-center">
                <h1 class="text-4xl">Usuarios</h1>
            </div>
            <!-- Response message -->
            <div id="response-message" class="flex flex-col items-center justify-center text-green-500">
                {{ session('success') }}
            </div>
            <div id="response-message" class="flex flex-col items-center justify-center text-red-500">
                {{ session('error') }}
            </div>
            <!--display errors-->
            @if ($errors->any())
                <!-- Errors -->
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- User Table -->
            <div id="user-table-container" class="mb-8 flex flex-col justify-center items-center">
                <div class="flex items-start my-4 gap-4">
                    <!-- Filter input -->
                    <form class="flex gap-4 m-0" action="{{ route('get_users') }}" method="GET">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-2">
                                <input class="border-grey-300 border-2 rounded p-1" type="text" name="search"
                                    placeholder="Buscar proyectos..." value="{{ request('search') }}">
                                <button
                                    class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto"
                                    type="submit">Buscar</button>
                            </div>
                            <div class="flex flex-col">
                                <Label class="font-bold" for="type">Tipo de Usuario</Label>
                                <select class="border-grey-300 border-2 rounded p-1" id="type" name="type"
                                    placeholder="Rol...">
                                    <option value="">Todos</option>
                                    @foreach ($roles as $role) {
                                        <option value="{{$role->name}}">{{$role->name}}
                                        </option>
                                        }

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <form class="flex gap-4 m-0" action="{{ route('get_leads') }}" method="GET">
                        <div class="flex items-center justify-center">
                            <button
                                class="inline-flex w-full justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500"
                                id="refresh_table_button" label="actualizar" type="submit">
                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                    <path fill="white"
                                        d="M480-160q-134 0-227-93t-93-227q0-134 93-227t227-93q69 0 132 28.5T720-690v-110h80v280H520v-80h168q-32-56-87.5-88T480-720q-100 0-170 70t-70 170q0 100 70 170t170 70q77 0 139-44t87-116h84q-28 106-114 173t-196 67Z" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Create button -->
                    <button id="create_user_button"
                        class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500">
                        Crear Usuario
                    </button>
                </div>

                <!-- users table -->
                <div class="overflow-auto w-full flex items-center lg:justify-center flex-col">
                    <div class="min-h-[25rem] overflow-auto w-fit flex flex-col items-center max-h-80">
                        <table id="client_table">
                            <tr class="">
                                <td class="first:rounded-l px-4 py-2 bg-blue-500 text-white">ID</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Rol</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Nombre</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Corre electrónico</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Created At</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Updated At</td>
                                <td class="bg-blue-500 text-white rounded-r px-4 py-2"></td>
                            </tr>
                            @if($users->count())
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $user->id }}</td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            {{ $user->role->name }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $user->name }}</td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative break-all max-w-80">
                                            {{ $user->email }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            {{ $user->created_at }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            {{ $user->updated_at }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            <div class="flex flex-wrap gap-2">
                                                <div>
                                                    <button id="edit_user" label="editar"
                                                        class="inline-flex w-full justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500">
                                                        <svg width="24" height="24" viewBox="0 -960 960 960">
                                                            <path fill="white"
                                                                d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <form class="m-0" action="{{ route('destroy_users', $user->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="delete_user" label="eliminar"
                                                        class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500"
                                                        type="submit">
                                                        <svg width="24" height="24" viewBox="0 -960 960 960">
                                                            <path fill="white"
                                                                d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        @if(!$users->count())
                            <div>
                                <h1>* No hay Datos *</h1>
                            </div>
                        @endif
                    </div>

                    @if($users->count())
                        <div class="flex items-center justify-center w-full mt-8 gap-8">
                            {{$users->appends(request()->except('page'))->links('vendor.pagination.tailwind')}}
                            @if ($users->lastPage() > 1 || $users->count() > 5)
                                <form class="flex items-center justify-center gap-2" method="GET"
                                    action="{{ route('users_page') }}" class="mb-4">
                                    <label for="page_size">Elementos:</label>
                                    <select id="page_size" class="border-grey-300 border-2 rounded p-1" name="page_size"
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

                    <!-- Edit/Create user dialog -->
                    @if ($errors->any())
                        <x-user_dialog id="user_dialog" class="block" :roles="$roles"></x-user_dialog>
                    @else
                        <x-user_dialog id="user_dialog" class="hidden" :roles="$roles"></x-user_dialog>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/users.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>