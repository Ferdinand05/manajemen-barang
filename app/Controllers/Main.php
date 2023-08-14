<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelKategori;

class Main extends BaseController
{
    protected $barang, $kategori;

    public function __construct()
    {
        $this->barang = new ModelBarang();
        $this->kategori = new ModelKategori();
    }

    public function index()
    {

        $jumlahBarang = $this->barang->builder('barang')->countAll();
        $jumlahKategori = $this->kategori->builder('kategori')->countAll();

        $data = [
            'title' => 'Sistem Informasi Pengelolaan Barang',
            'subtitle' => '<h3 class="text-center font-weight-bold">Selamat Datang!</h3> <br> Segala Pertanyaan dan Permasalahan terkait Sistem ini dapat Segera Hubungi Administrator Terkait.',
            'content' => '',
            'barang' => $jumlahBarang,
            'kategori' => $jumlahKategori
        ];

        return view('main/index', $data);
    }
}
