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
}
