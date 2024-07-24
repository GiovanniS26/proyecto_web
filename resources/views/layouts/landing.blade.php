<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Súper Bigote</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
        <!-- @vite('resources/css/app.css') -->
    </head>
    <body class="bg-sky">
        <header class="flex items-center justify-between h-16 w-full fixed bg-black z-50">
            <div class="flex items-center justify-center">
                <a href="{{route('index')}}">
                <img class="m-4 w-12 h-auto" src="./assets/super_logo.png" alt="Logo" />
                </a>
                <a class="text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:-translate-y-2 hover:underline" href="{{route('more_design')}}">Metele más diseño</a>
            </div>
            <nav class="flex h-full gap-4">
                <a class="flex items-center p-2 text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:-translate-y-2 hover:underline" href="{{route('index')}}">Inicio</a>
                <a class="flex items-center p-2 text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:-translate-y-2 hover:underline" href="{{route('gallery')}}">Galería</a>
                <a class="flex items-center p-2 text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:-translate-y-2 hover:underline" href="{{route('about')}}">Acerca de</a>
                <a class="flex items-center p-2 text-white hover:animate-[pulse_2s_cubic-bezier(0.4,_0,_0.6,_1)_infinite] hover:duration-500 hover:-translate-y-2 hover:underline" href="{{route('info')}}">Información</a>
                <a class="flex items-center p-2 text-white hover:underline bg-blue-500" href="{{route('login')}}">Iniciar Sesión</a>
            </nav>
        </header>

        <main class="!pt-16 overflow-auto">
            {{$slot}}
        </main>
        
        <footer class="flex flex-col items-center justify-center bg-black p-8 overflow-auto">
            <div class="flex items-center justify-center flex-wrap">
                <a class="flex-1" href="./index.html">
                    <img class="m-4 w-40 h-auto" src="./assets/super_logo.png" alt="Logo" />
                </a>
                <div class="footer-index flex-1">
                    <ul>
                        <li class="m-2 flex items-center">
                            <a class="text-white" href="{{route('index')}}">Inicio</a>
                        </li>
                        <li class="m-2 flex items-center">
                            <a class="text-white" href="{{route('gallery')}}">Galería</a>
                        </li>
                        <li class="m-2 flex items-center">
                            <a class="text-white" href="{{route('about')}}">Acerca de</a>
                        </li>
                        <li class="m-2 flex items-center">
                            <a class="text-white" href="{{route('info')}}">Información</a>
                        </li>
                        <li class="m-2 flex items-center">
                            <a class="text-white" href="{{route('login')}}">Iniciar Sesión</a>
                        </li>
                        <li class="m-2 flex items-center">
                            <a class="text-white" href="{{route('register')}}">Registro</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-contact flex-1">
                    <ul>
                        <li class="m-2 flex items-center">
                            <span class="text-white flex items-center gap-2">
                                <img
                                class="w-[28px] h-[28px]"
                                src="./assets/icons/PhoneIcon.png"
                                alt="" />+58 424-1234567
                            </span>
                        </li>
                        <li class="m-2 flex items-center">
                            <span class="text-white flex items-center gap-2"
                                ><img
                                class="w-[28px] h-[28px]"
                                src="assets/icons/LocationPinIcon.png"
                                alt="" />País de las maravillas, Edo. Fantasilandia, Av. tú
                                corazón</span
                            >
                        </li>
                        <li class="m-2 flex items-center">
                            <span class="text-white flex items-center gap-2"
                                ><img
                                class="w-[28px] h-[28px]"
                                src="{{ asset('assets/icons/GmailIcon.png') }}"
                                alt="" />superbigote@dictadura.com</span
                            >
                        </li>
                    </ul>
                </div>
            </div>
            <span class="text-gray-500">Copyright © 2024</span>
        </footer>
    </body>
</html>
