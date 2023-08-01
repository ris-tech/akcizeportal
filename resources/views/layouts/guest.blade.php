<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="row justify-content-md-center mb-5">
                <div class="col text-center">
                    <img class="logoimg" src="{{ asset('assets/img/logo-roentgen-imaging.svg') }}">
                </div>
            </div>
            <div class="row justify-content-md-center">                
                <div class="col-md-6 shadow p-4 mb-5 bg-body-tertiary">
                    {{ $slot }}
                </div>
            </div>
             
        </div>
        
    </body>
</html>
