<?php
/**
 * ⚠️  JANGAN HAPUS — utility deploy untuk shared hosting tanpa terminal
 * Akses: https://domain.com/deploy.php?token=TOKEN_KAMU
 * Jalankan setiap kali setelah pull dari cPanel Git Version Control
 */

define('DEPLOY_TOKEN', 'ganti_dengan_token_rahasia_kamu');

if (empty($_GET['token']) || $_GET['token'] !== DEPLOY_TOKEN) {
    http_response_code(403);
    die('403 Forbidden.');
}

$repoRoot = dirname(__DIR__);

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;line-height:1.6;">';
echo "🚀 Akar Sehat — Deploy Utility\n";
echo str_repeat('─', 44) . "\n\n";

if (!file_exists($repoRoot . '/vendor/autoload.php')) {
    echo "❌ vendor/autoload.php tidak ditemukan\n";
    echo '</pre>';
    exit;
}

require $repoRoot . '/vendor/autoload.php';
$app    = require_once $repoRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// 1. Buat folder storage
echo "📁 Membuat folder storage...\n";
$dirs = [
    $repoRoot . '/storage/app/public',
    $repoRoot . '/storage/app/public/site',
    $repoRoot . '/storage/app/public/homepage',
    $repoRoot . '/storage/app/public/tentang',
    $repoRoot . '/storage/app/public/produk',
    $repoRoot . '/storage/app/public/artikel',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "   ✅ Dibuat: " . str_replace($repoRoot . '/storage/app/public', 'storage/app/public', $dir) . "\n";
    } else {
        echo "   ✓  Sudah ada: " . str_replace($repoRoot . '/storage/app/public', 'storage/app/public', $dir) . "\n";
    }
}

// 2. Storage link
echo "\n🔗 Storage link...\n";
try {
    $kernel->call('storage:link');
    echo "   ✅ storage:link\n";
} catch (\Throwable $e) {
    echo "   ⚠️  " . $e->getMessage() . "\n";
}

// 3. Clear & rebuild cache
echo "\n⚙️  Clear & rebuild cache...\n";
$commands = [
    'config:clear', 'config:cache',
    'route:clear',  'route:cache',
    'view:clear',   'view:cache',
];
foreach ($commands as $cmd) {
    try {
        $kernel->call($cmd);
        echo "   ✅ $cmd\n";
    } catch (\Throwable $e) {
        echo "   ⚠️  $cmd — " . $e->getMessage() . "\n";
    }
}

echo "\n" . str_repeat('─', 44) . "\n";
echo "🎉 Deploy selesai!\n";
echo '</pre>';
