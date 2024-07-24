<x-app-layout>
    <div class="flex items-center justify-center h-full w-screen">
        <div class="flex flex-col gap-4 m-0 bg-white p-8 rounded-xl shadow-xl">
            <form action="{{route('login')}}">
                <button class="flex items-center font-semibold disabled:bg-gray-500" id="refresh_table_button"
                    label="actualizar" type="submit">
                    <svg width="24" height="24" viewBox="0 -960 960 960">
                        <path fill="black" d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                    </svg> <span class="underline">Ir atrás</span>
                </button>
            </form>

            <form class="flex flex-col gap-4" method="POST" action="{{ route('password_email') }}">
                <!-- Response message -->
                @if (session('status'))
                    <div id="response-message" class="flex flex-col items-center justify-center text-green-500">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div id="response-message" class="flex flex-col items-center justify-center text-red-500">
                        {{ session('error') }}
                    </div>
                @endif
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
                @csrf
                <div class="flex flex-col">

                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="border-grey-300 border-2 rounded p-1" name="email"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                    Enviar Link de reinicio
                </button>
            </form>
        </div>

    </div>
</x-app-layout>