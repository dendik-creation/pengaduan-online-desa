@extends('landing.layout')

@section('title', 'Pengaduan Online Desa - Beranda')
@section('description', 'Sistem Pengaduan Online Desa untuk melayani aspirasi masyarakat')
@section('keywords', 'pengaduan, desa, online, aspirasi, masyarakat')
@section('body-class', 'index-page')

@section('content')

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <div class="company-badge mb-4">
                                <div class="badge-text">Sistem Terpercaya</div>
                            </div>

                            <h1 class="mb-4">
                                Pengaduan Online
                                <span class="accent-text">Desa</span>
                            </h1>

                            <p class="mb-4 mb-md-5">
                                Sampaikan aspirasi, keluhan, dan saran Anda kepada pemerintah desa dengan mudah dan
                                transparan melalui sistem pengaduan online kami.
                            </p>

                            <div class="d-flex justify-content-center justify-content-sm-start">

                                <div class="hero-buttons">
                                    <a href="pengaduan/create" class="btn btn-primary me-0 me-sm-2 mx-1">Buat Pengaduan</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="{{ asset('assets/landing/img/illustration-1.webp') }}" alt="Pengaduan Online Desa"
                                class="img-fluid">

                            <div class="customers-badge">
                                <div class="customer-avatars">
                                    <img src="{{ asset('assets/landing/img/avatar-1.webp') }}" alt="Customer 1"
                                        class="avatar">
                                    <img src="{{ asset('assets/landing/img/avatar-2.webp') }}" alt="Customer 2"
                                        class="avatar">
                                    <img src="{{ asset('assets/landing/img/avatar-3.webp') }}" alt="Customer 3"
                                        class="avatar">
                                    <img src="{{ asset('assets/landing/img/avatar-4.webp') }}" alt="Customer 4"
                                        class="avatar">
                                    <img src="{{ asset('assets/landing/img/avatar-5.webp') }}" alt="Customer 5"
                                        class="avatar">
                                    <span class="avatar-plus">+12</span>
                                </div>
                                <p class="mb-0 mt-2">Dipercaya oleh 500+ Warga</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $pengaduanSelesai }}+</h4>
                                <p class="mb-0">Pengaduan Selesai</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="bi bi-journal-richtext"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $totalPengaduan }}+</h4>
                                <p class="mb-0">Total Pengaduan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="stat-content">
                                <h4>24/7</h4>
                                <p class="mb-0">Layanan Online</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $wargaTerdaftar }}+</h4>
                                <p class="mb-0">Warga Terdaftar</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /Hero Section -->

        <!-- Features Section -->
        <section id="features" class="features section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Fitur Unggulan</h2>
                <p>Kemudahan dan transparansi dalam sistem pengaduan online kami</p>
            </div>

            <div class="container">
                <div class="row gy-4">
                    @forelse($kategori as $item)
                    <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
                        <div class="feature-box orange">
                            <i class="bi bi-award"></i>
                            <h4>{{ $item->nama }}</h4>
                            <p>{{ Str::limit($item->deskripsi, 100) }}</p>
                        </div>
                    </div><!-- End Feature Borx-->
                    @empty
                    <div class="col-12 text-center">
                        <p>Belum ada kategori pengaduan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section><!-- /Features Section -->
@endsection
