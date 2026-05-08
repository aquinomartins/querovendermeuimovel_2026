<?php
require_once __DIR__ . '/config.php';

$totalAdmins = (int) db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
$success = '';
$error = '';

if ($totalAdmins > 0) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(strip_tags($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';

    if (!$name || !$email || !$password) {
        $error = 'Preencha todos os campos obrigatórios.';
    } elseif (strlen($password) < 8) {
        $error = 'A senha deve ter no mínimo 8 caracteres.';
    } elseif ($password !== $confirm) {
        $error = 'A confirmação de senha não confere.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare('INSERT INTO admins (name, email, password_hash) VALUES (:name, :email, :password_hash)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $hash,
        ]);
        $success = 'Usuário administrador criado com sucesso. Você já pode fazer login.';
    }
}
?><!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar primeiro administrador</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container" style="max-width:580px;padding-top:40px;">
<h2>Criar primeiro administrador</h2>
<p>Use esta tela apenas para o primeiro acesso ao painel.</p>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><p><a class="btn btn-primary" href="login.php">Ir para login</a></p><?php else: ?>
<form method="post">
    <div class="form-group"><label>Nome</label><input class="form-control" name="name" required></div>
    <div class="form-group"><label>E-mail</label><input class="form-control" type="email" name="email" required></div>
    <div class="form-group"><label>Senha</label><input class="form-control" type="password" name="password" minlength="8" required></div>
    <div class="form-group"><label>Confirmar senha</label><input class="form-control" type="password" name="password_confirm" minlength="8" required></div>
    <button class="btn btn-success" type="submit">Criar administrador</button>
</form>
<?php endif; ?>
</body>
</html>
