<?php
require_once __DIR__ . '/includes/auth.php';
if (!empty($_SESSION['user_id'])) redirect('dashboard.php');
$error = '';
$correo = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $correo = strtolower(trim($_POST['correo'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, nombre, correo, password FROM usuarios WHERE correo = ? LIMIT 1');
    $stmt->execute([$correo]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_nombre'] = $user['nombre'];
        $_SESSION['user_correo'] = $user['correo'];
        unset($_SESSION['csrf_token']);
        set_flash('¡Bienvenido/a, ' . $user['nombre'] . '!');
        redirect('dashboard.php');
    }
    $error = 'Correo o contraseña incorrectos.';
}
$pageTitle = 'Iniciar sesión';
require __DIR__ . '/includes/header.php';
?>
<section class="card auth-card">
  <div class="eyebrow">Tu espacio personal</div><h1>Iniciar sesión</h1>
  <p class="muted">Ingresa tus datos para acceder a tus contactos.</p>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <div class="form-group"><label for="correo">Correo electrónico</label><input id="correo" type="email" name="correo" required value="<?= e($correo) ?>" autocomplete="username"></div>
    <div class="form-group"><label for="password">Contraseña</label><input id="password" type="password" name="password" required autocomplete="current-password"></div>
    <button class="btn" type="submit">Ingresar</button>
  </form>
  <p class="muted" style="margin-top:18px">¿No tienes cuenta? <a class="link" href="registro.php">Regístrate aquí</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
