<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FinancialPerformance extends Entity
{
    protected $datamap = [];
    protected $casts   = ['id' => 'integer'];
}
