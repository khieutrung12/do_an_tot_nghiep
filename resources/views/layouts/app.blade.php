<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('titles.' . Route::currentRouteName()) . ' | ' }}Technology
        World</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/style.js') }}" defer></script>
    <script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        charset="utf-8"></script>

    <!-- Styles -->
    <link href="{{ asset('bower_components/font-awesome/css/all.css') }}"
        rel="stylesheet">
    <link href="{{ asset('bower_components/toastr/toastr.css') }}"
        rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/style-app-user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-custom.css') }}" rel="stylesheet">
</head>

<body class="bg-white h-screen antialiased leading-none font-sans">
    <div id="app">
        <div class="header sticky top-0 z-50">
            <!-- header -->
            @include('layouts.header')
            <!-- header end -->
            <!-- navbar -->
            @include('layouts.navbar')
            <!-- navbar end -->
        </div>
        <!-- mobile menubar -->
        @include('layouts.mobilemenubar')
        <!-- mobile menu end -->

        @yield('content')

        <!-- footer -->
        @include('layouts.footer')
        <!-- footer end -->
        <!-- copyright -->
        <div class="bg-gray-800 py-4 m-auto">
            <div class="container flex items-center justify-between m-auto">
                <p class="text-white">© TECHNOLOGY WORLD - All Rights
                    Reserved</p>
                <div>
                    <img src="{{ asset('images/methods.png') }}"
                        class="h-5">
                </div>
            </div>
        </div>
        <!-- copyright end -->
    </div>
    <script src="{{ asset('bower_components/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/toastr/toastr.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}">
    </script>
    <script src="{{ asset('js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/cart_update.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/customer_voucher.js') }}"></script>
    <script src="{{ asset('js/style_ajax.js') }}"></script>
    <script src="{{ asset('bower_components/pusher-js/dist/web/pusher.js') }}">
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script script src="{{ asset('js/notification_order_status.js') }}">
    </script>

</body>

</html>
