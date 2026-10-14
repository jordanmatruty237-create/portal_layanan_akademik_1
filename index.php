<?php
require_once 'config.php';
require_once 'includes/functions.php';
$pageTitle = 'Beranda';
require 'includes/header.php';
?>
<main id="main-content">
  <section class="hero">
    <div class="container hero-grid">
      <div class="hero-copy">
        <span class="eyebrow"><span class="eyebrow-dot"></span> Pusat layanan mahasiswa</span>
        <h1>Urus kebutuhan akademik, <span>lebih mudah.</span></h1>
        <p class="hero-lead">Ajukan surat, akses layanan akademik, dan pantau status permohonanmu dalam satu portal yang praktis dan transparan.</p>
        <div class="hero-actions">
          <a class="button" href="<?= current_user() ? (current_user()['role'] === 'admin' ? 'admin/index.php' : 'dashboard.php') : 'register.php' ?>">Mulai sekarang <span aria-hidden="true">→</span></a>
          <a class="button button-outline" href="#layanan">Jelajahi layanan</a>
        </div>
        <div class="trust-row"><span class="trust-icon" aria-hidden="true">✓</span><span>Alur jelas</span><span class="trust-icon" aria-hidden="true">✓</span><span>Status dapat dipantau</span></div>
      </div>
      <div class="hero-art" aria-label="Ilustrasi kartu layanan akademik">
        <div class="art-orbit orbit-one"></div><div class="art-orbit orbit-two"></div>
        <div class="art-card art-card-main">
          <div class="art-card-top"><span class="mini-logo">A</span><span class="status-pill">● Terpantau</span></div>
          <div class="art-label">Pusat layanan akademik</div>
          <div class="art-title">Halo, Mahasiswa! 👋</div>
          <div class="art-sub">Apa yang ingin kamu urus hari ini?</div>
          <div class="art-service"><span class="service-icon blue-icon">▤</span><span><b>Surat aktif kuliah</b><small>Dokumen akademik</small></span><span class="arrow">↗</span></div>
          <div class="art-service"><span class="service-icon violet-icon">▧</span><span><b>Transkrip sementara</b><small>Data hasil studi</small></span><span class="arrow">↗</span></div>
          <div class="art-service"><span class="service-icon green-icon">✓</span><span><b>Permohonan terkirim</b><small>Proses lebih terarah</small></span><span class="art-check">✓</span></div>
        </div>
        <div class="floating-note"><span class="floating-check">✓</span><span><b>Semua lebih tertata</b><small>Mulai dari satu tempat</small></span></div>
        <div class="decor decor-a"></div><div class="decor decor-b"></div>
      </div>
    </div>
  </section>
  <section class="section section-white" id="layanan">
    <div class="container">
      <div class="section-heading">
        <div><span class="eyebrow">LAYANAN KAMI</span><h2>Butuh bantuan akademik?</h2><p>Pilih layanan yang sesuai dengan kebutuhanmu.</p></div>
        <a class="text-link" href="request.php">Ajukan permohonan <span aria-hidden="true">→</span></a>
      </div>
      <div class="service-grid">
        <article class="service-card"><div class="service-icon blue-icon">▤</div><span class="card-kicker">DOKUMEN</span><h3>Surat Aktif Kuliah</h3><p>Ajukan surat keterangan mahasiswa aktif untuk keperluan beasiswa, administrasi, atau kebutuhan lainnya.</p><a href="request.php?service=Surat%20Aktif%20Kuliah" class="card-link">Ajukan layanan <span aria-hidden="true">→</span></a></article>
        <article class="service-card"><div class="service-icon violet-icon">▧</div><span class="card-kicker">HASIL STUDI</span><h3>Transkrip Sementara</h3><p>Ajukan permintaan transkrip nilai sementara untuk melengkapi berkas akademikmu.</p><a href="request.php?service=Transkrip%20Sementara" class="card-link">Ajukan layanan <span aria-hidden="true">→</span></a></article>
        <article class="service-card"><div class="service-icon orange-icon">◷</div><span class="card-kicker">ADMINISTRASI</span><h3>Cuti Akademik</h3><p>Sampaikan permohonan cuti akademik dengan informasi dan alasan yang jelas.</p><a href="request.php?service=Cuti%20Akademik" class="card-link">Ajukan layanan <span aria-hidden="true">→</span></a></article>
        <article class="service-card"><div class="service-icon green-icon">▣</div><span class="card-kicker">LEGALISASI</span><h3>Permohonan Legalisir</h3><p>Catat kebutuhan legalisir dokumen akademik dan pantau status permohonannya.</p><a href="request.php?service=Permohonan%20Legalisir" class="card-link">Ajukan layanan <span aria-hidden="true">→</span></a></article>
      </div>
    </div>
  </section>
  <section class="section how-section">
    <div class="container">
      <div class="section-heading centered"><div><span class="eyebrow">CARA KERJA</span><h2>Hanya tiga langkah sederhana</h2><p>Alur layanan yang mudah diikuti dari awal sampai selesai.</p></div></div>
      <div class="steps-grid">
        <article class="step-card"><span class="step-number">01</span><h3>Buat akun</h3><p>Daftar menggunakan nama, email, dan informasi mahasiswa.</p></article>
        <article class="step-card"><span class="step-number">02</span><h3>Kirim permohonan</h3><p>Pilih layanan, isi formulir, lalu kirim permohonanmu.</p></article>
        <article class="step-card"><span class="step-number">03</span><h3>Pantau status</h3><p>Lihat perkembangan permohonan melalui dashboard pengguna.</p></article>
      </div>
    </div>
  </section>
  <section class="cta-section"><div class="container cta-box"><div><span class="eyebrow">MULAI SEKARANG</span><h2>Layanan akademik dalam genggaman.</h2><p>Masuk ke akunmu atau daftar untuk mengajukan layanan.</p></div><div class="hero-actions"><a class="button button-white" href="register.php">Buat akun gratis <span aria-hidden="true">→</span></a><a class="cta-login" href="login.php">Sudah punya akun? Masuk</a></div></div></section>
</main>
<?php require 'includes/footer.php'; ?>
