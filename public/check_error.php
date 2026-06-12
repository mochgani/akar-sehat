<?php
// ⚠️ HAPUS FILE INI SETELAH SELESAI DEBUG
if (($_GET['token'] ?? '') !== '4k4r') { die('403'); }
$logFile = '/home/ldpcxuzg/akar-sehat/storage/logs/laravel.log';
if (!file_exists($logFile)) { echo "Log tidak ada: $logFile"; exit; }
$lines = array_slice(file($logFile), -60);
echo '<pre style="font-size:12px;padding:20px;">' . htmlspecialchars(implode('', $lines)) . '</pre>';
