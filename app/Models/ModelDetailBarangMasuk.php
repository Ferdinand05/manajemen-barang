<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangMasuk extends Model
{
    protected $table            = 'detail_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'iddetail', 'detfaktur', 'detkodebrg', 'dethargamasuk', 'dethargajual', 'detjumlah', 'detsubtotal'
    ];



    public function dataDetail($faktur)
    {

        return $this->table('detail_barangmasuk')->join('barang', 'kode_brg = detkodebrg')->where('detfaktur', $faktur)->get();
    }
}
