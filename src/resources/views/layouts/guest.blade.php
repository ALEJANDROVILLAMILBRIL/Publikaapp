<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PublikaApp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    <a
                        href="/"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        {{ __('Home') }}
                    </a>
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        {{ __('Log in') }}
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            {{ __('Register') }}
                        </a>
                    @endif
                    <div class="flex justify-end items-center gap-x-4 p-4">
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="{{ app()->getLocale() === 'en' ? 'font-bold underline' : '' }} text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                            {{ __('English') }}
                        </a>
                        <span class="text-gray-500 dark:text-gray-400 px-2">|</span>
                        <a href="{{ route('lang.switch', 'es') }}"
                            class="{{ app()->getLocale() === 'es' ? 'font-bold underline' : '' }} text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                            {{ __('Spanish') }}
                        </a>
                    </div>
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full h-screen transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex justify-center items-center w-full max-w-4xl flex-col-reverse lg:flex-row">
                <div class="flex flex-col gap-4 lg:gap-8 w-full lg:w-1/2">
                    <div class="flex justify-center">
                        <a href="/">
                            <img src="{{ asset('images/LogoPA.png') }}" alt="Logo" class="w-20 h-20 fill-current text-gray-500 object-contain" />
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        {{ $slot }}
                    </div>
                    @include('components.accessibility-menu')
                </div>
            </main>
        </div>
    </body>
</html>
