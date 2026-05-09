<?php
require_once __DIR__ . '/config.php';
if (is_admin_logged_in()) { header('Location: dashboard.php'); exit; }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $email=sanitize_text($_POST['email']??''); $password=$_POST['password']??'';
  $admin=load_json(ADMIN_FILE,[]);
  if ($email && isset($admin['email'],$admin['password_hash']) && strcasecmp($email,$admin['email'])===0 && password_verify($password,$admin['password_hash'])) {
    $_SESSION['admin_email']=$admin['email']; $_SESSION['admin_name']=$admin['name']??'Administrador';
    header('Location: dashboard.php'); exit;
  }
  $error='Credenciais inválidas.';
}
?>
<!doctype html><html lang='pt-br'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><link rel='stylesheet' href='../assets/bootstrap/css/bootstrap.min.css'><title>Login Admin</title></head><body class='container' style='padding-top:60px;max-width:500px'>
<h2>Painel Admin</h2>
<p class='text-muted'>Para gerar o primeiro password_hash: execute no terminal PHP: <code>php -r "echo password_hash('SUA_SENHA', PASSWORD_DEFAULT);"</code></p>
<?php if($error):?><div class='alert alert-danger'><?=e($error)?></div><?php endif;?>
<form method='post'><div class='form-group'><label>E-mail</label><input class='form-control' name='email' required></div><div class='form-group'><label>Senha</label><input class='form-control' type='password' name='password' required></div><button class='btn btn-primary'>Entrar</button></form>
</body></html>
