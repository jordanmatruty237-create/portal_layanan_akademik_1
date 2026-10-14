<?php
require_once 'config.php'; require_once 'includes/functions.php'; require_login();
if (current_user()['role'] === 'admin') redirect('admin/index.php');
$user = current_user();
$stmt = $pdo->prepare('SELECT COUNT(*) FROM requests WHERE user_id = ?'); $stmt->execute([$user['id']]); $total = (int)$stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT COUNT(*) FROM requests WHERE user_id = ? AND status IN ('Menunggu','Diproses')"); $stmt->execute([$user['id']]); $ongoing = (int)$stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT * FROM requests WHERE user_id = ? ORDER BY created_at DESC LIMIT 5"); $stmt->execute([$user['id']]); $requests = $stmt->fetchAll();
$pageTitle = 'Dashboard Pengguna'; require 'includes/header.php';
?>
<main id="main-content" class="dashboard-page"><div class="container">
<div class="page-heading"><div><span class="eyebrow">DASHBOARD MAHASISWA</span><h1>Halo, <?= e($user['name']) ?>! 👋</h1><p>Selamat datang. Berikut ringkasan aktivitas layanan akademikmu.</p></div><a class="button" href="request.php">+ Buat permohonan</a></div>
<div class="stats-grid"><article class="stat-card"><span class="stat-icon blue-icon">▤</span><span class="stat-label">Total permohonan</span><strong><?= $total ?></strong><small>Semua pengajuanmu</small></article><article class="stat-card"><span class="stat-icon orange-icon">◷</span><span class="stat-label">Sedang diproses</span><strong><?= $ongoing ?></strong><small>Menunggu atau diproses</small></article><article class="stat-card"><span class="stat-icon green-icon">✓</span><span class="stat-label">Data akun</span><strong><?= $user['student_id'] ? 'Lengkap' : 'Periksa' ?></strong><small><?= $user['student_id'] ? e($user['student_id']) : 'Tambahkan NIM saat diperlukan' ?></small></article></div>
<section class="panel"><div class="panel-heading"><div><h2>Permohonan terbaru</h2><p>Perkembangan pengajuan layanan akademikmu.</p></div><a class="text-link" href="request.php">Lihat semua →</a></div>
<?php if (!$requests): ?><div class="empty-state"><span class="empty-icon">▤</span><h3>Belum ada permohonan</h3><p>Permohonan layanan yang kamu kirim akan muncul di sini.</p><a class="button" href="request.php">Ajukan layanan pertama</a></div>
<?php else: ?><div class="table-wrap"><table><thead><tr><th>Nomor</th><th>Layanan</th><th>Tanggal</th><th>Status</th></tr></thead><tbody><?php foreach ($requests as $r): ?><tr><td>#<?= (int)$r['id'] ?></td><td><strong><?= e($r['service_name']) ?></strong><small class="table-sub"><?= e($r['purpose']) ?></small></td><td><?= e(date('d M Y', strtotime($r['created_at']))) ?></td><td><span class="status status-<?= strtolower(str_replace(' ','-', $r['status'])) ?>"><?= e($r['status']) ?></span></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</section>
<section class="quick-services"><div class="panel-heading"><div><h2>Butuh layanan lain?</h2><p>Pilih layanan sesuai kebutuhan akademik.</p></div></div><div class="quick-grid"><a href="request.php?service=Surat%20Aktif%20Kuliah">▤ <span>Surat Aktif Kuliah</span> <b>→</b></a><a href="request.php?service=Transkrip%20Sementara">▧ <span>Transkrip Sementara</span> <b>→</b></a><a href="request.php?service=Cuti%20Akademik">◷ <span>Cuti Akademik</span> <b>→</b></a></div></section>
</div></main><?php require 'includes/footer.php'; ?>
