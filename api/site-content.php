<?php
require_once __DIR__ . '/../admin/config.php';
header('Content-Type: application/json; charset=utf-8');
$settings = db()->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll();
$sections = db()->query('SELECT * FROM site_sections WHERE is_active = 1 ORDER BY sort_order ASC, id ASC')->fetchAll();
echo json_encode(['settings'=>$settings,'sections'=>$sections], JSON_UNESCAPED_UNICODE);
