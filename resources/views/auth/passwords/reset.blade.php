<x-app-layout>
    <div class="flex items-center justify-center h-full w-screen">
        <form class="flex flex-col gap-4 m-0 bg-white p-8 rounded-xl shadow-xl" method="POST" action="{{ route('password_update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" class="border-grey-300 border-2 rounded p-1" name="email"
                    value="{{ old('email', $email) }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" class="border-grey-300 border-2 rounded p-1"
                    name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirmar Contraseña</label>
                <input id="password-confirm" type="password" class="border-grey-300 border-2 rounded p-1" name="password_confirmation" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">
                Establecer contraseña
            </button>
        </form>
    </div>
</x-app-layout>