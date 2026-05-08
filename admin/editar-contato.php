<?php require_once __DIR__ . '/auth.php'; requireLogin(); require_once __DIR__ . '/_layout.php'; adminHeader('Editar Contato/SEO'); ?>
<h2>Contato, Rodapé e SEO</h2>
<form method="post" action="salvar.php"><input type="hidden" name="action" value="contato">
<div class="form-group"><label>Copyright</label><input class="form-control" name="footer_copyright" value="<?= e(setting('footer_copyright','(C) QueroVenderMeuImóvel.com')) ?>"></div>
<div class="form-group"><label>WhatsApp</label><input class="form-control" name="contact_whatsapp" value="<?= e(setting('contact_whatsapp','')) ?>"></div>
<div class="form-group"><label>E-mail</label><input class="form-control" name="contact_email" value="<?= e(setting('contact_email','')) ?>"></div>
<div class="form-group"><label>Links sociais (JSON)</label><textarea class="form-control" name="social_links" rows="3"><?= e(setting('social_links','[]')) ?></textarea></div>
<hr><h3>SEO</h3>
<div class="form-group"><label>Meta title</label><input class="form-control" name="seo_title" value="<?= e(setting('seo_title','Quero Vender Meu Imóvel')) ?>"></div>
<div class="form-group"><label>Meta description</label><textarea class="form-control" name="seo_description" rows="2"><?= e(setting('seo_description','Venda seu imóvel com segurança.')) ?></textarea></div>
<div class="form-group"><label>Meta author</label><input class="form-control" name="seo_author" value="<?= e(setting('seo_author','Quero Vender Meu Imóvel')) ?>"></div>
<button class="btn btn-primary">Salvar</button></form>
<?php adminFooter();
