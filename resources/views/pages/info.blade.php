<x-landing-layout>
    <div class="flex flex-col p-16 gap-12">
        <div class="flex flex-col bg-white rounded-lg gap-4 p-4">
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

            @if (isset($success))
                <!-- Response message -->
                <div id="response-message" class="flex flex-col items-center justify-center text-green-500">
                    {{ $success }}
                </div>
            @elseif (isset($error))
                <div id="response-message" class="flex flex-col items-center justify-center text-red-500">
                    {{ $error }}
                </div>
            @else
                <div class="flex flex-col justify-center items-center">
                    <h1 class="font-bold text-4xl">Información</h1>
                    <h3>Para más información rellene los datos y lo contactaremos.</h3>
                </div>
                <form id="ticket_form" class="flex flex-col bg-white rounded-lg gap-4 m-0" action="{{route('store_leads')}}"
                    method="POST">
                    @csrf
                    <h1 class="font-bold font-5xl">Datos</h1>
                    <div class="grid grid-cols-2 gap-8">

                        <!-- Name -->
                        <div class="flex flex-col">
                            <label for="name">Nombre</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="name" type="text" name="name">
                        </div>

                        <!-- Lastname -->
                        <div class="flex flex-col">
                            <label for="lastname">Apellido</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="lastname" type="text" name="lastname">
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col">
                            <label for="email">Corre Electrónico</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="email" type="text" name="email">
                        </div>

                        <!-- Country -->
                        <div class="flex flex-col">
                            <label for="country">País</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="country" type="text" name="country">
                        </div>

                        <!-- City -->
                        <div class="flex flex-col">
                            <label for="city">Ciudad</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="city" type="text" name="city">
                        </div>

                        <!-- Phone -->
                        <div class="flex flex-col">
                            <label for="phone">Teléfono</label>
                            <input class="border-grey-300 border-2 rounded p-1" id="phone" type="text" name="phone">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">Enviar</button>
                        <button id="user_close_dialog" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-landing-layout>