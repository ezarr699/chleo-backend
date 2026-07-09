<?php
/**
 * ============================================================
 * @module      Core
 * @layer       Event (Global)
 * @file        MasterDataCreatedOrUpdated.php
 * @path        app/Events/MasterDataCreatedOrUpdated.php
 * @description Global Event generik untuk SEMUA modul data master
 *              (Agama, GolonganDarah, JenisKelamin, Asuransi, dst — lihat
 *              app/Support/MasterData/AbstractMasterDataService.php, yang
 *              men-dispatch event ini otomatis di create()/update()).
 *              Satu event class dipakai bersama, dibedakan lewat properti
 *              $modul (nama modul asal, mis. 'JenisKelamin'), karena
 *              bentuk datanya memang identik di semua modul data master
 *              (id + name) — bikin satu class Event terpisah per modul
 *              (15+ class nyaris kembar) hanya akan jadi boilerplate,
 *              bukan isolasi tambahan. Listener di modul subscriber (mis.
 *              Modules/Pasien/Listeners/SyncMasterDataToPasien.php)
 *              memfilter sendiri $modul mana yang relevan untuknya.
 *              Hanya membawa data primitif — dilarang membawa objek Model
 *              Eloquent utuh.
 * @author      [Nama Developer]
 * @since       v1.0.0
 * ============================================================
 */

declare(strict_types=1);

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

final class MasterDataCreatedOrUpdated
{
    use Dispatchable;

    public function __construct(
        public readonly string $modul,
        public readonly int $id,
        public readonly string $nama,
    ) {}

    public static function fromModel(Model $model): self
    {
        return new self(
            modul: class_basename($model),
            id: $model->getKey(),
            nama: $model->name,
        );
    }
}
