<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido.'); }
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$favorito = filter_input(INPUT_POST, 'favorito', FILTER_VALIDATE_INT);
if (!$id || $id < 1 || !in_array($favorito, [0, 1], true)) {
    set_flash('No se pudo actualizar el favorito.', 'error');
    redirect('dashboard.php');
}
$stmt = $pdo->prepare('UPDATE contactos SET favorito = ? WHERE id = ? AND id_usuario = ?');
$stmt->execute([$favorito, $id, $_SESSION['user_id']]);
set_flash($favorito ? 'Contacto agregado a favoritos.' : 'Contacto quitado de favoritos.');
redirect('dashboard.php');
