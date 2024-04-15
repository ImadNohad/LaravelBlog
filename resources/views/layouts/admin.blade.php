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
</head>

<body>
    <header class="header-top justify-content-center py-2 d-lg-none">
		<div class="container-fluid">
			<nav class="navbar navbar-expand-lg navigation-2 navigation">
				<a class="navbar-brand" href="#">
					<img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid">
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse"
					aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="ti-menu"></span>
				</button>

				<div class="collapse navbar-collapse mt-4" id="navbar-collapse">
					<ul id="menu" class="menu navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/categories"><i class='bx bxs-category-alt'></i> Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/articles"><i class='bx bxs-detail'></i> Articles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/comments"><i class='bx bxs-comment'></i> Comments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/tags"><i class='bx bxs-tag'></i> Tags</a>
                        </li>
                        @if (auth()->user()->type === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/users"><i class='bx bxs-user'></i> Users</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/logout"><i class='bx bxs-log-out-circle'></i> Logout</a>
                        </li>
					</ul>
				</div>
			</nav>
		</div>
	</header>

    <div class="section-padding pb-0">
        <div class="sidebar d-none d-lg-block">
            <div class="sidebar-sticky">
                <div class="logo-wrapper text-center">
                    <a class="navbar-brand" href="/admin/articles">
                        <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid">
                    </a>
                </div>

                <div class="main-menu">
                    <nav class="nav navbar-expand-lg p-0">
                        <div class="navbar-collapse collapse justify-content-center">
                            <ul class="list-unstyled">
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/categories"><i class='bx bxs-category-alt'></i> Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/articles"><i class='bx bxs-detail'></i> Articles</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/comments"><i class='bx bxs-comment'></i> Comments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/tags"><i class='bx bxs-tag'></i> Tags</a>
                                </li>
                                @if (auth()->user()->type === 'admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="/admin/users"><i class='bx bxs-user'></i> Users</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout"><i class='bx bxs-log-out-circle'></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                @if (session('message'))
                    <div class="alert alert-{{ session('type') }}">
                        <i class="{{ session('icon') }}"></i>
                        {{ session('message') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <div class="footer-home py-4">
		<div class="row">
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

    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
