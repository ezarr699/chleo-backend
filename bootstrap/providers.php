<?php

use App\Providers\AppServiceProvider;

// Semua modul sudah bermigrasi ke Clean Architecture generasi baru (root
// Modules/, lihat Modules/BaseServiceProvider.php) — app/Modules/ tidak
// dipakai lagi.
$moduleProviders = [];

foreach (glob(dirname(__DIR__).'/Modules/*/Providers/*ServiceProvider.php') as $file) {
    $module = basename(dirname(dirname($file)));
    $moduleProviders[] = "Modules\\{$module}\\Providers\\{$module}ServiceProvider";
}

return [
    AppServiceProvider::class,
    ...$moduleProviders,
];
