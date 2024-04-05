<?php

namespace App\Models;

use App\Entities\FinancialPerformance;
use CodeIgniter\Model;
use Config\Services;

class FinancialPerformanceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'financial_performance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\FinancialPerformance';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['penjualan_neto', 'laba_tahun_berjalan', 'total_aset', 'hasil_dividen', 'tahun', 'user_id'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function withUser($id)
    {
        $this->builder()->where('user_id', $id);
        return $this;
    }
    
    public function processWeb($id)
    {
        if ($id === null) {
            $item = (new FinancialPerformance($_POST));
            $item->user_id = Services::login()->id;
            return $this->insert($item);
        } else if ($item = $this->find($id)) {
            /** @var FinancialPerformance $item */
            $item->fill($_POST);
            if ($item->hasChanged()) {
                $this->save($item);
            }
            return $id;
        }
        return false;
    }
}
