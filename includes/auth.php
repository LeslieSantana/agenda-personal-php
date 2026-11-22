<?php
declare(strict_types=1);

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
ini_set('session.use_strict_mode', '1');
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        set_flash('Inicia sesión para continuar.', 'warning');
        redirect('login.php');
    }
}
