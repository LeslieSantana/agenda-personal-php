<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$stmt = $pdo->prepare('SELECT id, nombre, telefono, correo, ciudad FROM contactos WHERE id_usuario = ? ORDER BY nombre ASC');
$stmt->execute([$_SESSION['user_id']]);
$contactos = $stmt->fetchAll();

$pageTitle = 'Mis contactos';
require __DIR__ . '/includes/header.php';
?>
<section class="card">
  <div class="dashboard-head">
    <div><div class="eyebrow">Panel principal</div><h1>Hola, <?= e($_SESSION['user_nombre']) ?></h1>
      <p class="user-meta"><?= e($_SESSION['user_correo']) ?> · Aquí puedes administrar tu agenda.</p></div>
    <a class="btn" href="contacto_nuevo.php">+ Agregar contacto</a>
  </div>
</section>
<section class="card">
  <h2>Mis contactos <span class="muted">(<?= count($contactos) ?>)</span></h2>
  <?php if (!$contactos): ?>
    <div class="empty">Todavía no tienes contactos. Selecciona “Agregar contacto” para registrar el primero.</div>
  <?php else: ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Ciudad</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach ($contactos as $c): ?>
      <tr>
        <td><strong><?= e($c['nombre']) ?></strong></td><td><?= e($c['telefono']) ?></td><td><?= e($c['correo']) ?></td><td><?= e($c['ciudad']) ?></td>
        <td><div class="actions">
          <a class="btn secondary small" href="contacto_editar.php?id=<?= (int)$c['id'] ?>">Editar</a>
          <form method="post" action="contacto_eliminar.php" onsubmit="return confirm('¿Seguro que deseas eliminar este contacto?');">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
            <button class="btn danger small" type="submit">Eliminar</button>
          </form>
        </div></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table></div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
