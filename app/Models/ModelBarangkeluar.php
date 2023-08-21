<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangkeluar extends Model
{
    protected $table            = 'barangkeluar';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'idplgn', 'totalharga'
    ];


    public function noFakturOtomatis($tglSekarang)
    {

        return $this->builder('barangkeluar')->selectMax('faktur', 'nofaktur')->where('tglfaktur', $tglSekarang)->get();
    }
}
