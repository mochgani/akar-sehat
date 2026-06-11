<?php
/**
 * ⚠️  FILE INI HANYA UNTUK FIRST-TIME SETUP
 * HAPUS SEGERA setelah selesai digunakan!
 */

// Keamanan minimal — ganti token ini sebelum upload
define('SETUP_TOKEN', 'ganti_dengan_token_rahasia_kamu');

if (empty($_GET['token']) || $_GET['token'] !== SETUP_TOKEN) {
    http_response_code(403);
    die('403 Forbidden. Akses ditolak.');
}

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;">';
echo "🚀 Akar Sehat — First Time Setup\n";
echo str_repeat('─', 40) . "\n\n";

try {
    require __DIR__.'/../akar-sehat/vendor/autoload.php';
    $app = require_once __DIR__.'/../akar-sehat/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    $steps = [
        ['key:generate',    [],                    'APP_KEY generated'],
        ['migrate',         ['--force' => true],   'Database migrated'],
        ['db:seed',         ['--force' => true],   'Data awal diisi (seed)'],
        ['storage:link',    [],                    'Storage symlink dibuat'],
        ['config:cache',    [],                    'Config cached'],
        ['route:cache',     [],                    'Route cached'],
        ['view:cache',      [],                    'View cached'],
    ];

    foreach ($steps as [$cmd, $args, $label]) {
        $exitCode = $kernel->call($cmd, $args);
        $status   = $exitCode === 0 ? '✅' : '⚠️ ';
        echo "$status  $label\n";
        echo "   Output: " . trim($kernel->output()) . "\n\n";
    }

    echo str_repeat('─', 40) . "\n";
    echo "🎉 Setup selesai!\n\n";
    echo "⚠️  PENTING: Hapus file ini sekarang!\n";
    echo "   File Manager → public_html/setup.php → Delete\n";

} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . " line " . $e->getLine() . "\n";
}

echo '</pre>';
