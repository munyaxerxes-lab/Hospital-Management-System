<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Ensure temporary serverless storage directories
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

try {
    require __DIR__ . '/../public/index.php';
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
