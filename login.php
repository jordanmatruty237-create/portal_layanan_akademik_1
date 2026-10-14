<?php
require_once 'config.php';
require_once 'includes/functions.php';
if (current_user()) redirect(current_user()['role'] === 'admin' ? 'admin/index.php' : 'dashboard.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, name, email, password_hash, role, student_id, faculty, study_program FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        unset($user['password_hash']);
        $_SESSION['user'] = $user;
        redirect($user['role'] === 'admin' ? 'admin/index.php' : 'dashboard.php');
    }
    $error = 'Email atau kata sandi tidak sesuai.';
}
$pageTitle = 'Masuk';
require 'includes/header.php';
?>
<main id="main-content" class="auth-page"><div class="auth-shell"><div class="auth-aside"><a class="brand" href="index.php"><span class="brand-mark">A</span><span><strong>akademika</strong><small>Portal Layanan Akademik</small></span></a><div class="auth-aside-copy"><span class="eyebrow">SELAMAT DATANG KEMBALI</span><h1>Akademik jadi lebih sederhana.</h1><p>Masuk untuk mengajukan layanan dan memantau proses administrasi akademikmu.</p><div class="auth-benefit">✓ <span>Praktis, tertata, dan mudah dipantau</span></div></div><div class="auth-aside-footer">Portal Layanan Akademik · Demo pembelajaran</div></div><div class="auth-form-side"><form class="form-card auth-form" method="post" action="login.php">
<h2>Masuk ke akun</h2><p class="muted">Gunakan email dan kata sandi yang terdaftar.</p>
<?php if ($error): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="field"><label for="email">Alamat email</label><input id="email" name="email" type="email" autocomplete="username" placeholder="nama@email.com" required></div>
<div class="field"><label for="password">Kata sandi</label><input id="password" name="password" type="password" autocomplete="current-password" placeholder="Masukkan kata sandi" required></div>
<button class="button button-full" type="submit">Masuk <span aria-hidden="true">→</span></button>
<p class="form-foot">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
<p class="small-note">Admin juga masuk melalui halaman ini. Sistem akan mengarahkan akun sesuai perannya.</p>
</form></div></div></main>
<?php require 'includes/footer.php'; ?>
