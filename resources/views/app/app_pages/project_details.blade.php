<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="rounded bg-white p-4">
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
            <div class="container mx-auto p-4">
                <h1 class="text-4xl font-bold mb-4">{{ $project->title }}</h1>
                <p class="mb-4">{{ $project->description }}</p>

                <h2 class="text-xl font-semibold mb-2">Miembros del Proyecto</h2>
                <ul class="list-disc pl-5 mb-4">
                    @foreach($members as $member)
                        <li>{{ $member->name }}</li>
                    @endforeach
                </ul>

                <h2 class="text-xl font-semibold mb-2">Tareas del Proyecto</h2>

                <div class="flex items-center justify-center">
                    <h1 class="text-4xl">Tareas</h1>
                </div>

                <!-- User Table -->
                <div id="task-table-container" class="mb-8 flex flex-col justify-center items-center">
                    <div class="flex items-start my-4 gap-4">
                        <!-- Filter input -->
                        <form class="flex gap-4 m-0" action="{{ route('project_details', $project->id) }}" method="GET">
                            <div class="flex items-center gap-2">
                                <div class="flex gap-2">
                                    <input class="border-grey-300 border-2 rounded p-1" type="text" name="search"
                                        placeholder="Buscar tasks..." value="{{ request('search') }}">
                                    <button
                                        class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto"
                                        type="submit">Buscar</button>
                                </div>
                                <div class="flex flex-col">
                                    <Label class="font-bold" for="status">Estado de la tarea</Label>
                                    <select class="border-grey-300 border-2 rounded p-1" name="status">
                                        <option value="">Todos</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="in_progress">En Progreso</option>
                                        <option value="completed">Completado</option>
                                    </select>
                                </div>
                            </div>

                        </form>
                        <form class="flex gap-4 m-0" action="{{ route('project_details', $project->id) }}" method="GET">
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
                    </div>

                    <!-- Projects table -->
                    <div class="overflow-auto w-full flex items-center lg:justify-center flex-col">
                        <div class="min-h-[25rem] overflow-auto w-fit flex flex-col items-center max-h-80">
                            <table id="task_table">
                                <tr>
                                    <td class="first:rounded-l px-4 py-2 bg-blue-500 text-white">ID</td>
                                    <td class="first:rounded-l px-4 py-2 bg-blue-500 text-white">Titulo</td>
                                    <td class="px-4 py-2 bg-blue-500 text-white">Descripción</td>
                                    <td class="px-4 py-2 bg-blue-500 text-white">Fecha de entrega</td>
                                    <td class="px-4 py-2 bg-blue-500 text-white">Proyecto</td>
                                    <td class="px-4 py-2 bg-blue-500 text-white">Usuario asignado</td>
                                    <td class="px-4 py-2 bg-blue-500 text-white">Estado</td>
                                    <td class="bg-blue-500 text-white rounded-r px-4 py-2"></td>

                                </tr>
                                @if($tasks->count())
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $task->id }}</td>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative">{{ $task->title }}
                                            </td>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative break-all max-w-80">
                                                {{ $task->description }}
                                            </td>
                                            <td
                                                class="border-b border-gray-300 p-4 bg-gray-100 relative text-{{$task->status === 'active' ? 'emerald' : 'blue'}}-500">
                                                {{$task->due_date}}
                                            </td>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                                {{ $task->project ? $task->project->title : 'No asignado' }}
                                            </td>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                                {{ $task->user ? $task->user->name : 'No asignado' }}
                                            </td>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                                @if ($task->status === 'pending')
                                                    Pendiente
                                                @elseif ($task->status === 'in_progress')
                                                    En Progreso
                                                @else
                                                    Completado
                                                @endif
                                            </td>
                                            <td class="border-b border-gray-300 p-4 bg-gray-100 relative">
                                                <div class="flex flex-wrap gap-2">
                                                    @if (Auth::user()->role->name == "admin")
                                                        <div>
                                                            <button id="edit_task" label="editar"
                                                                class="relative inline-flex w-fit text-center justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500">
                                                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                    <path fill="white"
                                                                        d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <form class="m-0" action="{{ route('destroy_tasks', $task->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="delete_task" label="eliminar"
                                                                class="inline-flex w-fit text-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:w-auto disabled:bg-gray-500"
                                                                type="submit">
                                                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                    <path fill="white"
                                                                        d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @elseif ($task->user_id === Auth::user()->id)
                                                        <form class="m-0" action="{{ route('change_status_tasks', $task->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button id="status_task" label="pendiente"
                                                                class="inline-flex w-fit text-center justify-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 sm:w-auto disabled:bg-gray-500"
                                                                name="status" value="pending" type="submit">
                                                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                    <path fill="white"
                                                                        d="M280-420q25 0 42.5-17.5T340-480q0-25-17.5-42.5T280-540q-25 0-42.5 17.5T220-480q0 25 17.5 42.5T280-420Zm200 0q25 0 42.5-17.5T540-480q0-25-17.5-42.5T480-540q-25 0-42.5 17.5T420-480q0 25 17.5 42.5T480-420Zm200 0q25 0 42.5-17.5T740-480q0-25-17.5-42.5T680-540q-25 0-42.5 17.5T620-480q0 25 17.5 42.5T680-420ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <form class="m-0" action="{{ route('change_status_tasks', $task->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button id="status_task" label="en progreso"
                                                                class="inline-flex w-fit text-center justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 sm:w-auto disabled:bg-gray-500"
                                                                name="status" value="in_progress" type="submit">
                                                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                    <path fill="white"
                                                                        d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <form class="m-0" action="{{ route('change_status_tasks', $task->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            <button id="status_task" label="completado"
                                                                class="inline-flex w-fit text-center justify-center rounded-md bg-emerald-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 sm:w-auto disabled:bg-gray-500"
                                                                name="status" value="completed" type="submit">
                                                                <svg width="24" height="24" viewBox="0 -960 960 960">
                                                                    <path fill="white"
                                                                        d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z" />
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
                            @if(!$tasks->count())
                                <div>
                                    <h1>* No hay Datos *</h1>
                                </div>
                            @endif
                        </div>

                        @if($tasks->count())
                            <div class="flex items-center justify-center w-full mt-8 gap-8">
                                {{$tasks->appends(request()->except('page'))->links('vendor.pagination.tailwind')}}
                                @if ($tasks->lastPage() > 1 || $tasks->count() > 5)
                                    <form class="flex items-center justify-center gap-2" method="GET"
                                        action="{{ route('tasks_page') }}" class="mb-4">
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
                            <!-- Edit/Create task dialog -->
                            <x-task_dialog id="task_dialog" class="block" :users="$members"></x-task_dialog>
                        @else
                            <!-- Edit/Create task dialog -->
                            <x-task_dialog id="task_dialog" class="hidden" :users="$members"></x-task_dialog>
                        @endif
                    </div>
                </div>

                <button id="createTaskButton" class="bg-blue-500 text-white p-2 rounded">Crear Nueva Tarea</button>

                <div id="createTaskForm" class="hidden mt-4">
                    <h3 class="text-lg font-semibold mb-2">Crear Nueva Tarea</h3>
                    <form action="{{ route('store_tasks', $project->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700">Titulo</label>
                            <input type="text" name="title" id="title"
                                class="border-2 border-gray-300 p-2 rounded w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Descripción</label>
                            <input type="text" name="description" id="description"
                                class="border-2 border-gray-300 p-2 rounded w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="due_date" class="block text-gray-700">Fecha de Vencimiento</label>
                            <input type="date" name="due_date" id="due_date"
                                class="border-2 border-gray-300 p-2 rounded w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700">Asignar a Miembro</label>
                            <select name="user_id" id="user_id" class="border-2 border-gray-300 p-2 rounded w-full">
                                <option value="">Sin asignar</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Estado</label>
                            <select name="status" id="status" class="border-2 border-gray-300 p-2 rounded w-full">
                                <option value="pending">Pendiente</option>
                                <option value="in_progress">En Progreso</option>
                                <option value="completed">Completada</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-500 text-white p-2 rounded">Guardar Tarea</button>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
<script src="{{ asset('js/tasks.js') }}"></script>
<script>
    document.getElementById('createTaskButton').addEventListener('click', function () {
        document.getElementById('createTaskForm').classList.toggle('hidden');
    });

    var project = @json($project);
    var members = @json($members);
    var tasks = @json($tasks);

    console.log(project, members, tasks);
</script>