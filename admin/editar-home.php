<?php require_once __DIR__ . '/auth.php'; requireLogin(); require_once __DIR__ . '/_layout.php';
adminHeader('Editar Home'); ?>
<h2>Editar Home e Formulário</h2>
<form method="post" action="salvar.php">
<input type="hidden" name="action" value="home">
<div class="form-group"><label>Marca</label><input class="form-control" name="brand_name" value="<?= e(setting('brand_name','Quero Vender Meu Imóvel')) ?>"></div>
<div class="form-group"><label>Menu (JSON)</label><textarea class="form-control" name="menu_items" rows="3"><?= e(setting('menu_items','[{"text":"Início","link":"#home"}]')) ?></textarea></div>
<div class="form-group"><label>Título Hero</label><input class="form-control" name="hero_title" value="<?= e(setting('hero_title','Venda seu imóvel')) ?>"></div>
<div class="form-group"><label>Subtítulo Hero</label><input class="form-control" name="hero_subtitle" value="<?= e(setting('hero_subtitle','com segurança e pelo melhor valor de mercado')) ?>"></div>
<div class="form-group"><label>Texto botão principal</label><input class="form-control" name="hero_button_text" value="<?= e(setting('hero_button_text','QUERO SABER O VALOR DO MEU IMÓVEL')) ?>"></div>
<div class="form-group"><label>Título formulário</label><input class="form-control" name="form_title" value="<?= e(setting('form_title','Receba uma avaliação')) ?>"></div>
<div class="form-group"><label>Destaque formulário</label><input class="form-control" name="form_highlight" value="<?= e(setting('form_highlight','gratuita')) ?>"></div>
<div class="form-group"><label>Mensagem de sucesso</label><input class="form-control" name="form_success_message" value="<?= e(setting('form_success_message','Obrigado! Recebemos seus dados.')) ?>"></div>
<button class="btn btn-primary">Salvar</button>
</form>
<?php adminFooter();
