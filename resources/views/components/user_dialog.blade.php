@props(['action'])

<div id="edit_{{$action}}_dialog" {{ $attributes->merge(['class' => 'relative z-10']) }}>
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form id="{{$action}}_form" method="POST" class="flex flex-col bg-white rounded-lg p-8 gap-4 m-0">
                    @csrf
                        <!-- Name input -->
                        <div class="flex flex-col">
                            <label for="name_{{$action}}">Name</label>
                            <input class="border-black border-2 rounded-md p-1" id="name_{{$action}}" type="text" name="name" required>
                            @foreach ((array) $errors->get('name') as $message)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @endforeach
                        </div>
                        @if ($action === 'users')
                            <!-- Role Select -->
                            <div class="flex flex-col">
                                <label for="role_id">Role</label>
                                <select class="border-black border-2 rounded-md p-1" name="role_id" id="role_id" required>
                                    <option value="">-- Elije una opción --</option>
                                </select>
                            </div>
                        
                            <!-- Email input -->
                            <div class="flex flex-col">
                                <label for="email">Email</label>
                                <input class="border-black border-2 rounded-md p-1" id="email" type="email" name="email" required autocomplete="email">
                                @foreach ((array) $errors->get('email') as $message)
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @endforeach
                            </div>

                            <!-- Checkbox to change password -->
                            <div id="change-password-checkbox" class="flex items-center gap-2">
                                <input id="change-password" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded cursor-pointer focus:text-blue-500">
                                <label for="change-password" class="flex items-center cursor-pointer">
                                    ¿Cambiar contraseña?
                                </label>
                            </div>

                            <!-- Password input -->
                            <div id="password_container" class="hidden flex-col">
                                <label for="password">New Password</label>
                                <input class="border-black border-2 rounded-md p-1" id="password" type="password" name="password">
                                <span id="password_match_error" class="text-red-500"></span>
                                <span id="password_minlength_error" class="text-red-500"></span>
                            </div>
                                                
                            <!-- Confirm Password input -->
                            <div id="confirm_password_container" class="hidden flex-col">
                                <label for="confirm_password">Confirm Password</label>
                                <input class="border-black border-2 rounded-md p-1" id="confirm_password" type="password" name="confirm_password">
                            </div>
                        @endif
                        
                        
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button id="{{$action}}_submit_dialog" class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                            <button id="{{$action}}_close_dialog" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>