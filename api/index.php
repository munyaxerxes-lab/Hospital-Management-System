<?php

putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

if (!getenv('APP_NAME') && empty($_ENV['APP_NAME'])) {
    putenv('APP_NAME=MediLink');
    $_ENV['APP_NAME'] = 'MediLink';
    $_SERVER['APP_NAME'] = 'MediLink';
}

if (!getenv('APP_KEY') && empty($_ENV['APP_KEY'])) {
    putenv('APP_KEY=base64:aGlr9JhiyA6ii/iDdKOeuTQtG6h8eGQG503q4gTBA0U=');
    $_ENV['APP_KEY'] = 'base64:aGlr9JhiyA6ii/iDdKOeuTQtG6h8eGQG503q4gTBA0U=';
    $_SERVER['APP_KEY'] = 'base64:aGlr9JhiyA6ii/iDdKOeuTQtG6h8eGQG503q4gTBA0U=';
}

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

putenv('APP_STORAGE=/tmp/storage');
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_SERVER['APP_STORAGE'] = '/tmp/storage';

putenv('CACHE_STORE=array');
$_ENV['CACHE_STORE'] = 'array';
$_SERVER['CACHE_STORE'] = 'array';

putenv('SESSION_DRIVER=cookie');
$_ENV['SESSION_DRIVER'] = 'cookie';
$_SERVER['SESSION_DRIVER'] = 'cookie';

putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';

putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';

putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
$_ENV['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
$_SERVER['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';

putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes-v7.php');
$_ENV['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes-v7.php';
$_SERVER['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes-v7.php';

putenv('APP_EVENTS_CACHE=/tmp/bootstrap/cache/events.php');
$_ENV['APP_EVENTS_CACHE'] = '/tmp/bootstrap/cache/events.php';
$_SERVER['APP_EVENTS_CACHE'] = '/tmp/bootstrap/cache/events.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Ensure temporary serverless storage directories exist
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
    '/tmp/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Database configuration for serverless runtime
$dbConn = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? null);
$dbHost = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? null);

if (!$dbConn || $dbConn === 'sqlite' || ($dbConn === 'mysql' && ($dbHost === '127.0.0.1' || empty($dbHost)))) {
    putenv('DB_CONNECTION=sqlite');
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_CONNECTION'] = 'sqlite';

    putenv('DB_DATABASE=/tmp/database.sqlite');
    $_ENV['DB_DATABASE'] = '/tmp/database.sqlite';
    $_SERVER['DB_DATABASE'] = '/tmp/database.sqlite';
}

try {
    if (!defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    require __DIR__ . '/../vendor/autoload.php';

    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->useStoragePath('/tmp/storage');

    $app->handleRequest(\Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<!DOCTYPE html><html><head><title>Serverless Error Trace</title></head><body style="background:#0f172a;color:#f8fafc;padding:32px;font-family:monospace;line-height:1.6;">';
    echo '<h2 style="color:#ef4444;margin-top:0;">⚠️ Vercel Laravel Execution Error</h2>';
    echo '<div style="background:#1e293b;border:1px solid #334155;padding:20px;border-radius:10px;margin-bottom:20px;">';
    echo '<strong style="color:#fbbf24;">Error:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>';
    echo '<strong style="color:#94a3b8;">Location:</strong> ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine();
    echo '</div>';
    echo '<strong style="color:#94a3b8;">Stack Trace:</strong>';
    echo '<pre style="background:#1e293b;border:1px solid #334155;padding:16px;border-radius:10px;overflow-x:auto;color:#cbd5e1;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</body></html>';
}
