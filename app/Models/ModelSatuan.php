<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSatuan extends Model
{
    protected $table            = 'satuan';
    protected $primaryKey       = 'sat_id';
    protected $allowedFields    = ['sat_id', 'sat_nama'];


    public function cariData($keyword)
    {
        return $this->table('satuan')->like('sat_nama', $keyword);
    }
}
