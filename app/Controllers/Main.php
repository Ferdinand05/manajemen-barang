<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangkeluar;
use App\Models\ModelBarangMasuk;
use App\Models\ModelKategori;

class Main extends BaseController
{
    protected $barang, $kategori, $barangmasuk, $barangkeluar;

    public function __construct()
    {
        $this->barang = new ModelBarang();
        $this->kategori = new ModelKategori();
        $this->barangmasuk = new ModelBarangMasuk();
        $this->barangkeluar = new ModelBarangkeluar();
    }

    public function index()
    {

        $jumlahBarang = $this->barang->builder('barang')->countAll();
        $jumlahKategori = $this->kategori->builder('kategori')->countAll();
        $jumlahBarangmasuk = $this->barangmasuk->builder('barangmasuk')->countAll();
        $jumlahBarangkeluar = $this->barangmasuk->builder('barangkeluar')->countAll();
        $data = [
            'title' => 'Sistem Informasi Pengelolaan Barang',
            'subtitle' => '<h3 class="text-center font-weight-bold">Selamat Datang!</h3> <br> Segala Pertanyaan dan Permasalahan terkait Sistem ini dapat Segera Hubungi Administrator Terkait.',
            'content' => '',
            'barang' => $jumlahBarang,
            'kategori' => $jumlahKategori,
            'barangmasuk' => $jumlahBarangmasuk,
            'barangkeluar' => $jumlahBarangkeluar,

        ];

        return view('main/index', $data);
    }
}
