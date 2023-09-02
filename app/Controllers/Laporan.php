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

        $tableBarangmasuk = new ModelBarangMasuk();
        $dataLaporan = $tableBarangmasuk->periodeLaporan($tglawal, $tglakhir);
        $data = [
            'dataLaporan' => $dataLaporan->getResultArray(),
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        return view('laporan/laporanBarangmasuk', $data);
    }


    public function showGrafik()
    {

        $bulan = $this->request->getPost('bulan');
        $db = \Config\Database::connect();
        $sql = "SELECT tglfaktur as tgl,totalharga FROM barangmasuk WHERE DATE_FORMAT(tglfaktur,'%Y-%m') = '$bulan' ORDER BY tglfaktur ASC";
        $grafik = $db->query($sql)->getResult('array');

        $data = [
            'grafik' => $grafik
        ];
        $json = [
            'data' => view('laporan/grafikBarangmasuk', $data)
        ];

        echo json_encode($json);
    }


    public function cetak_barang_keluar()
    {

        $btn = "<a href='/laporan' class='btn btn-danger'><i class='fa fa-backward'></i> Kembali</a>";
        $data = [
            'title' => 'Laporan Barang Keluar',
            'subtitle' => $btn,
            'content' => ''
        ];
        return view('laporan/barangkeluar', $data);
    }

    public function cetakBarangkeluarPeriode()
    {
        $tglawal = $this->request->getVar('tglAwalBarangkeluar');
        $tglakhir = $this->request->getVar('tglAkhirBarangkeluar');

        $tableBarangkeluar = new ModelBarangkeluar();
        $dataLaporan = $tableBarangkeluar->periodeLaporan2($tglawal, $tglakhir);
        $data = [
            'dataLaporan' => $dataLaporan->getResultArray(),
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        return view('laporan/laporanBarangkeluar', $data);
    }

    public function showGrafikBarangkeluar()
    {
        $bulan = $this->request->getPost('bulan');
        $db = \Config\Database::connect();
        $sql = "SELECT tglfaktur as tgl,totalharga FROM barangkeluar WHERE DATE_FORMAT(tglfaktur,'%Y-%m') = '$bulan' ORDER BY tglfaktur ASC";
        $grafik = $db->query($sql)->getResult('array');

        $data = [
            'grafik' => $grafik
        ];
        $json = [
            'data' => view('laporan/grafikBarangkeluar', $data)
        ];

        echo json_encode($json);
    }
}
