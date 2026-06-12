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

$repoRoot  = dirname(__DIR__);
$publicHtml = dirname($repoRoot) . '/public_html';

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;line-height:1.6;">';
echo "🚀 Akar Sehat — Deploy Utility\n";
echo str_repeat('─', 44) . "\n\n";

// 1. Buat folder storage di public_html
$storageDirs = [
    "$publicHtml/storage",
    "$publicHtml/storage/site",
    "$publicHtml/storage/homepage",
    "$publicHtml/storage/tentang",
    "$publicHtml/storage/produk",
    "$publicHtml/storage/artikel",
];

echo "📁 Membuat folder storage...\n";
foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "   ✅ Dibuat: " . basename($dir) . "\n";
        } else {
            echo "   ❌ Gagal: $dir\n";
        }
    } else {
        echo "   ✓  Sudah ada: " . str_replace($publicHtml . '/', '', $dir) . "\n";
    }
}

// 2. Salin isi public/ ke public_html/ (sync file index.php, assets, dll)
echo "\n📋 Sinkronisasi public/ → public_html/...\n";
$publicSrc = $repoRoot . '/public';
$copied = 0;
$skipped = 0;
foreach (new DirectoryIterator($publicSrc) as $item) {
    if ($item->isDot() || $item->getFilename() === 'storage') continue;
    $src  = $item->getPathname();
    $dest = $publicHtml . '/' . $item->getFilename();
    if ($item->isDir()) {
        copyDir($src, $dest);
        $copied++;
    } else {
        if (copy($src, $dest)) $copied++;
        else $skipped++;
    }
}
echo "   ✅ $copied item disinkronisasi\n";

// 3. Jalankan artisan cache commands
echo "\n⚙️  Clear & rebuild cache...\n";

if (!file_exists($repoRoot . '/vendor/autoload.php')) {
    echo "   ❌ vendor/autoload.php tidak ditemukan\n";
    echo '</pre>';
    exit;
}

require $repoRoot . '/vendor/autoload.php';
$app    = require_once $repoRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$commands = [
    'config:clear'  => 'Config cache cleared',
    'config:cache'  => 'Config cached',
    'route:clear'   => 'Route cache cleared',
    'route:cache'   => 'Routes cached',
    'view:clear'    => 'View cache cleared',
    'view:cache'    => 'Views cached',
];

foreach ($commands as $cmd => $label) {
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

// Helper: copy folder rekursif
function copyDir($src, $dst) {
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    foreach (new DirectoryIterator($src) as $item) {
        if ($item->isDot()) continue;
        $s = $item->getPathname();
        $d = $dst . '/' . $item->getFilename();
        if ($item->isDir()) copyDir($s, $d);
        else copy($s, $d);
    }
}
