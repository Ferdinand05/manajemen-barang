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
}
