<?php
/**
 * ============================================================
 * @module      Core
 * @layer       Event (Global)
 * @file        ProfilNakesCreatedOrUpdated.php
 * @path        app/Events/ProfilNakesCreatedOrUpdated.php
 * @description Global Event untuk ProfilNakes (Modul ProfilNakes). Dipisah
 *              dari MasterDataCreatedOrUpdated (generik) karena ProfilNakes
 *              tidak punya kolom "name" sendiri — nama tampilannya
 *              diturunkan dari User (lihat
 *              Modules\ProfilNakes\Services\ProfilNakesService), jadi
 *              $nama di sini adalah HASIL RESOLUSI, bukan kolom mentah.
 *              Dipicu dari Modules\ProfilNakes\Services\ProfilNakesService.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

final class ProfilNakesCreatedOrUpdated
{
    use Dispatchable;

    public function __construct(
        public readonly int $id,
        public readonly string $nama,
    ) {}
}
