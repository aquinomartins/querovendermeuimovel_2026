<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(0);
ini_set('display_errors', '0');

const DB_HOST = 'localhost';
const DB_NAME = 'querovendermeuimovel';
const DB_USER = 'root';
const DB_PASS = '';

function db(): ?PDO
{
    static $pdo = null;
    static $failed = false;

    if ($failed) {
        return null;
    }

    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (Throwable $e) {
            $failed = true;
            return null;
        }
    }

    return $pdo;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function setting(string $key, string $default = ''): string
{
    $pdo = db();
    if (!$pdo) {
        return $default;
    }

    $stmt = $pdo->prepare('SELECT setting_value FROM site_settings WHERE setting_key = :k LIMIT 1');
    $stmt->execute(['k' => $key]);
    $row = $stmt->fetch();
    return $row['setting_value'] ?? $default;
}

function upsertSetting(string $key, string $value): void
{
    $pdo = db();
    if (!$pdo) {
        return;
    }

    $sql = 'INSERT INTO site_settings (setting_key, setting_value) VALUES (:k,:v)
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = CURRENT_TIMESTAMP';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['k' => $key, 'v' => $value]);
}

function section(string $key): array
{
    $pdo = db();
    if (!$pdo) {
        return [];
    }

    $stmt = $pdo->prepare('SELECT * FROM site_sections WHERE section_key = :k LIMIT 1');
    $stmt->execute(['k' => $key]);
    return $stmt->fetch() ?: [];
}

function upsertSection(string $key, array $data): void
{
    $pdo = db();
    if (!$pdo) {
        return;
    }

    $sql = 'INSERT INTO site_sections (section_key,title,subtitle,body,button_text,button_url,image_path,video_path,sort_order,is_active)
            VALUES (:section_key,:title,:subtitle,:body,:button_text,:button_url,:image_path,:video_path,:sort_order,:is_active)
            ON DUPLICATE KEY UPDATE title=VALUES(title), subtitle=VALUES(subtitle), body=VALUES(body),
            button_text=VALUES(button_text), button_url=VALUES(button_url), image_path=VALUES(image_path),
            video_path=VALUES(video_path), sort_order=VALUES(sort_order), is_active=VALUES(is_active), updated_at=CURRENT_TIMESTAMP';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'section_key' => $key,
        'title' => $data['title'] ?? '',
        'subtitle' => $data['subtitle'] ?? '',
        'body' => $data['body'] ?? '',
        'button_text' => $data['button_text'] ?? '',
        'button_url' => $data['button_url'] ?? '',
        'image_path' => $data['image_path'] ?? '',
        'video_path' => $data['video_path'] ?? '',
        'sort_order' => (int)($data['sort_order'] ?? 0),
        'is_active' => (int)($data['is_active'] ?? 1),
    ]);
}
