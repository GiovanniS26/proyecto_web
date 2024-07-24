<div id="role_dialog" {{ $attributes->merge(['class' => 'relative z-10']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form id="role_form" method="POST" class="flex flex-col bg-white rounded-lg p-8 gap-4 m-0">
                    @csrf
                    <div>
                        <h1 class="font-bold font-5xl">Datos del Rol</h1>
                        <!-- Name input -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="name">Name</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="name" type="text" name="name"
                                required>
                            @foreach ((array) $errors->get('name') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button id="role_submit_dialog"
                                class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                            <button id="role_close_dialog" type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->