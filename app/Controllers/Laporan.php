<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangkeluar;
use App\Models\ModelBarangMasuk;

class Laporan extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Laporan Barang Masuk dan Barang Keluar',
            'subtitle' => 'Laporan',
            'content' => ''
        ];

        return view('laporan/index', $data);
    }

    public function cetak_barang_masuk()
    {

        $btn = "<a href='/laporan' class='btn btn-danger'><i class='fa fa-backward'></i> Kembali</a>";
        $data = [
            'title' => 'Laporan Barang Masuk',
            'subtitle' => $btn,
            'content' => ''
        ];
        return view('laporan/barangmasuk', $data);
    }


    public function cetakBarangmasukPeriode()
    {
        $tglawal = $this->request->getVar('tglAwal');
        $tglakhir = $this->request->getVar('tglAkhir');

        $tableBarangkeluar = new ModelBarangMasuk();
        $dataLaporan = $tableBarangkeluar->periodeLaporan($tglawal, $tglakhir);
        $data = [
            'dataLaporan' => $dataLaporan->getResultArray(),
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        return view('laporan/laporanBarangmasuk', $data);
    }
}
