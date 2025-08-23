<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'PublikaApp') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-full">
    <!-- Header Estilo MercadoLibre -->
    <header class="bg-yellow-400 shadow-lg">
        <div class="container mx-auto px-4">
            <!-- Top Bar -->
            <div class="flex items-center justify-between py-2 text-sm">
                <div class="flex space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-gray-800 hover:text-gray-900 font-medium">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ url('/') }}"
                                class="text-gray-800 hover:text-gray-900">
                                {{ __('Home') }}
                            </a>
                            <a href="{{ route('login') }}"
                                class="text-gray-800 hover:text-gray-900">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="text-gray-800 hover:text-gray-900">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                    @endif

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="{{ app()->getLocale() === 'en' ? 'font-bold' : '' }} text-gray-800 hover:text-blue-600">
                            EN
                        </a>
                        <span class="text-gray-600">|</span>
                        <a href="{{ route('lang.switch', 'es') }}"
                            class="{{ app()->getLocale() === 'es' ? 'font-bold' : '' }} text-gray-800 hover:text-blue-600">
                            ES
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Header -->
            <div class="flex items-center py-4">
                <!-- Logo -->
                <div class="flex-shrink-0 mr-8">
                    <img
                        src="{{ asset('images/LogoPA.png') }}"
                        alt="Logo"
                        class="w-20 h-20 fill-current text-gray-500 object-contain"
                    />
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-center mt-8 lg:mt-12">
                <a href="/">
                    <img
                        src="{{ asset('images/LogoPA.png') }}"
                        alt="Logo"
                        class="w-20 h-20 fill-current text-gray-500 object-contain"
                    />
                </a>
            </div>

            <div class="w-full sm:max-w-md mx-auto mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
            @include('components.accessibility-menu')
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-yellow-400 border-t mt-12">
        <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between">
            <!-- Brand -->
            <div class="mb-4 md:mb-0 text-black font-semibold text-lg">
                <img
                    src="{{ asset('images/LogoPA.png') }}"
                    alt="Logo"
                    class="w-20 h-20 fill-current text-gray-500 object-contain"
                />
            </div>

            <!-- Social Icons -->
            <div class="flex space-x-4">
                <a href="#" class="text-black hover:text-gray-800">
                    <i class="fab fa-facebook-f text-xl"></i>
                </a>
                <a href="#" class="text-black hover:text-gray-800">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="#" class="text-black hover:text-gray-800">
                    <i class="fab fa-instagram text-xl"></i>
                </a>
                <a href="#" class="text-black hover:text-gray-800">
                    <i class="fab fa-youtube text-xl"></i>
                </a>
            </div>

            <!-- Copyright -->
            <div class="mt-4 md:mt-0 text-black text-sm">
                &copy; {{ date('Y') }} PublikaApp. {{ __('All rights reserved.') }}.
            </div>
        </div>
    </footer>
    @yield('script')
</body>
</html>
