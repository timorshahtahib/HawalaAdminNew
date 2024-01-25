<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <title>@yield('title') Hawala Admin Panel</title>
    <meta content="Hawala admin panel"
        name="description" />
        <meta name="author" content="Nazir Ahmad Rahmaty">
    <!-- vite css and js  -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/sass/app.scss') }}" id="layout-css">
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/sass/app-rtl.scss') }}" id="layout-css">

    @yield('css')
</head>

<body data-sidebar="dark" data-layout-mode="light">
    <div id="app">
        @yield('content')
    </div>
    <!-- built files will be auto injected -->
    @stack('scripts')
    @yield('js')

    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
</body>

</html>
