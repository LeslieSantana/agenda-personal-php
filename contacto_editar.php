<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(404); exit('Contacto no encontrado.'); }
$stmt = $pdo->prepare('SELECT id, nombre, telefono, correo, ciudad FROM contactos WHERE id = ? AND id_usuario = ?');
$stmt->execute([$id, $_SESSION['user_id']]);
$contacto = $stmt->fetch();
if (!$contacto) { http_response_code(404); exit('Contacto no encontrado.'); }

$errors = [];
$data = $contacto;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    foreach (['nombre','telefono','correo','ciudad'] as $key) $data[$key] = trim($_POST[$key] ?? '');
    if (mb_strlen($data['nombre']) < 2 || mb_strlen($data['nombre']) > 100) $errors[] = 'El nombre debe tener entre 2 y 100 caracteres.';
    if ($data['telefono'] === '' || mb_strlen($data['telefono']) > 30) $errors[] = 'Ingresa un teléfono válido (máximo 30 caracteres).';
    if ($data['correo'] !== '' && (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['correo']) > 150)) $errors[] = 'El correo del contacto no es válido.';
    if (mb_strlen($data['ciudad']) > 100) $errors[] = 'La ciudad no puede superar 100 caracteres.';
    if (!$errors) {
        $stmt = $pdo->prepare('UPDATE contactos SET nombre=?, telefono=?, correo=?, ciudad=? WHERE id=? AND id_usuario=?');
        $stmt->execute([$data['nombre'], $data['telefono'], $data['correo'] ?: null, $data['ciudad'], $id, $_SESSION['user_id']]);
        set_flash('Contacto actualizado correctamente.');
        redirect('dashboard.php');
    }
}
$pageTitle = 'Editar contacto';
require __DIR__ . '/includes/header.php';
?>
<section class="card auth-card">
<h1>Editar contacto</h1><p class="muted">Modifica los datos y guarda los cambios.</p>
<?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<?php foreach (['nombre'=>'Nombre','telefono'=>'Teléfono','correo'=>'Correo electrónico','ciudad'=>'Ciudad'] as $key=>$label): ?>
<div class="form-group"><label for="<?= e($key) ?>"><?= e($label) ?></label>
<input id="<?= e($key) ?>" name="<?= e($key) ?>" <?= $key==='correo'?'type="email"':'' ?> maxlength="<?= $key==='telefono'?30:($key==='correo'?150:100) ?>" <?= $key==='nombre'||$key==='telefono'?'required':'' ?> value="<?= e($data[$key]) ?>"></div>
<?php endforeach; ?>
<div class="form-actions"><button class="btn" type="submit">Guardar cambios</button><a class="btn secondary" href="dashboard.php">Cancelar</a></div>
</form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
