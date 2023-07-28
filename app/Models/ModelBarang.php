<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'kode_brg';
    protected $allowedFields    = [
        'kode_brg', 'nama_brg', 'brg_katid', 'brg_satid', 'harga_brg', 'gambar_brg', 'stok_brg'
    ];

    public function tampilData()
    {
        $builder = $this->builder('barang');
        $builder->select('*');
        $builder->join('kategori', 'barang.brg_katid = kategori.kat_id')->join('satuan', 'barang.brg_satid = satuan.sat_id');
        $query = $builder->get()->getResultArray();
        return $query;
    }
}
