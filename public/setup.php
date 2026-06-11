<?php
/**
 * ⚠️  FILE INI HANYA UNTUK FIRST-TIME SETUP
 * HAPUS SEGERA setelah selesai digunakan!
 */

// Paksa tampilkan semua error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Keamanan minimal — ganti token ini sebelum upload
define('SETUP_TOKEN', 'ganti_dengan_token_rahasia_kamu');

if (empty($_GET['token']) || $_GET['token'] !== SETUP_TOKEN) {
    http_response_code(403);
    die('403 Forbidden. Akses ditolak.');
}

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;">';
echo "🚀 Akar Sehat — First Time Setup\n";
echo str_repeat('─', 40) . "\n\n";

// ── Diagnostik path ──────────────────────────────────
$here        = __DIR__;                                    // lokasi setup.php
$laravelRoot = dirname(__DIR__) . '/akar-sehat';           // folder Laravel
$autoload    = $laravelRoot . '/vendor/autoload.php';
$bootstrap   = $laravelRoot . '/bootstrap/app.php';

echo "📂 Lokasi setup.php  : $here\n";
echo "📂 Laravel root      : $laravelRoot\n";
echo "📄 autoload.php ada? : " . (file_exists($autoload)  ? '✅ Ya' : '❌ TIDAK ADA') . "\n";
echo "📄 bootstrap/app.php : " . (file_exists($bootstrap) ? '✅ Ya' : '❌ TIDAK ADA') . "\n";
echo "\n";

// Hentikan jika file tidak ditemukan
if (!file_exists($autoload)) {
    echo "❌ vendor/autoload.php tidak ditemukan.\n";
    echo "   Cek nama folder Laravel di server — mungkin bukan 'akar-sehat'.\n";
    echo "   Isi folder di: " . dirname(__DIR__) . "\n";

    // Tampilkan daftar folder di parent directory untuk membantu
    $parent = dirname(__DIR__);
    echo "\n📁 Isi folder $parent:\n";
    foreach (scandir($parent) as $item) {
        if ($item === '.' || $item === '..') continue;
        $type = is_dir("$parent/$item") ? '[DIR]' : '[FILE]';
        echo "   $type $item\n";
    }
    echo '</pre>';
    exit;
}

if (!file_exists($bootstrap)) {
    echo "❌ bootstrap/app.php tidak ditemukan.\n";
    echo '</pre>';
    exit;
}

// ── Jalankan setup ───────────────────────────────────
echo "⏳ Memulai setup...\n\n";

try {
    require $autoload;
    $app    = require_once $bootstrap;
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    $steps = [
        ['key:generate', [],                  'APP_KEY generated'],
        ['migrate',      ['--force' => true], 'Database migrated'],
        ['db:seed',      ['--force' => true], 'Data awal diisi (seed)'],
        ['storage:link', [],                  'Storage symlink dibuat'],
        ['config:cache', [],                  'Config cached'],
        ['route:cache',  [],                  'Route cached'],
        ['view:cache',   [],                  'View cached'],
    ];

    foreach ($steps as [$cmd, $args, $label]) {
        $exitCode = $kernel->call($cmd, $args);
        $output   = trim($kernel->output());
        $status   = $exitCode === 0 ? '✅' : '⚠️ ';
        echo "$status  $label\n";
        if ($output) {
            foreach (explode("\n", $output) as $line) {
                if (trim($line)) echo "   → $line\n";
            }
        }
        echo "\n";
    }

    echo str_repeat('─', 40) . "\n";
    echo "🎉 Setup selesai!\n\n";
    echo "⚠️  PENTING: Hapus file ini sekarang!\n";
    echo "   File Manager → public_html/setup.php → Delete\n";

} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "   File : " . $e->getFile() . "\n";
    echo "   Line : " . $e->getLine() . "\n\n";
    echo "   Stack trace:\n";
    foreach (explode("\n", $e->getTraceAsString()) as $line) {
        echo "   $line\n";
    }
}

echo '</pre>';
