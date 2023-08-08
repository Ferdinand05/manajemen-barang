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
        return $this->table('temp_barangmasuk')->join('barang', 'kode_brg = detkodebrg')->where(['detfaktur' => $faktur])->get();
    }
}
