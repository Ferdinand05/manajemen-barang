<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempBarangMasuk extends Model
{
    protected $table            = 'temp_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'iddetail', 'detfaktur', 'detkodebrg', 'dethargamasuk', 'dethargajual', 'detjumlah', 'detsubtotal'
    ];


    public function tampilDataTemp($faktur)
    {
        $builder =  $this->builder('temp_barangmasuk');
        $builder->join('barang', 'kode_brg = detkodebrg');
        $query =  $builder->where('detfaktur', $faktur)->get();
        return $query;
    }
}
