<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido.'); }
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { set_flash('Contacto no válido.', 'error'); redirect('dashboard.php'); }
$stmt = $pdo->prepare('DELETE FROM contactos WHERE id = ? AND id_usuario = ?');
$stmt->execute([$id, $_SESSION['user_id']]);
set_flash($stmt->rowCount() ? 'Contacto eliminado correctamente.' : 'No se encontró el contacto.', $stmt->rowCount() ? 'success' : 'warning');
redirect('dashboard.php');
