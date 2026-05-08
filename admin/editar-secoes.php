<?php require_once __DIR__ . '/auth.php'; requireLogin(); require_once __DIR__ . '/_layout.php'; $s=section('features'); adminHeader('Editar Seções'); ?>
<h2>Seção "Está difícil vender seu imóvel?"</h2>
<form method="post" action="salvar.php"><input type="hidden" name="action" value="features">
<div class="form-group"><label>Título seção</label><input class="form-control" name="title" value="<?= e($s['title'] ?? 'Está difícil vender seu imóvel?') ?>"></div>
<div class="form-group"><label>Subtítulo</label><input class="form-control" name="subtitle" value="<?= e($s['subtitle'] ?? 'Veja como é simples vender com estratégia profissional') ?>"></div>
<div class="form-group"><label>Texto de apoio</label><textarea class="form-control" rows="4" name="body"><?= e($s['body'] ?? '') ?></textarea></div>
<div class="form-group"><label>Cards/etapas (JSON)</label><textarea class="form-control" rows="7" name="feature_cards"><?= e(setting('feature_cards','[]')) ?></textarea></div>
<button class="btn btn-primary">Salvar</button></form>
<?php adminFooter();
