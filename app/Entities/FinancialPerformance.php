<?php

namespace App\Entities;

use CodeIgniter\Entity;
use CodeIgniter\I18n\Time;

/**
 * @property int $id
 * @property decimal $penjualan_neto
 * @property decimal $laba_tahun_berjalan
 * @property decimal $total_aset
 * @property decimal $hasil_dividen
 * @property string $tahun
 * @property int $user_id
 */

class FinancialPerformance extends Entity
{
    protected $datamap = [];
    protected $casts   = ['id' => 'integer'];
}
