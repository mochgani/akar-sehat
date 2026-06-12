<?php
// ⚠️ HAPUS FILE INI SETELAH SELESAI
if (($_GET['token'] ?? '') !== '4k4r') { die('403'); }

$repoRoot = dirname(__DIR__) . '/akar-sehat';
require $repoRoot . '/vendor/autoload.php';
$app    = require_once $repoRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '<pre style="font-family:monospace;font-size:14px;padding:20px;">';
echo "🔑 Akar Sehat — Key Generator\n";
echo str_repeat('─', 40) . "\n\n";

$kernel->call('key:generate', ['--force' => true]);
echo trim($kernel->output()) . "\n\n";
echo "✅ APP_KEY sudah ditulis otomatis ke .env\n";
echo "⚠️  Hapus file keygen.php ini sekarang!\n";
echo '</pre>';
