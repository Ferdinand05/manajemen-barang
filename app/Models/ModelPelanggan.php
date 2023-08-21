<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'nama', 'telepon'
    ];

    public function ambilDataTerakhir()
    {

        return $this->builder('pelanggan')->select('*')->get();

        // ambil semua field dari table Pelanggan, 1 data, urutkan secara Descending
        // return $this->builder('pelanggan')->limit(1)->orderBy('id', 'DESC')->get();
    }

    public function cariDataPelanggan($keyword)
    {

        return $this->builder('pelanggan')->like('nama', $keyword)->orLike('telepon', $keyword);
    }
}
