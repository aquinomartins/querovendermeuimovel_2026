<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));
define('DATA_PATH', ROOT_PATH . '/data');
define('UPLOADS_IMAGES_PATH', ROOT_PATH . '/uploads/images');
define('UPLOADS_VIDEOS_PATH', ROOT_PATH . '/uploads/videos');
define('SITE_CONTENT_FILE', DATA_PATH . '/site-content.json');
define('LEADS_FILE', DATA_PATH . '/leads.json');
define('ADMIN_FILE', DATA_PATH . '/admin.json');

function ensure_directories(): void
{
    foreach ([DATA_PATH, UPLOADS_IMAGES_PATH, UPLOADS_VIDEOS_PATH] as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }
}

function default_site_content(): array
{
    return [
        'seo' => ['title' => 'Quero Vender Meu Imóvel', 'description' => 'Venda seu imóvel com segurança e pelo melhor valor de mercado.', 'author' => 'Quero Vender Meu Imóvel'],
        'header' => ['brand' => 'Quero vender meu imóvel', 'menu' => [['label' => 'Início', 'url' => '#home'], ['label' => 'Como funciona', 'url' => '#features'], ['label' => 'Contato', 'url' => '#footer']]],
        'hero' => ['title' => 'Venda seu imóvel', 'subtitle' => 'com segurança e pelo melhor valor de mercado', 'form_title' => 'Receba uma avaliação', 'form_highlight' => 'gratuita', 'button_text' => 'QUERO SABER O VALOR DO MEU IMÓVEL', 'slides' => ['assets/img/slide001.png', 'assets/img/slide002.png', 'assets/img/slide003.png']],
        'features' => ['title' => 'Está difícil vender seu imóvel?', 'media_type' => 'video', 'video_path' => 'uploads/videos/apresentacao.mp4', 'video_poster' => 'assets/img/features-slide-01.jpg', 'image_path' => 'assets/img/features-slide-01.jpg', 'cards' => [['icon' => 'assets/img/icon-01.png', 'title' => '1. Envie seus dados', 'description' => 'Envie as principais informações do seu imóvel.'], ['icon' => 'assets/img/icon-02.png', 'title' => '2. Avaliamos seu imóvel', 'description' => 'Fazemos uma avaliação ágil e estratégica.'], ['icon' => 'assets/img/icon-03.png', 'title' => '3. Definimos a estratégia', 'description' => 'Criamos um plano para vender melhor.']]],
        'contact' => ['whatsapp' => '', 'email' => '', 'phone' => '', 'address' => ''],
        'footer' => ['copyright' => '(C) QueroVenderMeuImóvel.com'],
    ];
}

function load_json(string $path, $default = [])
{
    if (!file_exists($path)) return $default;
    $decoded = json_decode((string) file_get_contents($path), true);
    return is_array($decoded) ? $decoded : $default;
}

function save_json(string $path, $data): bool
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) return false;
    return file_put_contents($path, $json, LOCK_EX) !== false;
}

function sanitize_text($value): string { return trim(strip_tags((string)$value)); }
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function is_admin_logged_in(): bool { return !empty($_SESSION['admin_email']); }
function require_admin(): void { if (!is_admin_logged_in()) { header('Location: login.php'); exit; } }

function get_site_content(): array
{
    $base = default_site_content();
    return array_replace_recursive($base, load_json(SITE_CONTENT_FILE, []));
}

function update_site_content($data): bool { return save_json(SITE_CONTENT_FILE, $data); }

function upload_file(array $file, string $type): array
{
    $cfg = [
        'image' => ['max' => 5 * 1024 * 1024, 'ext' => ['jpg','jpeg','png','webp'], 'mime' => ['image/jpeg','image/png','image/webp'], 'dir' => UPLOADS_IMAGES_PATH, 'web' => 'uploads/images'],
        'video' => ['max' => 80 * 1024 * 1024, 'ext' => ['mp4'], 'mime' => ['video/mp4'], 'dir' => UPLOADS_VIDEOS_PATH, 'web' => 'uploads/videos'],
    ];
    if (!isset($cfg[$type]) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return ['ok'=>false,'message'=>'Upload inválido.'];
    $c=$cfg[$type]; $ext=strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext,$c['ext'],true)) return ['ok'=>false,'message'=>'Extensão não permitida.'];
    if (($file['size'] ?? 0) > $c['max']) return ['ok'=>false,'message'=>'Arquivo excede limite.'];
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!in_array($mime,$c['mime'],true)) return ['ok'=>false,'message'=>'MIME inválido.'];
    $name = uniqid($type . '_', true) . '.' . $ext;
    $dest = $c['dir'] . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) return ['ok'=>false,'message'=>'Falha ao mover arquivo.'];
    return ['ok'=>true,'path'=>$c['web'].'/'.$name,'message'=>'Upload realizado com sucesso.'];
}

ensure_directories();
if (!file_exists(SITE_CONTENT_FILE)) save_json(SITE_CONTENT_FILE, default_site_content());
if (!file_exists(LEADS_FILE)) save_json(LEADS_FILE, []);
