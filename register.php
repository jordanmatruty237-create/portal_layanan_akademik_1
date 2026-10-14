<?php
require_once 'config.php';
require_once 'includes/functions.php';
if (current_user()) redirect('dashboard.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $studentId = trim($_POST['student_id'] ?? '');
    $faculty = trim($_POST['faculty'] ?? '');
    $program = trim($_POST['study_program'] ?? '');
    $password = $_POST['password'] ?? '';
    if (strlen($password) < 8) $error = 'Kata sandi minimal 8 karakter.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Format email tidak valid.';
    else {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash,role,student_id,faculty,study_program) VALUES (?,?,?,"user",?,?,?)');
            $stmt->execute([$name,$email,password_hash($password, PASSWORD_DEFAULT),$studentId ?: null,$faculty ?: null,$program ?: null]);
            flash('Pendaftaran berhasil. Silakan masuk menggunakan akunmu.');
            redirect('login.php');
        } catch (PDOException $ex) {
            $error = $ex->getCode() === '23000' ? 'Email sudah terdaftar. Silakan gunakan email lain.' : 'Pendaftaran belum berhasil. Periksa kembali data dan database.';
        }
    }
}
$pageTitle = 'Daftar Akun';
require 'includes/header.php';
?>
<main id="main-content" class="auth-page"><div class="auth-shell"><div class="auth-aside"><a class="brand" href="index.php"><span class="brand-mark">A</span><span><strong>akademika</strong><small>Portal Layanan Akademik</small></span></a><div class="auth-aside-copy"><span class="eyebrow">AKUN MAHASISWA</span><h1>Satu akun untuk kebutuhan akademikmu.</h1><p>Buat akun agar kamu dapat mengirim permohonan dan melihat perkembangan layanan.</p><div class="auth-benefit">✓ <span>Riwayat permohonan tersimpan</span></div></div><div class="auth-aside-footer">Data akun digunakan untuk demo portal akademik.</div></div><div class="auth-form-side"><form class="form-card auth-form" method="post" action="register.php"><h2>Buat akun baru</h2><p class="muted">Lengkapi data di bawah ini.</p>
<?php if ($error): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="field"><label for="name">Nama lengkap <span class="required">*</span></label><input id="name" name="name" autocomplete="name" required maxlength="120" placeholder="Nama sesuai identitas"></div>
<div class="field"><label for="email">Email aktif <span class="required">*</span></label><input id="email" name="email" type="email" autocomplete="email" required maxlength="190" placeholder="nama@email.com"></div>
<div class="field"><label for="student_id">NIM</label><input id="student_id" name="student_id" maxlength="40" placeholder="Nomor induk mahasiswa"></div>
<div class="form-grid"><div class="field"><label for="faculty">Fakultas</label><input id="faculty" name="faculty" maxlength="120" placeholder="Nama fakultas"></div><div class="field"><label for="study_program">Program studi</label><input id="study_program" name="study_program" maxlength="120" placeholder="Program studi"></div></div>
<div class="field"><label for="password">Kata sandi <span class="required">*</span></label><input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required placeholder="Minimal 8 karakter"><small class="field-help">Gunakan minimal 8 karakter.</small></div>
<button class="button button-full" type="submit">Daftar akun <span aria-hidden="true">→</span></button><p class="form-foot">Sudah punya akun? <a href="login.php">Masuk</a></p></form></div></div></main>
<?php require 'includes/footer.php'; ?>
