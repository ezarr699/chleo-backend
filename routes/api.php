<?php
/**
 * ============================================================
 * @layer       Route
 * @file        api.php
 * @path        routes/api.php
 * @description Semua modul sudah bermigrasi ke Clean Architecture generasi
 *              baru (root Modules/, lihat Modules/BaseServiceProvider.php) —
 *              tiap modul mendaftarkan Routes/api.php (central) dan
 *              Routes/tenant.php (tenant, prefix api/v1 + middleware
 *              tenancy) dari ServiceProvider-nya sendiri lewat
 *              Modules\BaseServiceProvider::bootModuleRoutes(), bukan
 *              lewat aggregator glob di file ini lagi. app/Modules/ tidak
 *              dipakai lagi — file ini disisakan kosong murni supaya
 *              routes/api.php tetap ada sebagai entry point yang
 *              didaftarkan bootstrap/app.php (withRouting(api: ...)).
 * @ref         https://laravel.com/docs/13.x/routing
 *              https://tenancyforlaravel.com/docs/v3/
 * ============================================================
 */
