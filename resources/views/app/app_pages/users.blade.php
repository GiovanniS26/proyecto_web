<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="flex gap-4">
            <div id="table_container" class="p-8 bg-white rounded w-full">
                <div id="response-message" class="flex flex-col items-center justify-center">
                    {{ session('response') }}
                </div>

                <!-- User Table -->
                <div id="users-table-container" class="mb-8">
                    <h1 class="text-4xl bold mb-8">Usuarios</h1>
                    <div class="flex my-4 items-center gap-4">
                        <button id="create_users_button"
                            class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500">
                            Create User
                        </button>
                        <button id="refresh_users_button"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500">
                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                <path fill="white"
                                    d="M480-160q-134 0-227-93t-93-227q0-134 93-227t227-93q69 0 132 28.5T720-690v-110h80v280H520v-80h168q-32-56-87.5-88T480-720q-100 0-170 70t-70 170q0 100 70 170t170 70q77 0 139-44t87-116h84q-28 106-114 173t-196 67Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="overflow-auto w-full flex flex-col items-center lg:justify-center">
                        <div class="overflow-auto w-fit flex flex-col items-center max-h-80">
                            <table id="client_table">
                                <tr class="">
                                    <td class="first:rounded-l px-4 py-2 bg-red-500 text-white">ID</td>
                                    <td class="px-4 py-2 bg-red-500 text-white">Rol</td>
                                    <td class="px-4 py-2 bg-red-500 text-white">Nombre</td>
                                    <td class="px-4 py-2 bg-red-500 text-white">Corre electrónico</td>
                                    <td class="px-4 py-2 bg-red-500 text-white">Created At</td>
                                    <td class="px-4 py-2 bg-red-500 text-white">Updated At</td>
                                    <td class="bg-red-500 text-white rounded-r px-4 py-2"></td>
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
                                                        <button id="edit_client" name="editar"
                                                            class="inline-flex w-full justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500">
                                                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                <path fill="white"
                                                                    d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <form class="m-0" action="{{ route('destroy_clients', $user->id) }}"
                                                        method="DELETE" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button id="delete_client" name="eliminar"
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
                        </div>
                        @if($users->count())
                            <div class="flex items-center justify-center w-full mt-8 gap-8">
                                {{$users->appends(request()->except('page'))->links('vendor.pagination.tailwind')}}
                                @if ($users->lastPage() > 1 || $users->count() > 4)
                                    <form class="flex items-center justify-center gap-2" method="GET"
                                        action="{{ route('users_page') }}" class="mb-4">
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
                        @if (!$users->count())
                            <div>
                                <h1>* No hay Datos *</h1>
                            </div>
                        @endif

                        @if ($errors->any())
                            <!-- Edit/Create user dialog -->
                            <x-client_dialog class="block"></x-client_dialog>
                        @else
                            <!-- Edit/Create user dialog -->
                            <x-client_dialog id="client_dialog" class="hidden"></x-client_dialog>
                        @endif
                    </div>
                </div>

                <!-- Role Table -->
                <div id="roles-table-container">
                    <h1 class="text-4xl bold mb-8">Roles</h1>
                    <div class="flex my-4 items-center gap-4">
                        <button id="create_roles_button"
                            class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500">Create
                            Role</button>
                        <button id="refresh_roles_button"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500">
                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                <path fill="white"
                                    d="M480-160q-134 0-227-93t-93-227q0-134 93-227t227-93q69 0 132 28.5T720-690v-110h80v280H520v-80h168q-32-56-87.5-88T480-720q-100 0-170 70t-70 170q0 100 70 170t170 70q77 0 139-44t87-116h84q-28 106-114 173t-196 67Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="overflow-auto w-full">
                        <table id="roles_table"></table>
                    </div>
                </div>

                <!-- Dialog -->
                @if (count($errors->get('email')))
                    <x-user_dialog class="block" :action="'users'"></x-user_info>
                @elseif(count($errors->get('name')))
                    <x-role_dialog class="block" :action="'roles'"></x-role_info>
                @else   

                     <x-user_dialog class="hidden" :action="'users'"></x-user_info>
                            <x-role_dialog class="hidden" :action="'roles'"></x-role_info>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin_info.js') }}"></script>
</x-app-layout>