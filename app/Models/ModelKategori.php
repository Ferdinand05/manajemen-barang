<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'kat_id';
    protected $allowedFields    = ['kat_id', 'kat_nama'];


    public function cariData($keyword)
    {
        $builder = $this->table('kategori');
        $builder->like('kat_nama', $keyword);
        return $builder;
    }
}
