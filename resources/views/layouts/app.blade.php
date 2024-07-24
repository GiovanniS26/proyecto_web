<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Súper Bigote</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico')}} " />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
    <!-- @vite('resources/css/app.css') -->
</head>

<body class="bg-sky">
    <header class="flex items-center justify-between h-16 w-full fixed bg-black z-50">
        @auth
            <div class="flex items-center justify-center">
                <a href="{{route('dashboard')}}">
                    <img class="m-4 w-12 h-auto" src="{{ asset('assets/super_logo.png') }}" alt="Logo" />
                </a>
                <!-- <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:-translate-y-2 hover:underline"
                    href="{{route('dashboard')}}">Dashboard</a> -->
            </div>
            <nav class="flex items-center gap-4">
                <div class="flex items-center bg-blue-500 rounded p-2">
                    <span class="text-white">{{Auth::user()->name}}</span>
                </div>
                <form class="m-0" action="{{route('logout')}}" method="POST">
                    @csrf
                    <a class="p-2 text-white hover:underline cursor-pointer hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite]"
                        onclick="event.preventDefault(); this.closest('form').submit();">Cerrar Sesión</a>
                </form>
            </nav>
        @else
            <div class="flex justify-center items-center w-full">
                <a href="{{route('index')}}">
                    <img class="m-4 w-12 h-auto" src="{{ asset('assets/super_logo.png') }}" alt="Logo" />
                </a>
            </div>
        @endauth
    </header>

    <div class="flex">
        @if (Auth::check())
            <nav class="flex flex-col w-auto p-4 mt-16 bg-black fixed h-full gap-2 z-10">
                @if (Auth::user()->role->name == "admin")
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('roles_page')}}">Roles</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('users_page')}}">Usuarios</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('clients_page')}}">Clientes</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('projects_page')}}">Proyectos</a>
<!--                     <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('tasks_page')}}">Tareas</a> -->
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('leads_page')}}">Leads</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('tickets_page')}}">Tickets</a>
                @elseif (Auth::user()->role->name == "user")
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('clients_page')}}">Clientes</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('projects_page')}}">Proyectos</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('leads_page')}}">Leads</a>
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('tickets_page')}}">Tickets</a>
                @else
                    <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:underline"
                        href="{{route('tickets_page')}}">Tickets</a>
                @endif
            </nav>
        @endif
    </div>
    <main class="h-full">
        {{ $slot }}
    </main>
</body>

</html>