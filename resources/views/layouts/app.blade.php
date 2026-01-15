<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'PummelPlay - Digital Game Store')</title>

     
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

   
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gaming-dark text-gray-100">
        <div class="min-h-screen bg-gaming-dark">
            @include('layouts.navigation')

      
            @if(session('success'))
                <div class="bg-green-600 text-white px-4 py-3 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-600 text-white px-4 py-3 text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-600 text-white px-4 py-3 text-center">
                    {{ session('info') }}
                </div>
            @endif

     
            @isset($header)
                <header class="bg-gray-800/50 shadow-lg border-b border-gray-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

    
            <main class="py-8">
                {{ $slot }}
            </main>


            <footer class="bg-gray-800/30 border-t border-gray-700 py-8 mt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center text-gray-400">
                        <p>&copy; {{ date('Y') }} PummelPlay. All rights reserved.</p>
                        <p class="text-sm mt-2">Your ultimate digital gaming destination</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
