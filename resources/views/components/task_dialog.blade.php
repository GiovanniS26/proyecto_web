@props(['users'])

<div {{ $attributes->merge(['class' => 'relative z-10']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen flex justify-center items-center">
        <div class="flex h-auto items-end justify-center text-center sm:items-center sm:p-0 w-1/2">
            <div
                class="relative max-h-[80vh] px-8 py-4 transform overflow-auto rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                <form id="task_form" class="flex flex-col bg-white rounded-lg gap-4 m-0" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <h1 class="font-bold font-5xl">Datos de la Tarea</h1>
                        <!-- Name -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="title">Title</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="title" type="text" name="title">
                            @foreach ((array) $errors->get('title') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>

                        <!-- Description -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="description">Direccion</label>
                            <textarea class="border-grey-300 border-2 rounded p-1" id="description"
                                name="description"></textarea>
                        </div>

                        <!-- Status Select -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="status">Estado</label>
                            <select class="border-grey-300 border-2 rounded p-1" name="status" id="status">
                                <option value="">-- Elije una opción --</option>
                                <option value="pending">Pendiente</option>
                                <option value="in_progress">En Progreso</option>
                                <option value="completed">Completado</option>
                            </select>
                        </div>


                        @if (Auth::user()->role->name == "admin")
                            <!-- Members Select -->
                            <div class="flex flex-col gap-2">
                                <label class="font-bold" for="user_id">Asignado a la Tarea</label>
                                <input class="border-grey-300 border-2 rounded p-1" type="text" id="searchMembers"
                                    placeholder="Buscar...">
                                <div id="membersList" class="border-grey-300 border-2 rounded p-1 overflow-auto max-h-32">
                                    @foreach($users as $user)
                                        <div class="form-check">
                                            <input
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                type="radio" name="user_id" value="{{ $user->id }}" id="user_{{ $user->id }}">
                                            <label class="font-bold" class="form-check-label" for="user_{{ $user->id }}">
                                                {{ $user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        <!-- Start Date -->
                        <div class="flex gap-4 justify-between items-center">
                            <div class="flex flex-col">
                                <label class="font-bold" for="due_date">Fecha de Entrega:</label>
                                <input class="border-grey-300 border-2 rounded p-1" type="date" id="due_date"
                                    name="due_date" max="20124-12-31" />
                            </div>
                        </div>

                        <input class="hidden" type="text" id="project_id" name="project_id" />
                    </div>


                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="task_submit_dialog" type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                        <button id="task_close_dialog" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>