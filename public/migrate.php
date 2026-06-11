<?php
/**
 * ⚠️  HAPUS FILE INI SETELAH SELESAI DIGUNAKAN
 * Akses: https://domain.com/migrate.php?token=TOKEN_KAMU
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('MIGRATE_TOKEN', 'ganti_dengan_token_rahasia_kamu');

if (empty($_GET['token']) || $_GET['token'] !== MIGRATE_TOKEN) {
    http_response_code(403);
    die('403 Forbidden.');
}

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;">';
echo "🗄️  Akar Sehat — Database Migration\n";
echo str_repeat('─', 40) . "\n\n";

$laravelRoot = dirname(__DIR__) . '/akar-sehat';

if (!file_exists($laravelRoot . '/vendor/autoload.php')) {
    echo "❌ Laravel root tidak ditemukan di: $laravelRoot\n";
    echo "   Sesuaikan path di baris 20 file ini.\n";
    echo '</pre>';
    exit;
}

try {
    require $laravelRoot . '/vendor/autoload.php';
    $app    = require_once $laravelRoot . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // Migrate
    $kernel->call('migrate', ['--force' => true]);
    $output = trim($kernel->output());
    echo "✅ migrate --force\n";
    foreach (explode("\n", $output) as $line) {
        if (trim($line)) echo "   → $line\n";
    }

    echo "\n" . str_repeat('─', 40) . "\n";
    echo "🎉 Selesai!\n\n";
    echo "⚠️  Hapus file ini sekarang via File Manager!\n";

} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "   " . $e->getFile() . " line " . $e->getLine() . "\n";
}

echo '</pre>';
