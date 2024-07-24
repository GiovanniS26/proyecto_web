@props(['roles'])

<div id="user_dialog" {{ $attributes->merge(['class' => 'relative z-10']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form id="user_form" method="POST" class="flex flex-col bg-white rounded-lg p-8 gap-4 m-0">
                    @csrf
                    <div>
                        <h1 class="font-bold font-5xl">Datos del Usuario</h1>
                        <!-- Name input -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="name">Name</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="name" type="text" name="name"
                                required>
                            @foreach ((array) $errors->get('name') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>
                        
                        <!-- Role Select -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="role_id">Role</label>
                            <select class="border-grey-300 border-2 rounded p-1" name="role_id" id="role_id" required>
                                <option value="">-- Elije una opción --</option>
                                @foreach ($roles as $role) 
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Email input -->
                        <div class="flex flex-col">
                            <label class="font-bold" for="email">Email</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="email" type="email" name="email"
                                required autocomplete="email">
                            @foreach ((array) $errors->get('email') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>

                        <!-- Checkbox to change password -->
                        <div id="change-password-checkbox" class="flex items-center gap-2">
                            <input id="change-password" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded cursor-pointer focus:text-blue-500">
                            <label class="font-bold" for="change-password" class="flex items-center cursor-pointer">
                                ¿Cambiar contraseña?
                            </label>
                        </div>

                        <!-- Password input -->
                        <div id="password_container" class="hidden flex-col">
                            <label class="font-bold" for="password">New Password</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="password" type="password"
                                name="password">
                            <span id="password_match_error" class="text-red-500"></span>
                            <span id="password_minlength_error" class="text-red-500"></span>
                        </div>

                        <!-- Confirm Password input -->
                        <div id="confirm_password_container" class="hidden flex-col">
                            <label class="font-bold" for="confirm_password">Confirm Password</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="confirm_password" type="password"
                                name="confirm_password">
                        </div>


                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button id="user_submit_dialog"
                                class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                            <button id="user_close_dialog" type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>