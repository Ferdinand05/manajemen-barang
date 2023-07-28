<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Main extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Sistem Informasi Pengelolaan Barang',
            'subtitle' => 'Selamat Datang!',
            'content' => 'Selamat menggunakan program ini, bila ada kendala dan pertanyaan, Silahkan hubungi Administrator terkait.'
        ];

        return view('main/layout', $data);
    }
}
