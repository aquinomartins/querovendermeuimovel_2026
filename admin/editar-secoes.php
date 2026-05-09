<?php require_once __DIR__ . '/auth.php'; $data=get_site_content(); $msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
$data['features']['title']=sanitize_text($_POST['title']??''); $data['features']['media_type']=($_POST['media_type']??'image')==='video'?'video':'image';
$data['features']['video_path']=sanitize_text($_POST['video_path']??'');$data['features']['video_poster']=sanitize_text($_POST['video_poster']??'');$data['features']['image_path']=sanitize_text($_POST['image_path']??'');
$icons=$_POST['card_icon']??[]; $titles=$_POST['card_title']??[]; $desc=$_POST['card_description']??[]; $cards=[];
foreach($titles as $i=>$t){$t=sanitize_text($t); if($t==='')continue; $cards[]=['icon'=>sanitize_text($icons[$i]??''),'title'=>$t,'description'=>sanitize_text($desc[$i]??'')];}
$data['features']['cards']=$cards; update_site_content($data); $msg='Seção salva.';
}
?><!doctype html><html><head><meta charset='utf-8'><link rel='stylesheet' href='../assets/bootstrap/css/bootstrap.min.css'><title>Editar Seções</title></head><body class='container'><h3>Editar Seção principal</h3><a href='dashboard.php'>← Dashboard</a><?php if($msg):?><div class='alert alert-success'><?=e($msg)?></div><?php endif;?>
<form method='post'><input class='form-control' name='title' value='<?=e($data['features']['title'])?>'><br>
<select class='form-control' name='media_type'><option value='image' <?=$data['features']['media_type']==='image'?'selected':''?>>Imagem</option><option value='video' <?=$data['features']['media_type']==='video'?'selected':''?>>Vídeo</option></select><br>
<input class='form-control' name='video_path' value='<?=e($data['features']['video_path'])?>' placeholder='Caminho do vídeo'><br>
<input class='form-control' name='video_poster' value='<?=e($data['features']['video_poster'])?>' placeholder='Poster'><br>
<input class='form-control' name='image_path' value='<?=e($data['features']['image_path'])?>' placeholder='Imagem alternativa'><br>
<h4>Cards (ordem = ordem dos campos)</h4><?php $cards=$data['features']['cards']??[]; for($i=0;$i<6;$i++):?><div class='panel panel-default'><div class='panel-body'><input class='form-control' name='card_icon[]' value='<?=e($cards[$i]['icon']??'')?>' placeholder='Ícone'><br><input class='form-control' name='card_title[]' value='<?=e($cards[$i]['title']??'')?>' placeholder='Título'><br><textarea class='form-control' name='card_description[]' placeholder='Descrição'><?=e($cards[$i]['description']??'')?></textarea></div></div><?php endfor;?>
<button class='btn btn-primary'>Salvar</button></form></body></html>
