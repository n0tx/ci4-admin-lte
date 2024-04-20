<?php

namespace App\Models;

use App\Entities\FinancialPerformance;
use CodeIgniter\Model;
use Config\Services;

class FinancialPerformanceModel extends Model
{
  
    public static $years = [
        '2010','2011','2012',
        '2013','2014','2015',
        '2016','2017','2018',
        '2019','2020','2021',
        '2022','2023','2024'
    ];
  /*
  public static $years;
  public function __construct()
  {
    // $years = range('2010', '2024');
    $year = implode(',',  range(2010, 2024));
  }
  */
  
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
    
    public function checkDuplicateYear(int $id = null, $year)
    {
      $exist = false;
      if ($id === null) {
        if ($this->isYearExist($year)) {
          $exist = true;
        }
      } else {
        $itemFromPost = (new FinancialPerformance($_POST));
        $itemFromDb = $this->find($id);
        if ($itemFromPost->tahun === $itemFromDb->tahun) {
          $exist = true;
        } else {
          if ($this->isYearExist($year)) {
            $exist = true;
          }
        }
      }
      return $exist;
      /*
      $itemFromPost = (new FinancialPerformance($_POST));
      return $itemFromPost->tahun;
      */
      
      // ok, ini jalan
      // return 'hello';
      
      // pake ini dulu
      // ok ini jalan
      /*
      $item = $this->find(11);
      return $item->tahun;
      */
      
      // baru pake ini, belum works
      /*
      $this->builder()->where('id', 2);
      return $this['tahun'];
      */
      /*
      $item = (new FinancialPerformance($_POST));
      $item->user_id = Services::login()->id;
      // return $this->insert($item);
      return $item;
      */
    }
    
    public function isYearExist($year) {
      $model = new FinancialPerformanceModel();
      if ($model->where('tahun', $year)->countAllResults() > 0) {
        return true;
      }
      return false;
    }
  
    /*
    // buat test query dulu
    // baru buat ambil POST
  $this->builder()->where('user_id', $id);
  return $this;
  */
}
