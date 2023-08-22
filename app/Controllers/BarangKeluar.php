<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangkeluar;
use App\Models\ModelBarangMasuk;
use App\Models\ModelTempBarangkeluar;

class BarangKeluar extends BaseController
{
    protected $barangmasuk, $temp_barangkeluar;

    public function __construct()
    {
        $this->barangmasuk = new ModelBarangMasuk();
        $this->temp_barangkeluar = new ModelTempBarangkeluar();
    }

    private function buatFaktur()
    {

        $tglSekarang = date('Y-m-d');
        $modelBarangKeluar = new ModelBarangkeluar();
        $hasil = $modelBarangKeluar->noFakturOtomatis($tglSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);

        // no urut ditambah+ 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi
        $noFaktur = "F" . date('dmy', strtotime($tglSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }

    public function buatNoFaktur()
    {
        $tanggal = $this->request->getPost('tanggal');

        $tglSekarang = $tanggal;
        $modelBarangKeluar = new ModelBarangkeluar();
        $hasil = $modelBarangKeluar->noFakturOtomatis($tglSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr("$data", -4);

        // no urut ditambah+ 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi
        $noFaktur = "F" . date('dmy', strtotime("$tglSekarang")) . sprintf('%04s', $nextNoUrut);

        $json = [
            'nofaktur' => $noFaktur,
        ];

        echo json_encode($json);
    }

    public function data()
    {
        $btnInput = '    <a href="/barangkeluar/input" class="btn btn-primary mb-2">Input Barang Masuk <i class="fa fa-plus"></i></a>';
        $data = [
            'title' => 'Manajemen Transaksi Barang Keluar',
            'subtitle' => $btnInput,
            'content' => '',
        ];

        return view('barangkeluar/vw_data', $data);
    }

    public function input()
    {
        $btnInput = '    <a href="/barangkeluar/data" class="btn btn-danger mb-2"> <i class="fa fa-backward"></i> Kembali</a>';
        $data = [
            'title' => 'Input Transaksi Barang Keluar',
            'subtitle' => $btnInput,
            'content' => '',
            'nofaktur' => $this->buatFaktur(),
        ];


        return view('barangkeluar/formInput', $data);
    }


    public function viewDataTemp()
    {
        if ($this->request->isAJAX()) {

            $nofaktur = $this->request->getPost('nofaktur');


            $dataTemp = $this->temp_barangkeluar->tampilDataTemp($nofaktur);

            $data = [
                'tampilData' => $dataTemp
            ];

            $json = [
                'data' => view('barangkeluar/dataTemp', $data)
            ];
        }
        echo json_encode($json);
    }
}
