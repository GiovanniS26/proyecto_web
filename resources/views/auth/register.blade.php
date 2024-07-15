<x-app-layout>
    <div class="flex items-center justify-center h-full">
        <!-- Register or Update Form -->
        <form id="register_form" action="{{route('register')}}" method="POST" class="flex flex-col bg-white rounded-lg p-8 gap-4 m-0">
            @csrf

                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="./assets/super_logo.png" alt="Logo" />
                    <span>¡Unete a nuestro mundo de corrupción!</span>
                </div>

                <!-- Name input -->
                <div class="flex flex-col">
                    <label for="name">Name</label>
                    <input class="border-black border-2 rounded-md p-1" id="name" type="text" name="name" required>
                </div>
                
                <!-- Email input -->
                <div class="flex flex-col">
                    <label for="email">Email</label>
                    <input class="border-black border-2 rounded-md p-1" id="email" type="email" name="email" required>
                    @foreach ((array) $errors->get('email') as $message)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @endforeach
                </div>
                
                <!-- Password input -->
                <div class="flex flex-col">
                    <label for="password">Password</label>
                    <input class="border-black border-2 rounded-md p-1" id="password" type="password" name="password" required>
                    <span id="password_match_error" class="text-red-500"></span>
                    <span id="password_minlength_error" class="text-red-500"></span>
                </div>
                
                <!-- Confirm Password input -->
                <div class="flex flex-col">
                    <label for="confirm_password">Confirm Password</label>
                    <input class="border-black border-2 rounded-md p-1" id="confirm_password" type="password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="underline">
                    Enviar
                </button>
        </form>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</x-app-layout>