<?php
function adminHeader(string $title): void { ?>
<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= e($title) ?></title><link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css"></head><body><nav class="navbar navbar-inverse"><div class="container"><a class="navbar-brand" href="dashboard.php">Admin</a><ul class="nav navbar-nav"><li><a href="editar-home.php">Home</a></li><li><a href="editar-secoes.php">Seções</a></li><li><a href="editar-contato.php">Contato/SEO</a></li><li><a href="editar-midias.php">Mídias</a></li><li><a href="leads.php">Leads</a></li></ul><ul class="nav navbar-nav navbar-right"><li><a href="logout.php">Sair</a></li></ul></div></nav><div class="container">
<?php }
function adminFooter(): void { echo '</div></body></html>'; }
