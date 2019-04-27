<DOCTYPE html>
<html class="no-js before-run" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.title', 'Control Panel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        {{-- <router-link :to="{name: 'HomePage'}" class="animsition-link" >Home</router-link> --}}
        <router-view/>
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
