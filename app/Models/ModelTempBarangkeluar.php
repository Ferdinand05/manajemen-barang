<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempBarangkeluar extends Model
{
    protected $table            = 'temp_barangkeluar';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'detfaktur', 'detkodebrg', 'dethargajual', 'detjumlah', 'detsubtotal'
    ];


    public function tampilDataTemp($nofaktur)
    {
        return $this->builder('temp_barangkeluar')->join('barang b', 'detkodebrg = b.kode_brg')->where('detfaktur', $nofaktur)->get();
    }
}
