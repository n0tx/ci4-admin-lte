<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FinancialPerformance extends Migration
{
    public function up()
    {
        $this->db->simpleQuery("
        CREATE TABLE `financial_performance` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `penjualan_neto` DECIMAL(5,1) NULL DEFAULT NULL,
            `laba_tahun_berjalan` DECIMAL(5,1) NULL DEFAULT NULL,
            `total_aset` DECIMAL(5,1) NULL DEFAULT NULL,
            `hasil_dividen` DECIMAL(5,5) NULL DEFAULT NULL,
            `tahun` VARCHAR(5) NULL DEFAULT NULL,
            `user_id` INT(11) NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        )");
    }

    public function down()
    {
        $this->forge->dropTable('financial_performance');
    }
}
