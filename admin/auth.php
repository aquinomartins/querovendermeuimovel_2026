<?php
require_once __DIR__ . '/config.php';

function requireLogin(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}
