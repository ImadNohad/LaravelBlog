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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Themify -->
    <link rel="stylesheet" href="{{ asset('plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick.css') }}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{ asset('plugins/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.0/css/boxicons.min.css">
    <!-- main stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="section-padding pb-0">
        <div class="sidebar d-none d-lg-block">
            <div class="sidebar-sticky">
                <div class="logo-wrapper">
                    <a class="navbar-brand" href="/admin/articles">
                        <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid">
                    </a>
                </div>

                <div class="main-menu">
                    <nav class="navbar navbar-expand-lg p-0">
                        <div class="navbar-collapse collapse" id="navbarsExample09" style="">
                            <ul class="list-unstyled ">
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/categories">Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/articles">Articles</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/articles/comments">Comments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/articles/tags">Tags</a>
                                </li>
                                @if (auth()->user()->type === "admin")
                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/users">Users</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- THEME JAVASCRIPT FILES
    ================================================== -->
    <!-- initialize jQuery Library -->
    <script src="{{ asset('plugins/jquery/jquery.js') }}"></script>
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

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script> --}}

    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
