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

@ini_set('max_execution_time', 0);
@set_time_limit(0);
@ini_set('output_buffering', 'off');
@ob_implicit_flush(true);
if (ob_get_level()) @ob_end_flush();

$repoRoot   = dirname(__DIR__);
$publicSrc  = $repoRoot . '/public';
$publicHtml = $repoRoot . '/public_html';

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;line-height:1.6;">';
echo "🚀 Akar Sehat — Deploy Utility\n";
echo str_repeat('─', 44) . "\n\n";
echo "📂 Repo root  : $repoRoot\n";
echo "📂 Public html: $publicHtml\n\n";

// 1. Sync public/ → public_html/ (skip folder storage)
echo "📋 Sinkronisasi public/ → public_html/...\n"; flush();
$result = syncDir($publicSrc, $publicHtml, ['storage']);
echo "   ✅ Selesai ({$result['copied']} file, {$result['errors']} error)\n"; flush();

// 2. Buat folder storage di public_html
echo "\n📁 Membuat folder storage...\n"; flush();
$dirs = [
    "$publicHtml/storage",
    "$publicHtml/storage/site",
    "$publicHtml/storage/homepage",
    "$publicHtml/storage/tentang",
    "$publicHtml/storage/produk",
    "$publicHtml/storage/artikel",
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "   ✅ Dibuat: " . str_replace("$publicHtml/", '', $dir) . "\n";
    } else {
        echo "   ✓  Ada: " . str_replace("$publicHtml/", '', $dir) . "\n";
    }
}

// 3. Artisan cache commands
echo "\n⚙️  Clear & rebuild cache...\n"; flush();
if (!file_exists($repoRoot . '/vendor/autoload.php')) {
    echo "❌ vendor/autoload.php tidak ditemukan\n";
    echo '</pre>';
    exit;
}

require $repoRoot . '/vendor/autoload.php';
$app    = require_once $repoRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

foreach (['config:clear','config:cache','route:clear','route:cache','view:clear','view:cache'] as $cmd) {
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

function syncDir(string $src, string $dst, array $skip = []): array {
    $copied = 0; $errors = 0;
    if (!is_dir($dst)) mkdir($dst, 0755, true);
    foreach (new DirectoryIterator($src) as $item) {
        if ($item->isDot()) continue;
        if (in_array($item->getFilename(), $skip)) continue;
        $s = $item->getPathname();
        $d = $dst . '/' . $item->getFilename();
        if ($item->isDir()) {
            $r = syncDir($s, $d, $skip);
            $copied += $r['copied']; $errors += $r['errors'];
        } else {
            if (@copy($s, $d)) $copied++;
            else $errors++;
        }
    }
    return ['copied' => $copied, 'errors' => $errors];
}
