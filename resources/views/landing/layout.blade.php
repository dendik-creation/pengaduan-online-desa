<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Pengaduan Online Desa')</title>
    <meta name="description" content="@yield('description', 'Sistem Pengaduan Online Desa untuk melayani aspirasi masyarakat')">
    <meta name="keywords" content="@yield('keywords', 'pengaduan, desa, online, aspirasi, masyarakat')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/landing/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/landing/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/landing/css/main.css') }}" rel="stylesheet">

    @yield('extra-css')
</head>

<body class="@yield('body-class', 'index-page')">

    @include('partials.toaster')
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">Pengaduan Desa</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" class="@if (request()->is('/')) active @endif">Beranda</a></li>
                    <li><a href="/about" class="@if (request()->is('about')) active @endif">Tentang</a></li>
                    <li><a href="/pengaduan" class="@if (request()->is('pengaduan*')) active @endif">Data Pengaduan</a>
                    </li>
                    <li><a href="/contact" class="@if (request()->is('contact')) active @endif">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            @if (auth()->user())
                <a class="btn-getstarted" href="/dashboard">Dashboard</a>
            @else
                <a class="btn-getstarted" href="/login">Login</a>
            @endif

        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="/" class="logo d-flex align-items-center">
                        <span class="sitename">Pengaduan Desa</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Desa Maju No. 123</p>
                        <p>Kabupaten, Provinsi 12345</p>
                        <p class="mt-3"><strong>Telepon:</strong> <span>+62 123 4567 890</span></p>
                        <p><strong>Email:</strong> <span>info@pengaduandesa.id</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Menu Utama</h4>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/about">Tentang Kami</a></li>
                        <li><a href="/pengaduan">Data Pengaduan</a></li>
                        <li><a href="/contact">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Pengaduan Online</a></li>
                        <li><a href="#">Tracking Status</a></li>
                        <li><a href="#">Laporan Bulanan</a></li>
                        <li><a href="#">Bantuan</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Kategori</h4>
                    <ul>
                        <li><a href="#">Infrastruktur</a></li>
                        <li><a href="#">Pelayanan Publik</a></li>
                        <li><a href="#">Lingkungan</a></li>
                        <li><a href="#">Keamanan</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Panduan</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Pengaduan Desa</strong> <span>All Rights
                    Reserved</span></p>
            <div class="credits">
                Dikembangkan untuk melayani masyarakat desa
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/purecounter/purecounter_vanilla.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>

    @yield('extra-js')

</body>

</html>
