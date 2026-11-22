<?php
$pageTitle = $pageTitle ?? 'Agenda personal';
$flash = get_flash();
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | Mi Agenda</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="<?= !empty($_SESSION['user_id']) ? 'dashboard.php' : 'login.php' ?>">✦ Mi Agenda</a>
  <?php if (!empty($_SESSION['user_id'])): ?>
    <nav><a href="dashboard.php">Mis contactos</a><a href="logout.php">Cerrar sesión</a></nav>
  <?php else: ?>
    <nav><a href="login.php">Ingresar</a><a href="registro.php">Crear cuenta</a></nav>
  <?php endif; ?>
</header>
<main class="container">
<?php if ($flash): ?>
  <div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>
