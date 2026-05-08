<?php require_once __DIR__ . '/auth.php'; requireLogin(); require_once __DIR__ . '/_layout.php'; adminHeader('Editar Mídias'); ?>
<h2>Upload de Mídias</h2>
<form method="post" action="salvar.php" enctype="multipart/form-data"><input type="hidden" name="action" value="midias">
<div class="form-group"><label>Slides (até 3 imagens)</label><input type="file" class="form-control" name="slides[]" accept="image/jpeg,image/png,image/webp" multiple></div>
<div class="form-group"><label>Poster do vídeo</label><input type="file" class="form-control" name="feature_poster" accept="image/jpeg,image/png,image/webp"></div>
<div class="form-group"><label>Vídeo MP4</label><input type="file" class="form-control" name="feature_video" accept="video/mp4"></div>
<button class="btn btn-primary">Substituir mídia</button></form>
<?php adminFooter();
