<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ $page_title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon.ico">
    <link href="{{ asset('') }}assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('') }}assets/js/layout.js"></script>
    <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Choices -->
    <link rel="stylesheet" href="{{ asset('') }}assets/libs/choices.js/public/assets/styles/choices.min.css" />
    <!-- Flatpickr -->
    <link rel="stylesheet" href="{{ asset('') }}assets/libs/flatpickr/flatpickr.min.css" />
    <!-- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/custom-dev.css" rel="stylesheet" type="text/css" />
    @yield('head')
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
    <!-- Grids in modals -->
    <div class="modal fade" id="modalInit" tabindex="-1" aria-labelledby="InitModalgridLabel" aria-modal="true">
        <div class="modal-dialog">
        </div>
    </div>

    @extends('layout-setting')
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('') }}assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('') }}assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('') }}assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('') }}assets/js/plugins.js"></script>
    <script src="{{ asset('') }}assets/js/jquery-3.5.1.min.js"></script>
    <!-- Choices -->
    <script src="{{ asset('') }}assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Flatpickr -->
    <script src="{{ asset('') }}assets/libs/flatpickr/flatpickr.min.js"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
    <script src="{{ asset('') }}assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}assets/js/app.js"></script>
    <script src="{{ asset('') }}assets/js/modal-init.js"></script>
    <script src="{{ asset('') }}assets/js/ajax-requests.js"></script>
    @yield('bottom')
</body>
</html>