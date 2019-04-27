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
    <link href="{{ mix('css/admin/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @if (Auth::check())
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-2 sidebar">
                        <div class="site-menubar">
                            <div class="site-menubar-body">
                                <ul class="site-menu">
                                    <li class="site-menu-item logged-user">
                                        <a class="animsition-link">
                                            <i class="site-menu-icon" aria-hidden="true"></i>
                                            <span class="site-menu-title">{{ Auth::user()->name }}</span>
                                        </a>
                                    </li>
                                    <li class="site-menu-item">
                                        <router-link :to="{name: 'InvoicesBrowser'}" class="animsition-link" >
                                            <i class="site-menu-icon" aria-hidden="true"></i>
                                            <span class="site-menu-title">Invoices</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </div>

                            <div class="site-menubar-footer">
                                <a href="{{ route('logout') }}" class="fold-show" onclick="event.preventDefault();document.getElementById('logout-form').submit();" data-placement="top" data-toggle="tooltip"></a>
                                <a href="{{ route('logout') }}" class="fold-show" onclick="event.preventDefault();document.getElementById('logout-form').submit();" data-placement="top" data-toggle="tooltip" data-original-title="გასვლა">
                                    <span class="icon wb-power" aria-hidden="true"></span>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </a>
                                <a href="{{ route('logout') }}" class="fold-show" onclick="event.preventDefault();document.getElementById('logout-form').submit();" data-placement="top" data-toggle="tooltip"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-xs-12 col-sm-9 col-md-10 content">
                        <div class="container-fluid">
                            <div class="row" data-plugin="matchHeight" data-by-row="true">
                                <router-view/>
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        @endif
    </div>

    <script src="{{ mix('js/admin/app.js') }}"></script>
</body>
</html>
