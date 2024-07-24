<x-app-layout>
    <div class="h-full pl-32 pr-4 pt-24 overflow-auto">
        <div class="flex flex-col bg-white rounded-lg gap-4 p-4">
            <div class="flex justify-center items-center">
                <h1 class="font-bold text-4xl">Crear Ticket</h1>
            </div>
            <form id="ticket_form" class="flex flex-col bg-white rounded-lg gap-4 m-0" method="POST">
                @csrf
                <div class="flex flex-col gap-4">
                    <h1 class="font-bold font-5xl">Datos del Ticket</h1>
                    <!-- Name -->
                    <div class="flex flex-col">
                        <label for="subject">Asunto</label>
                        <input class="border-grey-300 border-2 rounded p-1" id="subject" type="text" name="subject">
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col">
                        <label for="description">Descripción</label>
                        <textarea class="border-grey-300 border-2 rounded p-1" id="description"
                            name="description"></textarea>
                    </div>

                    <!-- Status Select -->
                    <div class="flex flex-col">
                        @if (Auth::user()->role->name == "admin")
                            <label for="status">Estado</label>
                            <select class="border-grey-300 border-2 rounded p-1" name="status" id="status">
                                <option value="">-- Elije una opción --</option>
                                <option value="pending">Pendiente</option>
                                <option value="resolved">Resulto</option>
                                <option value="closed">Cerrado</option>
                            </select>
                        @else
                            <select class="border-grey-300 border-2 rounded p-1 hidden" name="status" id="status" disabled>
                                <option value="pending">Pendiente</option>
                            </select>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="ticket_submit_dialog" type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                        <button id="ticket_close_dialog" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
            </form>
        </div>
    </div>
</x-app-layout>