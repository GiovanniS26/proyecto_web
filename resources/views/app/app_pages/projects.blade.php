<script>
    var projects = @json($projects);
</script>

<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="rounded bg-white p-4">
            <div class="flex items-center justify-center">
                <h1 class="text-4xl">Proyectos</h1>
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
            <div id="project-table-container" class="mb-8 flex flex-col justify-center items-center">
                <div class="flex items-start my-4 gap-4">
                    <!-- Filter input -->
                    <form class="flex gap-4 m-0" action="{{ route('get_projects') }}" method="GET">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-2">
                                <input class="border-grey-300 border-2 rounded p-1" type="text" name="search"
                                    placeholder="Buscar proyectos..." value="{{ request('search') }}">
                                <button
                                    class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto"
                                    type="submit">Buscar</button>
                            </div>
                            <div class="flex flex-col">
                                <Label class="font-bold" for="type">Estado del Proyecto</Label>
                                <select class="border-grey-300 border-2 rounded p-1" name="status">
                                    <option value="">Todos</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>
                                        Detenido
                                    </option>
                                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>
                                        Abandonado
                                    </option>
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
                    <button id="create_project_button"
                        class="inline-flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500">
                        Crear Proyecto
                    </button>
                </div>

                <!-- Projects table -->
                <div class="overflow-auto w-full flex items-center lg:justify-center flex-col">
                    <div class="min-h-[25rem] overflow-auto w-fit flex flex-col items-center max-h-80">
                        <table id="project_table">
                            <tr>
                                <td class="first:rounded-l px-4 py-2 bg-blue-500 text-white">ID</td>
                                <td class="first:rounded-l px-4 py-2 bg-blue-500 text-white">Titulo</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Descripción</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Estado</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Fecha de inicio</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Fecha de entrega</td>
                                <td class="px-4 py-2 bg-blue-500 text-white">Fecha de creación</td>
                                <td class="bg-blue-500 text-white rounded-r px-4 py-2"></td>

                            </tr>
                            @if($projects->count())
                                @foreach ($projects as $project)
                                    <tr>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $project->id }}</td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $project->title }}</td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative break-all max-w-80">
                                            {{ $project->description }}
                                        </td>
                                        <td
                                            class="border-b border-gray-300 p-4 bg-gray-100 relative text-{{$project->status === 'active' ? 'emerald' : 'red'}}-500">
                                            @if ($project->status === 'active')
                                                Activo
                                            @elseif ($project->status === 'paused')
                                                Detenido
                                            @else
                                                Abandonado
                                            @endif
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            {{ $project->start_date }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $project->end_date }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $project->created_at }}
                                        </td>
                                        <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                            <div class="flex flex-wrap gap-2">
                                                <form class="m-0" action="{{ route('project_details', $project->id) }}"
                                                    method="GET" style="display:inline-block;">
                                                    @csrf
                                                    <button id="action_button" label="detalles"
                                                        class="inline-flex w-fit text-center justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500"
                                                        type="submit">
                                                        <svg width="24" height="24" viewBox="0 -960 960 960">
                                                            <path fill="white"
                                                                d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @if (Auth::user()->role->name == "admin")
                                                    <div>
                                                        <button id="action_button" name="edit_button" label="editar"
                                                            class="relative inline-flex w-fit text-center justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500">
                                                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                <path fill="white"
                                                                    d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <form class="m-0" action="{{ route('destroy_projects', $project->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button id="action_button" label="eliminar"
                                                            class="inline-flex w-fit text-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500"
                                                            type="submit">
                                                            <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                <path fill="white"
                                                                    d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        @if(!$projects->count())
                            <div>
                                <h1>* No hay Datos *</h1>
                            </div>
                        @endif
                    </div>

                    @if($projects->count())
                        <div class="flex items-center justify-center w-full mt-8 gap-8">
                            {{$projects->appends(request()->except('page'))->links('vendor.pagination.tailwind')}}
                            @if ($projects->lastPage() > 1 || $projects->count() > 5)
                                <form class="flex items-center justify-center gap-2" method="GET"
                                    action="{{ route('projects_page') }}" class="mb-4">
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

                    @if ($errors->any())
                        <!-- Edit/Create project dialog -->
                        <x-project_dialog id="project_dialog" class="block" :users="$users"></x-project_dialog>
                    @else
                        <!-- Edit/Create project dialog -->
                        <x-project_dialog id="project_dialog" class="hidden" :users="$users"></x-project_dialog>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/projects.js') }}"></script>