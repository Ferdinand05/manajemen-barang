<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangkeluar extends Model
{
    protected $table            = 'barangkeluar';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'idplgn', 'totalharga', 'jumlahuang', 'sisauang'
    ];


    public function noFakturOtomatis($tglSekarang)
    {

        return $this->builder('barangkeluar')->selectMax('faktur', 'nofaktur')->where('tglfaktur', $tglSekarang)->get();
    }

    public function periodeLaporan2($tglawal, $tglakhir)
    {
        return $this->builder('barangkeluar')->where('tglfaktur >=', $tglawal)->where('tglfaktur <=', $tglakhir)->get();
    }
}
