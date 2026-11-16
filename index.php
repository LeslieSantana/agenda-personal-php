<?php
require_once __DIR__ . '/includes/auth.php';
redirect(!empty($_SESSION['user_id']) ? 'dashboard.php' : 'login.php');
