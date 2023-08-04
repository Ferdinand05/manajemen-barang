<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelTempBarangMasuk;

class BarangMasuk extends BaseController
{




    public function index()
    {
        $data = [
            'title' => 'Barang Masuk',
            'subtitle' => 'Manajemen Barang Masuk',
            'content' => '',
        ];

        return view('barangmasuk/formInput', $data);
    }

    public function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelTemp = new ModelTempBarangMasuk();
            $data = [
                'dataTemp' => $modelTemp->tampilDataTemp($faktur)
            ];

            $json = [
                'data' => view('barangmasuk/datatemp', $data)
            ];
            $jsond = json_encode($json);
            echo $jsond;
        } else {
            exit('Maaf tidak bisa Dipanggil!');
        }
    }

    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');
            $modelBarang = new ModelBarang();
            $ambilData = $modelBarang->find($kodebarang);

            if ($ambilData == null) {
                $json = [
                    'error' => 'Data tidak ditemukan'
                ];
            } else {

                $data = [
                    'namabarang' => $ambilData['nama_brg'],
                    'hargajual' => $ambilData['harga_brg'],
                ];

                $json = [
                    'sukses' => $data,
                ];
            }


            echo json_encode($json);
        } else {
            exit('Maaf data tidak bisa Dipanggil!');
        }
    }


    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $hargajual = $this->request->getPost('hargajual');
            $jumlah = $this->request->getPost('jumlah');

            $modelTempBarang = new ModelTempBarangMasuk();
            $modelTempBarang->insert([
                'detfaktur' => $faktur,
                'detkodebrg' => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'dethargajual' => $hargajual,
                'detjumlah' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $json = [
                'sukses' =>  'Item berhasil ditambahkan'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil!');
        }
    }


    public function hapus()
    {

        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarang = new ModelTempBarangMasuk();
            $modelTempBarang->delete($id);

            $json = [
                'sukses' => 'Item berhasil dihapus!',
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil!');
        }
    }


    public function cariDataBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('barangmasuk/modalcaribarang'),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }


    public function detailCariBarang()
    {
        if ($this->request->isAJAX()) {

            $cari = $this->request->getPost('cari');

            $modelBarang = new ModelBarang();

            $data = $modelBarang->cariData($cari)->get();

            if ($data  != null) {

                $json = [
                    'data' => view('barangmasuk/detailDataBarang', [
                        'tampildata' => $data
                    ]),
                ];
                echo json_encode($json);
            }
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
