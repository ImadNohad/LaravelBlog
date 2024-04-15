<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Revolve - Personal Magazine blog Template</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--Favicon-->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <!-- THEME CSS ================================================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Themify -->
    <link rel="stylesheet" href="{{ asset('plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick.css') }}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{ asset('plugins/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <!-- main stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- initialize jQuery Library -->
    <script src="{{ asset('plugins/jquery/jquery.js') }}"></script>
</head>

<body>
    <header class="header-top bg-dark py-4">
        <div class="container">
            <nav class="navbar navbar-expand-lg navigation menu-white">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo-w.png') }}" alt="" class="img-fluid">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                    aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="ti-menu text-white"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="menu navbar-nav ms-auto">
                        <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                        @auth
                            @if (auth()->user()->type !== 'visiteur')
                                <li class="nav-item"><a href="/admin/articles" class="nav-link">Admin Area</a></li>
                            @endif
                            <li class="nav-item"><a href="/logout" class="nav-link">Logout</a></li>
                        @endauth

                        @guest
                            <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                        @endguest
                    </ul>
                    <div class="text-lg-right search ms-4">
                        <div class="search_toggle"><i class="ti-search text-white"></i></div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!--search overlay start-->
    <div class="search-wrap">
        <div class="overlay">
            <form action="{{ route('search') }}" class="search-form">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-9">
                            <input name="keyword" type="text" class="form-control" placeholder="Search..." />
                        </div>
                        <div class="col-md-2 col-3 text-right">
                            <div class="search_toggle toggle-wrap d-inline-block">
                                <i class='bx bx-x bx-lg'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--search overlay end-->

    @if (session('message'))
        <div class="alert alert-{{ session('type') }}">
            <i class={{ session('icon') }}></i>
            {{ session('message') }}
        </div>
    @endif

    @yield('content')

    <!--footer start-->
    <footer class="footer-section bg-grey">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="copyright">© Copyright {{ now()->format('Y') }} - Revolve. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!--footer end-->

    <!-- THEME JAVASCRIPT FILES
    ================================================== -->
    <!-- Bootstrap jQuery -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/popper.min.js') }}"></script>
    <!-- Owl caeousel -->
    <script src="{{ asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('plugins/slick-carousel/slick.min.js') }}"></script>
    <script src="{{ asset('plugins/magnific-popup/magnific-popup.js') }}"></script>
    <!-- Instagram Feed Js -->
    <script src="{{ asset('plugins/instafeed-js/instafeed.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
