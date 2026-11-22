<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$busqueda = trim($_GET['buscar'] ?? '');
$orden = $_GET['orden'] ?? 'nombre';
$categoria = filter_input(INPUT_GET, 'categoria', FILTER_VALIDATE_INT);
$soloFavoritos = ($_GET['favoritos'] ?? '') === '1';

$ordenamientos = [
    'nombre' => 'c.nombre ASC',
    'ciudad' => 'c.ciudad ASC, c.nombre ASC',
];
if (!isset($ordenamientos[$orden])) {
    $orden = 'nombre';
}

$categoriasStmt = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre ASC');
$categorias = $categoriasStmt->fetchAll();

$sql = 'SELECT c.id, c.nombre, c.telefono, c.correo, c.ciudad, c.id_categoria, c.favorito, cat.nombre AS categoria_nombre
        FROM contactos c
        INNER JOIN categorias cat ON cat.id = c.id_categoria
        WHERE c.id_usuario = ?';
$params = [$_SESSION['user_id']];

if ($busqueda !== '') {
    $sql .= ' AND (c.nombre LIKE ? OR c.correo LIKE ? OR c.ciudad LIKE ?)';
    $termino = '%' . $busqueda . '%';
    array_push($params, $termino, $termino, $termino);
}
if ($categoria && $categoria > 0) {
    $sql .= ' AND c.id_categoria = ?';
    $params[] = $categoria;
}
if ($soloFavoritos) {
    $sql .= ' AND c.favorito = 1';
}
$sql .= ' ORDER BY ' . $ordenamientos[$orden];

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$contactos = $stmt->fetchAll();

$pageTitle = 'Mis contactos';
require __DIR__ . '/includes/header.php';
?>
<section class="card">
  <div class="dashboard-head">
    <div>
      <div class="eyebrow">Panel principal</div>
      <h1>Hola, <?= e($_SESSION['user_nombre']) ?></h1>
      <p class="user-meta"><?= e($_SESSION['user_correo']) ?> · Aquí puedes administrar tu agenda.</p>
    </div>
    <a class="btn" href="contacto_nuevo.php">+ Agregar contacto</a>
  </div>
</section>

<section class="card">
  <h2>Mis contactos <span class="muted">(<?= count($contactos) ?>)</span></h2>
  <form method="GET" action="dashboard.php" class="filters">
    <div class="form-group">
      <label for="buscar">Buscar por nombre, correo o ciudad</label>
      <input type="search" id="buscar" name="buscar" placeholder="Escribe para buscar..." value="<?= e($busqueda) ?>">
    </div>
    <div class="form-group">
      <label for="orden">Ordenar por</label>
      <select id="orden" name="orden">
        <option value="nombre" <?= $orden === 'nombre' ? 'selected' : '' ?>>Nombre (A-Z)</option>
        <option value="ciudad" <?= $orden === 'ciudad' ? 'selected' : '' ?>>Ciudad (A-Z)</option>
      </select>
    </div>
    <div class="form-group">
      <label for="categoria">Categoría</label>
      <select id="categoria" name="categoria">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= (int)$cat['id'] ?>" <?= $categoria === (int)$cat['id'] ? 'selected' : '' ?>><?= e($cat['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="filter-bottom">
      <label class="checkbox-label"><input type="checkbox" name="favoritos" value="1" <?= $soloFavoritos ? 'checked' : '' ?>> Mostrar solo favoritos</label>
      <div class="form-actions">
        <button class="btn" type="submit">Aplicar filtros</button>
        <a class="btn secondary" href="dashboard.php">Limpiar</a>
      </div>
    </div>
  </form>

  <?php if (!$contactos): ?>
    <div class="empty">No se encontraron contactos con los filtros seleccionados.</div>
  <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Favorito</th><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Ciudad</th><th>Categoría</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php foreach ($contactos as $c): ?>
          <tr>
            <td>
              <form method="post" action="contacto_favorito.php">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <input type="hidden" name="favorito" value="<?= $c['favorito'] ? '0' : '1' ?>">
                <button class="favorite-button" type="submit" aria-label="<?= $c['favorito'] ? 'Quitar de favoritos' : 'Agregar a favoritos' ?>" title="<?= $c['favorito'] ? 'Quitar de favoritos' : 'Agregar a favoritos' ?>"><?= $c['favorito'] ? '★' : '☆' ?></button>
              </form>
            </td>
            <td><strong><?= e($c['nombre']) ?></strong></td>
            <td><?= e($c['telefono']) ?></td>
            <td><?= e($c['correo']) ?></td>
            <td><?= e($c['ciudad']) ?></td>
            <td><span class="category-tag"><?= e($c['categoria_nombre']) ?></span></td>
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
      </table>
    </div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
