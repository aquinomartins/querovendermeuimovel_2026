<?php
require_once __DIR__ . '/auth.php';
requireLogin();

function cleanText(string $k): string { return trim(strip_tags($_POST[$k] ?? '')); }
function uploadFile(array $file, string $type): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
    $allowed = $type === 'image'
        ? ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp']
        : ['mp4'=>'video/mp4'];
    $max = $type === 'image' ? 5 * 1024 * 1024 : 30 * 1024 * 1024;
    if (($file['size'] ?? 0) > $max) return null;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($file['tmp_name']);
    if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) return null;
    $name = bin2hex(random_bytes(16)) . '.' . $ext;
    $dir = $type === 'image' ? __DIR__ . '/../uploads/images/' : __DIR__ . '/../uploads/videos/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (!move_uploaded_file($file['tmp_name'], $dir . $name)) return null;
    return ($type === 'image' ? 'uploads/images/' : 'uploads/videos/') . $name;
}

$action = $_POST['action'] ?? '';
if ($action === 'home') {
    foreach (['brand_name','menu_items','hero_title','hero_subtitle','hero_button_text','form_title','form_highlight','form_success_message'] as $k) upsertSetting($k, cleanText($k));
} elseif ($action === 'features') {
    upsertSection('features', ['title'=>cleanText('title'),'subtitle'=>cleanText('subtitle'),'body'=>cleanText('body')]);
    upsertSetting('feature_cards', trim($_POST['feature_cards'] ?? '[]'));
} elseif ($action === 'contato') {
    foreach (['footer_copyright','contact_whatsapp','contact_email','social_links','seo_title','seo_description','seo_author'] as $k) upsertSetting($k, cleanText($k));
} elseif ($action === 'midias') {
    if (!empty($_FILES['slides']['name'][0])) {
        $slides = [];
        foreach ($_FILES['slides']['name'] as $i => $n) {
            $file = ['name'=>$_FILES['slides']['name'][$i],'type'=>$_FILES['slides']['type'][$i],'tmp_name'=>$_FILES['slides']['tmp_name'][$i],'error'=>$_FILES['slides']['error'][$i],'size'=>$_FILES['slides']['size'][$i]];
            $path = uploadFile($file, 'image');
            if ($path) $slides[] = $path;
        }
        if ($slides) upsertSetting('hero_slides', json_encode($slides));
    }
    $poster = uploadFile($_FILES['feature_poster'] ?? [], 'image');
    if ($poster) upsertSetting('feature_poster', $poster);
    $video = uploadFile($_FILES['feature_video'] ?? [], 'video');
    if ($video) upsertSetting('feature_video', $video);
}
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'));
