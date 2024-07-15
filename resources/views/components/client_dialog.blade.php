<div {{ $attributes->merge(['class' => 'relative z-10']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen flex justify-center items-center">
        <div class="flex h-auto items-end justify-center text-center sm:items-center sm:p-0">
            <div
                class="relative max-h-[80vh] px-8 py-4 transform overflow-auto rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                <form id="client_form" class="flex flex-col bg-white rounded-lg gap-4 m-0" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <h1 class="font-bold font-5xl">Datos del Cliente</h1>
                        <!-- Name -->
                        <div class="flex flex-col">
                            <label for="name">Nombre</label>
                            <input class="border-black border-2 rounded-md p-1" id="name" type="text" name="name">
                            @foreach ((array) $errors->get('name') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="email">Correo Electrónico</label>
                            <input class="border-black border-2 rounded-md p-1" id="email" type="email" name="email"
                                autocomplete="email">
                            @foreach ((array) $errors->get('email') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>

                        <!-- Phone -->
                        <div class="flex flex-col">
                            <label for="phone">Teléfono</label>
                            <input class="border-black border-2 rounded-md p-1" type="tel" id="phone" name="phone"
                                pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
                        </div>

                        <!-- Address -->
                        <div class="flex flex-col">
                            <label for="address">Direccion</label>
                            <textarea class="border-black border-2 rounded-md p-1" id="address"
                                name="address"></textarea>
                        </div>


                        <div class="flex gap-4 justify-between items-center">
                            <div class="flex flex-col">
                                <!-- Birthdate -->
                                <label for="birthdate">Fecha de Nacimiento:</label>
                                <input class="border-black border-2 rounded-md p-1" type="date" id="birthdate"
                                    name="birthdate" max="20124-12-31" />
                            </div>
                            <div class="flex flex-col">
                                <!-- Type Select -->
                                <label for="type">Tipo de usuario</label>
                                <select class="border-black border-2 rounded-md p-1" name="type" id="type">
                                    <option value="">-- Elije una opción --</option>
                                    <option value="company">Empresa</option>
                                    <option value="individual">Particular</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="client_submit_dialog" type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                        <button id="client_close_dialog" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>