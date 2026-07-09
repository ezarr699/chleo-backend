<?php
/**
 * ============================================================
 * @module      Shared
 * @layer       Contract (Interface)
 * @file        IntegrationLoggerInterface.php
 * @path        Modules/Shared/Contracts/IntegrationLoggerInterface.php
 * @description Kontrak tunggal yang dipakai SEMUA modul bridging
 *              (JKN-01-2 V-Claim, REG-01-2-1 SISRUTE, API-02 SatuSehat/
 *              FHIR, PNJ-01-1 Analyzer) untuk mencatat setiap panggilan
 *              ke sistem eksternal, tanpa perlu coupled langsung ke
 *              modul IntegrationLog (implementasinya). Diikat lewat
 *              IntegrationLog\Providers\IntegrationLogServiceProvider.
 *              Return type void (bukan LogIntegrasi) SENGAJA — semua
 *              pemanggil yang ada (mis. Jkn\Services\VClaimService)
 *              tidak pernah memakai nilai baliknya, dan mengembalikan
 *              Model milik IntegrationLog dari kontrak lintas modul akan
 *              memaksa pemanggil mengenal skema Eloquent modul lain,
 *              persis yang dilarang Hukum Isolasi Total Eloquent.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace Modules\Shared\Contracts;

interface IntegrationLoggerInterface
{
    /**
     * @param  string  $integrasi  Nama integrasi, mis. 'bpjs_vclaim', 'bpjs_antrean', 'sisrute', 'satusehat_fhir'.
     * @param  string  $level  'error' | 'warning' | 'info'.
     * @param  array<string, mixed>  $context  Kunci yang didukung: referensi_tipe,
     *         referensi_id, endpoint, metode, request_payload, response_payload,
     *         status_code. request_payload/response_payload WAJIB sudah
     *         disanitasi pemanggil — jangan pernah kirim API key/secret/token
     *         ke method ini.
     */
    public function log(string $integrasi, string $level, ?string $pesanError = null, array $context = []): void;
}
