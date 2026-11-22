<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$errors = [];
$data = ['nombre'=>'', 'telefono'=>'', 'correo'=>'', 'ciudad'=>'', 'id_categoria'=>'', 'favorito'=>'0'];
$categorias = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre ASC')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    foreach (['nombre','telefono','correo','ciudad'] as $key) $data[$key] = trim($_POST[$key] ?? '');
    $data['id_categoria'] = trim($_POST['id_categoria'] ?? '');
    $data['favorito'] = isset($_POST['favorito']) ? '1' : '0';
    if (mb_strlen($data['nombre']) < 2 || mb_strlen($data['nombre']) > 100) $errors[] = 'El nombre debe tener entre 2 y 100 caracteres.';
    if ($data['telefono'] === '' || mb_strlen($data['telefono']) > 30) $errors[] = 'Ingresa un teléfono válido (máximo 30 caracteres).';
    if ($data['correo'] !== '' && (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['correo']) > 150)) $errors[] = 'El correo del contacto no es válido.';
    if (mb_strlen($data['ciudad']) > 100) $errors[] = 'La ciudad no puede superar 100 caracteres.';
    $categoriaId = filter_var($data['id_categoria'], FILTER_VALIDATE_INT);
    if (!$categoriaId || !in_array($categoriaId, array_map('intval', array_column($categorias, 'id')), true)) $errors[] = 'Selecciona una categoría válida.';
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad, id_categoria, favorito) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $data['nombre'], $data['telefono'], $data['correo'] ?: null, $data['ciudad'], $categoriaId, (int)$data['favorito']]);
        set_flash('Contacto registrado correctamente.');
        redirect('dashboard.php');
    }
}
$pageTitle = 'Nuevo contacto';
require __DIR__ . '/includes/header.php';
?>
<section class="card auth-card">
<h1>Agregar contacto</h1><p class="muted">Completa la información del contacto.</p>
<?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<?php foreach (['nombre'=>'Nombre','telefono'=>'Teléfono','correo'=>'Correo electrónico','ciudad'=>'Ciudad'] as $key=>$label): ?>
<div class="form-group"><label for="<?= e($key) ?>"><?= e($label) ?><?= $key==='nombre'||$key==='telefono'?' <span class="required">*</span>':'' ?></label>
<input id="<?= e($key) ?>" name="<?= e($key) ?>" <?= $key==='correo'?'type="email"':'' ?> maxlength="<?= $key==='telefono'?30:($key==='correo'?150:100) ?>" <?= $key==='nombre'||$key==='telefono'?'required':'' ?> value="<?= e($data[$key]) ?>"></div>
<?php endforeach; ?>
<div class="form-group"><label for="id_categoria">Categoría</label>
<select id="id_categoria" name="id_categoria" required>
<option value="">Selecciona una categoría</option>
<?php foreach ($categorias as $cat): ?><option value="<?= (int)$cat['id'] ?>" <?= (string)$cat['id'] === $data['id_categoria'] ? 'selected' : '' ?>><?= e($cat['nombre']) ?></option><?php endforeach; ?>
</select></div>
<div class="form-group"><label class="checkbox-label"><input type="checkbox" name="favorito" value="1" <?= $data['favorito'] === '1' ? 'checked' : '' ?>> Marcar como favorito</label></div>
<div class="form-actions"><button class="btn" type="submit">Guardar contacto</button><a class="btn secondary" href="dashboard.php">Cancelar</a></div>
</form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
