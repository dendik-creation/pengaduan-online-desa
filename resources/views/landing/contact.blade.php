@extends('landing.layout')

@section('title', 'Kontak - Pengaduan Online Desa')
@section('description', 'Hubungi kami untuk informasi lebih lanjut tentang sistem pengaduan desa')
@section('keywords', 'kontak, hubungi, pengaduan, desa, informasi')
@section('body-class', 'starter-page-page')

@section('content')
  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container">
      <h1>Kontak Kami</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="/">Beranda</a></li>
          <li class="current">Kontak</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Contact Section -->
  <section id="contact" class="contact section">

    <div class="container section-title" data-aos="fade-up">
      <h2>Hubungi Kami</h2>
      <p>Kami siap membantu Anda. Silakan hubungi kami melalui berbagai cara berikut atau kunjungi kantor desa kami.</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-geo-alt"></i>
            <h3>Alamat</h3>
            <p>{{ $contactInfo['address'] }}</p>
          </div>
        </div><!-- End Info Item -->

        <div class="col-lg-3 col-md-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-telephone"></i>
            <h3>Telepon</h3>
            <p>{{ $contactInfo['phone'] }}</p>
          </div>
        </div><!-- End Info Item -->

        <div class="col-lg-3 col-md-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-envelope"></i>
            <h3>Email</h3>
            <p>{{ $contactInfo['email'] }}</p>
          </div>
        </div><!-- End Info Item -->

      </div>

      <div class="row gy-4 mt-1">
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.495827742998!2d112.7917885!3d-7.29657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fa10ea2ae883%3A0xbe22c55d60ef09c7!2sSurabaya%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1699000000000!5m2!1sen!2sid" frameborder="0" style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div><!-- End Google Maps -->

        <div class="col-lg-6">
          <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="400">
            <div class="row gy-4">

              <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Nama Anda" required="">
              </div>

              <div class="col-md-6 ">
                <input type="email" class="form-control" name="email" placeholder="Email Anda" required="">
              </div>

              <div class="col-md-12">
                <input type="text" class="form-control" name="subject" placeholder="Subjek" required="">
              </div>

              <div class="col-md-12">
                <textarea class="form-control" name="message" rows="6" placeholder="Pesan" required=""></textarea>
              </div>

              <div class="col-md-12 text-center">
                <div class="loading">Mengirim...</div>
                <div class="error-message"></div>
                <div class="sent-message">Pesan Anda telah berhasil dikirim. Terima kasih!</div>

                <button class="btn btn-primary w-100" type="submit">Kirim Pesan</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>

    </div>

  </section><!-- /Contact Section -->

  <!-- Quick Contact Section -->
  <section class="section">
    <div class="container" data-aos="fade-up">
      <div class="row gy-4">
        
        <div class="col-lg-4 col-md-6">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-clock"></i>
            </div>
            <a href="#" class="stretched-link">
              <h3>Jam Operasional</h3>
            </a>
            <p>Senin - Jumat: {{ $contactInfo['working_hours']['weekdays'] }}<br>
               Sabtu: {{ $contactInfo['working_hours']['saturday'] }}<br>
               Minggu: {{ $contactInfo['working_hours']['sunday'] }}</p>
          </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 col-md-6">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-whatsapp"></i>
            </div>
            <a href="#" class="stretched-link">
              <h3>WhatsApp</h3>
            </a>
            <p>Hubungi kami melalui WhatsApp untuk respon yang lebih cepat:<br>
               <strong>{{ $contactInfo['whatsapp'] }}</strong></p>
          </div>
        </div><!-- End Service Item -->

        <div class="col-lg-4 col-md-6">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-headset"></i>
            </div>
            <a href="#" class="stretched-link">
              <h3>Layanan Darurat</h3>
            </a>
            <p>Untuk pengaduan mendesak dan darurat, hubungi hotline 24 jam:<br>
               <strong>{{ $contactInfo['emergency'] }}</strong></p>
          </div>
        </div><!-- End Service Item -->

      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Pertanyaan Yang Sering Diajukan</h2>
      <p>Beberapa pertanyaan yang sering ditanyakan mengenai sistem pengaduan online desa</p>
    </div>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
          <div class="faq-container">

            <div class="faq-item faq-active">
              <h3>Bagaimana cara mengajukan pengaduan?</h3>
              <div class="faq-content">
                <p>Anda dapat mengajukan pengaduan melalui sistem online dengan login terlebih dahulu, atau datang langsung ke kantor desa pada jam operasional. Pastikan melengkapi data dan deskripsi pengaduan dengan jelas.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Berapa lama waktu penanganan pengaduan?</h3>
              <div class="faq-content">
                <p>Waktu penanganan bervariasi tergantung jenis dan kompleksitas pengaduan. Pengaduan ringan biasanya ditangani dalam 3-7 hari kerja, sedangkan pengaduan kompleks dapat memakan waktu 2-4 minggu.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Bagaimana cara mengecek status pengaduan?</h3>
              <div class="faq-content">
                <p>Anda dapat mengecek status pengaduan melalui sistem online dengan login menggunakan akun Anda, atau menghubungi kantor desa dengan menyebutkan nomor pengaduan yang diberikan saat pengajuan.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Apakah ada biaya untuk mengajukan pengaduan?</h3>
              <div class="faq-content">
                <p>Tidak ada biaya apapun untuk mengajukan pengaduan. Semua layanan pengaduan masyarakat adalah gratis sebagai bagian dari pelayanan publik desa.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Apa saja jenis pengaduan yang dapat diajukan?</h3>
              <div class="faq-content">
                <p>Kami menerima berbagai jenis pengaduan seperti infrastruktur desa, pelayanan publik, kebersihan lingkungan, keamanan, dan masalah sosial lainnya yang berkaitan dengan kehidupan bermasyarakat di desa.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Bagaimana jika pengaduan saya tidak ditanggapi?</h3>
              <div class="faq-content">
                <p>Jika pengaduan Anda tidak mendapat tanggapan dalam waktu yang wajar, Anda dapat menghubungi langsung kepala desa atau mengirim pengaduan lanjutan melalui sistem. Kami berkomitmen untuk merespon setiap pengaduan masyarakat.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

          </div>
        </div>
      </div>
    </div>
  </section><!-- /Faq Section -->
@endsection