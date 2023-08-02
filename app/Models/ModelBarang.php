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
        $builder = $this->table('barang');
        $builder->select('*');
        $builder->join('kategori', 'brg_katid = kat_id');
        $builder->join('satuan', 'brg_satid = sat_id');
        return $builder;
    }

    public function cariData($k)
    {
        $builder = $this->table('barang');
        $builder->join('kategori', 'brg_katid =kat_id');
        $builder->join('satuan', 'brg_satid = sat_id')->like('kode_brg', $k)->orLike('nama_brg', $k)->orLike('harga_brg', $k)->orLike('stok_brg', $k)->orLike('kat_nama', $k);
        return $builder;
    }

    public function totalData()
    {
        $builder = $this->table('barang');
        $builder->select('*');
        $builder->join('kategori', 'brg_katid = kat_id');
        $builder->join('satuan', 'brg_satid = sat_id');
        return $builder;
    }
}
