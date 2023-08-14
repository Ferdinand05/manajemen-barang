<?php

namespace App\Models;

use CodeIgniter\Database\SQLite3\Table;
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

    public function ambilTotalHarga($faktur)
    {

        $query = $this->table('detail_barangmasuk')->getWhere([
            'detfaktur' => $faktur
        ]);

        $totalHarga = 0;
        foreach ($query->getResultArray() as $r) {
            $totalHarga += $r['detsubtotal'];
        }

        return $totalHarga;
    }


    public function ambilDetailId($iddetail)
    {

        return $this->builder('detail_barangmasuk')->join('barang', 'kode_brg=detkodebrg')->where('iddetail', $iddetail)->get();
    }
}
