<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangMasuk extends Model
{
    protected $table            = 'barangmasuk';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'totalharga'
    ];


    public function cariData($keyword)
    {
        return $this->table('barangmasuk')->like('faktur', $keyword)->orLike('tglfaktur', $keyword)->orLike('totalharga', $keyword);
    }


    public function cekFaktur($faktur)
    {

        return $this->table('barangmasuk')->getWhere([
            'sha1(faktur)' => $faktur,

        ]);
    }
}
