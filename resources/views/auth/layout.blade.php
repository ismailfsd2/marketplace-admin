<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ $page_title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon.ico">
    <script src="{{ asset('') }}assets/js/layout.js"></script>
    <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    @yield('header')
</head>
<body>
    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <a href="#" class="d-inline-block auth-logo">
                                        <img src="{{ asset('') }}assets/images/logo-light.png" alt="" height="20">
                                    </a>
                                </div>
                                <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @yield('body')
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="mb-0 text-muted">&copy;
                                    <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('') }}assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('') }}assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('') }}assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('') }}assets/js/plugins.js"></script>
    <script src="{{ asset('') }}assets/libs/particles.js/particles.js"></script>
    <script src="{{ asset('') }}assets/js/pages/particles.app.js"></script>
    <script src="{{ asset('') }}assets/js/pages/password-addon.init.js"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
    <script src="{{ asset('') }}assets/js/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('') }}assets/js/ajax-requests.js"></script>
    @yield('footer')
</body>
</html>