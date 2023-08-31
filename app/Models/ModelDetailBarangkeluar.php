<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangkeluar extends Model
{

    protected $table            = 'detail_barangkeluar';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'detfaktur', 'detkodebrg', 'dethargajual', 'detjumlah', 'detsubtotal'
    ];

    public function tampilDataFaktur($faktur)
    {

        return $this->builder('detail_barangkeluar')->where('detfaktur', $faktur)->join('barang as brg', 'kode_brg = detkodebrg')->get();
    }

    public function getTotalHarga($faktur)
    {

        $tableDetail = $this->builder('detail_barangkeluar')->where('detfaktur', $faktur)->get()->getResultArray();

        $totalharga = 0;
        foreach ($tableDetail as $subtotal) {
            $totalharga += $subtotal['detsubtotal'];
        }
        return $totalharga;
    }
}
