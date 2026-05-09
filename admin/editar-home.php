<?php require_once __DIR__ . '/auth.php'; $data=get_site_content(); $msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
$data['seo']['title']=sanitize_text($_POST['seo_title']??'');$data['seo']['description']=sanitize_text($_POST['seo_description']??'');
$data['header']['brand']=sanitize_text($_POST['brand']??'');
$data['hero']['title']=sanitize_text($_POST['hero_title']??'');$data['hero']['subtitle']=sanitize_text($_POST['hero_subtitle']??'');
$data['hero']['form_title']=sanitize_text($_POST['form_title']??'');$data['hero']['form_highlight']=sanitize_text($_POST['form_highlight']??'');$data['hero']['button_text']=sanitize_text($_POST['button_text']??'');
$data['hero']['slides']=array_values(array_filter(array_map('sanitize_text', $_POST['slides']??[])));
$menuLabels=$_POST['menu_label']??[]; $menuUrls=$_POST['menu_url']??[]; $menu=[]; foreach($menuLabels as $i=>$l){$l=sanitize_text($l);$u=sanitize_text($menuUrls[$i]??''); if($l!==''&&$u!=='')$menu[]=['label'=>$l,'url'=>$u];}
$data['header']['menu']=$menu; update_site_content($data); $msg='Salvo com sucesso.';
}
?><!doctype html><html><head><meta charset='utf-8'><link rel='stylesheet' href='../assets/bootstrap/css/bootstrap.min.css'><title>Editar Home</title></head><body class='container'><h3>Editar Home / Hero</h3><a href='dashboard.php'>← Dashboard</a><?php if($msg):?><div class='alert alert-success'><?=e($msg)?></div><?php endif;?><form method='post'>
<input class='form-control' name='seo_title' value='<?=e($data['seo']['title'])?>' placeholder='Title'><br>
<textarea class='form-control' name='seo_description' placeholder='Meta description'><?=e($data['seo']['description'])?></textarea><br>
<input class='form-control' name='brand' value='<?=e($data['header']['brand'])?>' placeholder='Marca'><br>
<input class='form-control' name='hero_title' value='<?=e($data['hero']['title'])?>' placeholder='Título hero'><br>
<input class='form-control' name='hero_subtitle' value='<?=e($data['hero']['subtitle'])?>' placeholder='Subtítulo hero'><br>
<input class='form-control' name='form_title' value='<?=e($data['hero']['form_title'])?>' placeholder='Título form'><br>
<input class='form-control' name='form_highlight' value='<?=e($data['hero']['form_highlight'])?>' placeholder='Destaque form'><br>
<input class='form-control' name='button_text' value='<?=e($data['hero']['button_text'])?>' placeholder='Texto botão'><br>
<h4>Menu</h4><?php foreach(($data['header']['menu']??[]) as $m):?><div class='row'><div class='col-sm-6'><input class='form-control' name='menu_label[]' value='<?=e($m['label'])?>'></div><div class='col-sm-6'><input class='form-control' name='menu_url[]' value='<?=e($m['url'])?>'></div></div><br><?php endforeach;?>
<h4>Slides</h4><?php for($i=0;$i<5;$i++):?><input class='form-control' name='slides[]' value='<?=e($data['hero']['slides'][$i]??'')?>' placeholder='Caminho do slide'><br><?php endfor;?>
<button class='btn btn-primary'>Salvar</button> <a class='btn btn-default' href='dashboard.php'>Cancelar</a></form></body></html>
