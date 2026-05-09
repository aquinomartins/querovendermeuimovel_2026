<?php require_once __DIR__ . '/auth.php';
$leads=load_json(LEADS_FILE,[]); $siteExists=file_exists(SITE_CONTENT_FILE); $adminExists=file_exists(ADMIN_FILE);
$updated=$siteExists?date('d/m/Y H:i:s', filemtime(SITE_CONTENT_FILE)):'-';
?>
<!doctype html><html lang='pt-br'><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><link rel='stylesheet' href='../assets/bootstrap/css/bootstrap.min.css'><title>Dashboard</title></head>
<body class='container' style='padding:20px'>
<div class='pull-right'><a class='btn btn-default' href='logout.php'>Sair</a></div><h2>Olá, <?=e($_SESSION['admin_name']??'Administrador')?></h2>
<div class='list-group'>
<a class='list-group-item' href='editar-home.php'>Editar Home/Hero e Menu</a>
<a class='list-group-item' href='editar-secoes.php'>Editar Seção vídeo/imagem e cards</a>
<a class='list-group-item' href='editar-contato.php'>Editar Contato e Rodapé</a>
<a class='list-group-item' href='editar-midias.php'>Upload de Mídias</a>
<a class='list-group-item' href='leads.php'>Leads recebidos</a>
</div>
<div class='panel panel-default'><div class='panel-heading'>Resumo</div><div class='panel-body'>
<p><strong>Leads:</strong> <?=count($leads)?></p><p><strong>Última atualização site-content:</strong> <?=$updated?></p>
<p><strong>Status site-content.json:</strong> <?=$siteExists?'OK':'Ausente'?></p><p><strong>Status leads.json:</strong> <?=file_exists(LEADS_FILE)?'OK':'Ausente'?></p><p><strong>Status admin.json:</strong> <?=$adminExists?'OK':'Ausente'?></p>
</div></div></body></html>
