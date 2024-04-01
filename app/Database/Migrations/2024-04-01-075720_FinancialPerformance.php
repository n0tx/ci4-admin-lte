<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FinancialPerformance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'penjualan_neto' => [
                'type' => 'DECIMAL',
                'constraint' => '5,1',
            ],
            'laba_tahun_berjalan' => [
                'type' => 'DECIMAL',
                'constraint' => '5,1',
            ],
            'total_aset' => [
                'type' => 'DECIMAL',
                'constraint' => '5,1',
            ],
            'hasil_dividen' => [
                'type' => 'DECIMAL',
                'constraint' => '5,5',
            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
    ]);
    }

    public function down()
    {
        $this->forge->dropTable('financial_performance');
    }
}
