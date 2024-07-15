<x-app-layout>
    <div class="flex items-center justify-center h-full w-screen">
        <!-- Login Form -->
        <form class="flex flex-col gap-4 m-0 bg-white p-8 rounded-xl shadow-xl" method="POST" action="{{route('login')}}" class="flex flex-col bg-white rounded-lg p-8 gap-4">
            @csrf

                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="./assets/super_logo.png" alt="Logo" />
                    <span>¡Entra a un mundo de corrupción!</span>
                </div>

                <!-- Email Address -->
                <div class="flex flex-col">
                    <label for="email">Email</label>
                    <input class="border-black border-2 rounded-md p-1" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    @foreach ((array) $errors->get('email') as $message)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @endforeach
                </div>

                <!-- Password -->
                <div class="flex flex-col">
                    <label for="password">Password</label>
                    <input class="border-black border-2 rounded-md p-1" 
                        id="password"
                        type="password"
                        name="password"
                        required autocomplete="current-password"
                    />
                </div>
                
                <div class="flex justify-center items-center">
                    <button class="underline">
                        Iniciar Sesión
                    </button>
                </div>

                <div class="flex justify-center items-center">
                    <a class="underline text-gray-400" href="{{route('register')}}">Registrarse</a>
                </div>
        </form>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</x-app-layout>
