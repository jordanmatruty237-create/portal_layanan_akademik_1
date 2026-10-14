<?php
require_once 'config.php'; require_once 'includes/functions.php'; require_login();
if (current_user()['role'] === 'admin') redirect('admin/index.php');
$user = current_user(); $error = '';
$services = $pdo->query('SELECT id, name, description FROM services WHERE active = 1 ORDER BY id')->fetchAll();
$chosen = trim($_GET['service'] ?? '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $serviceId = (int)($_POST['service_id'] ?? 0);
    $purpose = trim($_POST['purpose'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $stmt = $pdo->prepare('SELECT id,name FROM services WHERE id = ? AND active = 1'); $stmt->execute([$serviceId]); $service = $stmt->fetch();
    if (!$service) $error = 'Pilih jenis layanan yang tersedia.';
    elseif (mb_strlen($purpose) < 5) $error = 'Keperluan harus diisi minimal 5 karakter.';
    else {
        $stmt = $pdo->prepare("INSERT INTO requests (user_id, service_id, service_name, purpose, details, status) VALUES (?,?,?,?,?,'Menunggu')");
        $stmt->execute([$user['id'], $service['id'], $service['name'], $purpose, $details ?: null]);
        flash('Permohonan berhasil dikirim. Kamu dapat memantau statusnya di dashboard.');
        redirect('dashboard.php');
    }
}
$pageTitle = 'Form Permohonan'; require 'includes/header.php';
?>
<main id="main-content" class="dashboard-page"><div class="container narrow-container">
<div class="page-heading"><div><span class="eyebrow">LAYANAN AKADEMIK</span><h1>Form permohonan</h1><p>Isi data dengan benar agar permohonan dapat ditinjau oleh admin.</p></div><a class="button button-outline" href="dashboard.php">← Dashboard</a></div>
<div class="form-card request-card"><div class="form-intro"><span class="service-icon blue-icon">▤</span><div><h2>Detail permohonan</h2><p>Kolom bertanda <span class="required">*</span> wajib diisi.</p></div></div>
<?php if ($error): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post" action="request.php"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="form-grid"><div class="field"><label for="full_name">Nama pemohon</label><input id="full_name" value="<?= e($user['name']) ?>" readonly></div><div class="field"><label for="student_id">NIM</label><input id="student_id" value="<?= e($user['student_id'] ?? '') ?>" readonly></div></div>
<div class="field"><label for="email">Email pemohon</label><input id="email" type="email" value="<?= e($user['email']) ?>" readonly></div>
<div class="field"><label for="service_id">Jenis layanan <span class="required">*</span></label><select id="service_id" name="service_id" required><option value="">Pilih jenis layanan</option><?php foreach ($services as $s): ?><option value="<?= (int)$s['id'] ?>" <?= ($chosen === $s['name'] || (isset($_POST['service_id']) && (int)$_POST['service_id'] === (int)$s['id'])) ? 'selected' : '' ?>><?= e($s['name']) ?></option><?php endforeach; ?></select></div>
<div class="field"><label for="purpose">Keperluan <span class="required">*</span></label><input id="purpose" name="purpose" required minlength="5" maxlength="180" value="<?= e($_POST['purpose'] ?? '') ?>" placeholder="Contoh: Persyaratan pengajuan beasiswa"><small class="field-help">Jelaskan tujuan permohonan secara singkat.</small></div>
<div class="field"><label for="details">Keterangan tambahan</label><textarea id="details" name="details" rows="5" maxlength="2000" placeholder="Tambahkan informasi pendukung jika diperlukan"><?= e($_POST['details'] ?? '') ?></textarea><small class="field-help">Maksimal 2.000 karakter. Jangan masukkan kata sandi atau data rahasia.</small></div>
<div class="form-actions"><a class="button button-outline" href="dashboard.php">Batal</a><button class="button" type="submit">Kirim permohonan <span aria-hidden="true">→</span></button></div></form></div>
</div></main><?php require 'includes/footer.php'; ?>
