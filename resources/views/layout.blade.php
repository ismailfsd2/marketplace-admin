<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ $page_title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon.ico">
    <link href="{{ asset('') }}assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('') }}assets/js/layout.js"></script>
    <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    @yield('header')
</head>
<body>
    <div id="layout-wrapper">
        @extends('header');
        @extends('menu');
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    @extends('layout-setting')
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('') }}assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('') }}assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('') }}assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('') }}assets/js/plugins.js"></script>
    <script src="{{ asset('') }}assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('') }}assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="{{ asset('') }}assets/libs/jsvectormap/maps/world-merc.js"></script>
    <script src="{{ asset('') }}assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('') }}assets/js/pages/dashboard-ecommerce.init.js"></script>
    <script src="{{ asset('') }}assets/js/app.js"></script>
    @yield('header')
</body>
</html>