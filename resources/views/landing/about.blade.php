@extends('landing.layout')

@section('title', 'Tentang Kami - Pengaduan Online Desa')
@section('description', 'Informasi tentang sistem pengaduan online desa')
@section('keywords', 'tentang, pengaduan, desa, online, sistem')
@section('body-class', 'starter-page-page')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container">
            <h1>Tentang Sistem Pengaduan Desa</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Beranda</a></li>
                    <li class="current">Tentang</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 align-items-center justify-content-between">

                    <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
                        <span class="about-meta">Tentang Kami</span>
                        <h2 class="about-title">Melayani Masyarakat Desa dengan Transparansi</h2>
                        <p class="about-description">
                            Sistem Pengaduan Online Desa hadir untuk menjembatani komunikasi antara masyarakat dan
                            pemerintah desa.
                            Kami berkomitmen untuk memberikan pelayanan terbaik dalam menampung aspirasi, keluhan, dan
                            saran dari seluruh warga desa.
                        </p>

                        <div class="row feature-list-wrapper">
                            <div class="col-md-6">
                                <ul class="feature-list">
                                    <li><i class="bi bi-check-circle-fill"></i> Transparan</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Mudah Diakses</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Respon Cepat</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="feature-list">
                                    <li><i class="bi bi-check-circle-fill"></i> Aman & Terpercaya</li>
                                    <li><i class="bi bi-check-circle-fill"></i> 24/7 Online</li>
                                    <li><i class="bi bi-check-circle-fill"></i> Gratis</li>
                                </ul>
                            </div>
                        </div>

                        <div class="info-wrapper">
                            <div class="row gy-4">
                                <div class="col-lg-5">
                                    <div class="profile d-flex align-items-center gap-3">
                                        <img src="{{ asset('assets/landing/img/avatar-1.webp') }}" alt="CEO Profile"
                                            class="profile-image">
                                        <div>
                                            <h4 class="profile-name">Kepala Desa</h4>
                                            <p class="profile-position">Penanggung Jawab Sistem</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="contact-info d-flex align-items-center gap-2">
                                        <i class="bi bi-telephone-fill"></i>
                                        <div>
                                            <p class="contact-label">Hubungi Kami</p>
                                            <p class="contact-number">+62 123 4567 890</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="image-wrapper">
                            <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                                <img src="{{ asset('assets/landing/img/about-5.webp') }}" alt="Business Meeting"
                                    class="img-fluid main-image rounded-4">
                                <img src="{{ asset('assets/landing/img/about-2.webp') }}" alt="Team Discussion"
                                    class="img-fluid small-image rounded-4">
                            </div>
                            <div class="experience-badge floating">
                                <h3>5+ <span>Tahun</span></h3>
                                <p>Melayani Masyarakat Desa</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Mission Vision Section -->
        <section class="section light-background">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="mission-card h-100" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-icon">
                                <i class="bi bi-eye"></i>
                            </div>
                            <h3>Visi Kami</h3>
                            <p>
                                Menjadi sistem pengaduan desa yang terdepan dalam memberikan pelayanan transparan,
                                responsif, dan berkualitas untuk menciptakan tata kelola pemerintahan desa yang baik.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mission-card h-100" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-icon">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <h3>Misi Kami</h3>
                            <ul class="mission-list">
                                <li>Memberikan wadah aspirasi yang mudah diakses masyarakat</li>
                                <li>Meningkatkan transparansi penyelesaian pengaduan</li>
                                <li>Mempercepat respon terhadap keluhan masyarakat</li>
                                <li>Membangun kepercayaan antara masyarakat dan pemerintah desa</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan Kami</h2>
                <p>Berbagai layanan yang tersedia dalam sistem pengaduan online desa</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card d-flex">
                            <div class="icon shrink-0">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div>
                                <h3>Pengaduan Online</h3>
                                <p>Sampaikan keluhan, saran, dan aspirasi Anda secara online 24/7 tanpa harus datang ke
                                    kantor desa.</p>
                            </div>
                        </div>
                    </div><!-- End Service Card -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-card d-flex">
                            <div class="icon shrink-0">
                                <i class="bi bi-search"></i>
                            </div>
                            <div>
                                <h3>Tracking Status</h3>
                                <p>Pantau perkembangan pengaduan Anda secara real-time dari proses awal hingga selesai.
                                </p>
                            </div>
                        </div>
                    </div><!-- End Service Card -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-card d-flex">
                            <div class="icon shrink-0">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div>
                                <h3>Laporan Transparan</h3>
                                <p>Akses laporan penyelesaian pengaduan secara transparan untuk memantau kinerja
                                    pemerintah desa.</p>
                            </div>
                        </div>
                    </div><!-- End Service Card -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-card d-flex">
                            <div class="icon shrink-0">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div>
                                <h3>Bantuan 24/7</h3>
                                <p>Tim customer service kami siap membantu Anda kapan saja untuk menyelesaikan masalah
                                    teknis.</p>
                            </div>
                        </div>
                    </div><!-- End Service Card -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $totalPengaduan }}" data-purecounter-duration="0"
                                class="purecounter">{{ $totalPengaduan }}</span>
                            <p>Total Pengaduan</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $pengaduanSelesai }}" data-purecounter-duration="0"
                                class="purecounter">{{ $pengaduanSelesai }}</span>
                            <p>Pengaduan Selesai</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $wargaTerdaftar }}" data-purecounter-duration="0"
                                class="purecounter">{{ $wargaTerdaftar }}</span>
                            <p>Pengguna Terdaftar</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="95" data-purecounter-duration="0"
                                class="purecounter">95</span>
                            <p>% Tingkat Kepuasan</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section -->

        <!-- Team Section -->
        <section id="team" class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tim Kami</h2>
                <p>Tim yang berkomitmen melayani masyarakat desa dengan sepenuh hati</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-5 justify-content-center">
                    @forelse($team as $member)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                        <div class="member">
                            <div class="pic"><img src="{{ asset('assets/landing/img/team/team-1.jpg') }}"
                                    class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>{{ $member->nama_lengkap }}</h4>
                                <span>{{ ucfirst($member->role) }}</span>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                    @empty
                    <div class="col-12 text-center">
                        <p>Belum ada data tim.</p>
                    </div>
                    @endforelse
                </div>

            </div>

        </section><!-- /Team Section -->
@endsection
