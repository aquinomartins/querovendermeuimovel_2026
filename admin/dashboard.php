<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/_layout.php';
$totalLeads = db()->query('SELECT COUNT(*) FROM leads')->fetchColumn();
$lastLeads = db()->query('SELECT * FROM leads ORDER BY created_at DESC LIMIT 5')->fetchAll();
adminHeader('Dashboard');
?>
<h2>Dashboard</h2>
<div class="row"><div class="col-md-4"><div class="panel panel-primary"><div class="panel-heading">Total de leads</div><div class="panel-body"><h3><?= (int)$totalLeads ?></h3></div></div></div></div>
<p><a class="btn btn-default" href="editar-home.php">Editar Home</a> <a class="btn btn-default" href="editar-secoes.php">Editar Seções</a> <a class="btn btn-default" href="editar-contato.php">Editar Contato/SEO</a> <a class="btn btn-default" href="editar-midias.php">Editar Mídias</a></p>
<h3>Últimos Leads</h3>
<table class="table table-bordered"><tr><th>Nome</th><th>WhatsApp</th><th>Tipo</th><th>Data</th></tr><?php foreach($lastLeads as $lead): ?><tr><td><?= e($lead['name']) ?></td><td><?= e($lead['whatsapp']) ?></td><td><?= e($lead['property_type']) ?></td><td><?= e($lead['created_at']) ?></td></tr><?php endforeach; ?></table>
<?php adminFooter();
