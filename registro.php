<?php
require_once __DIR__ . '/includes/auth.php';
if (!empty($_SESSION['user_id'])) redirect('dashboard.php');
$errors = [];
$nombre = '';
$correo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = strtolower(trim($_POST['correo'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($nombre === '' || mb_strlen($nombre) < 2 || mb_strlen($nombre) > 100) $errors[] = 'Ingresa un nombre entre 2 y 100 caracteres.';
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || mb_strlen($correo) > 150) $errors[] = 'Ingresa un correo electrónico válido.';
    if (strlen($password) < 8) $errors[] = 'La contraseña debe tener al menos 8 caracteres.';

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE correo = ?');
        $stmt->execute([$correo]);
        if ($stmt->fetch()) {
            $errors[] = 'Ese correo ya está registrado.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)');
            $stmt->execute([$nombre, $correo, $hash]);
            set_flash('Cuenta creada correctamente. Ya puedes iniciar sesión.');
            redirect('login.php');
        }
    }
}
$pageTitle = 'Crear cuenta';
require __DIR__ . '/includes/header.php';
?>
<section class="card auth-card">
  <div class="eyebrow">Bienvenido</div><h1>Crear una cuenta</h1>
  <p class="muted">Regístrate para comenzar tu agenda personal.</p>
  <?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <div class="form-group"><label for="nombre">Nombre completo</label><input id="nombre" name="nombre" maxlength="100" required value="<?= e($nombre) ?>"></div>
    <div class="form-group"><label for="correo">Correo electrónico</label><input id="correo" type="email" name="correo" maxlength="150" required value="<?= e($correo) ?>"></div>
    <div class="form-group"><label for="password">Contraseña (mínimo 8 caracteres)</label><input id="password" type="password" name="password" minlength="8" required autocomplete="new-password"></div>
    <button class="btn" type="submit">Registrarme</button>
  </form>
  <p class="muted" style="margin-top:18px">¿Ya tienes cuenta? <a class="link" href="login.php">Inicia sesión</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
