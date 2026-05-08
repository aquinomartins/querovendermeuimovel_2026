<?php
require_once __DIR__ . '/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    $stmt = db()->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Credenciais inválidas.';
}
?><!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css"><title>Admin Login</title></head><body class="container" style="max-width:420px;padding-top:60px;"><h2>Painel Admin</h2><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><div class="form-group"><label>E-mail</label><input class="form-control" type="email" name="email" required></div><div class="form-group"><label>Senha</label><input class="form-control" type="password" name="password" required></div><button class="btn btn-primary" type="submit">Entrar</button></form></body></html>
