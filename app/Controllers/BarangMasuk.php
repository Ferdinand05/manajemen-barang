<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelTempBarangMasuk;
use App\Models\ModelBarangMasuk;
use App\Models\ModelDetailBarangMasuk;

class BarangMasuk extends BaseController
{

    protected $barangmasuk;

    public function __construct()
    {
        $this->barangmasuk = new ModelBarangMasuk();
    }

    public function index()
    {
        $tombol = '<a href="/barangmasuk/data" class="btn btn-warning" ><i class="fa fa-backward" ></i> Kembali </a>';
        $data = [
            'title' => 'Input Barang Masuk',
            'subtitle' => $tombol,
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


    public function selesaiTransaksi()
    {

        if ($this->request->isAJAX()) {

            $faktur = $this->request->getPost('faktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $modelTemp = new ModelTempBarangMasuk();
            $dataTempBarang = $modelTemp->builder('temp_barangmasuk')->getWhere(['detfaktur' => $faktur]);

            if ($dataTempBarang->getNumRows() == 0) {
                $json = [
                    'error' => 'Data item Untuk faktur ini Tidak ada!'
                ];
            } else {

                // simpan ke table barangmasuk
                $modelBarangmasuk = new ModelBarangMasuk();
                $totalSubtotal = 0;

                foreach ($dataTempBarang->getResultArray() as $total) :

                    $totalSubtotal += intval($total['detsubtotal']);
                endforeach;

                $modelBarangmasuk->insert([
                    'faktur' => $faktur,
                    'tglfaktur' => $tglfaktur,
                    'totalharga' => $totalSubtotal
                ]);


                // simpan ke detail_barangmasuk
                $modelDetailBarangmasuk = new ModelDetailBarangMasuk();

                foreach ($dataTempBarang->getResultArray() as $row) :
                    $modelDetailBarangmasuk->insert([
                        'detfaktur' => $row['detfaktur'],
                        'detkodebrg' => $row['detkodebrg'],
                        'dethargamasuk' => $row['dethargamasuk'],
                        'dethargajual' => $row['dethargajual'],
                        'detjumlah' => $row['detjumlah'],
                        'detsubtotal' => $row['detsubtotal']
                    ]);
                endforeach;

                // Hapus data yg ada di temporary berdasarkan faktur
                $modelTemp->emptyTable();
                $json = [
                    'sukses' => 'Transaksi Berhasil Disimpan!'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }


    public function data()
    {
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $modelBarangmasuk = $this->barangmasuk->cariData($keyword);
        } else {
            $modelBarangmasuk = $this->barangmasuk;
        }

        $nohalaman = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;

        $data = [
            'title' => 'Data Transaksi Barang Masuk',
            'subtitle' => 'Transaksi Barang Masuk',
            'content' => '',
            'barangmasuk' => $modelBarangmasuk->paginate(5, 'barangmasuk'),
            'pager' => $this->barangmasuk->pager,
            'totaldata' => $this->barangmasuk->pager->getTotal('barangmasuk'),
            'nohalaman' => $nohalaman,

        ];

        return view('barangmasuk/vw_data', $data);
    }



    public function detailItem()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $modelDetailBarangmasuk = new ModelDetailBarangMasuk();
            $data = [
                'dataDetail' => $modelDetailBarangmasuk->dataDetail($faktur)
            ];

            $json = [
                'data' => view('barangmasuk/modaldetailitem', $data)
            ];

            echo json_encode($json);
        } else {
            exit('Method tidak bisa dipanggil');
        }
    }


    public function edit($faktur)
    {
        $modelBarangmasuk = new ModelBarangMasuk();

        $cekFaktur = $modelBarangmasuk->cekFaktur($faktur);

        if ($cekFaktur->getNumRows() > 0) {
            $row = $cekFaktur->getRowArray();

            $tombol = '<a href="/barangmasuk/data" class="btn btn-warning" ><i class="fa fa-backward" ></i> Kembali </a>';
            $data = [
                'title' => 'Edit Barang Masuk',
                'subtitle' => $tombol,
                'content' => '',
                'nofaktur' => $row['faktur'],
                'tanggal' => $row['tglfaktur']
            ];

            return view('barangmasuk/editBarangMasuk', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }


    public function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new ModelDetailBarangMasuk();

            $data = [
                'dataDetail' => $modelDetail->dataDetail($faktur),
            ];

            $totalHargaFaktur = number_format($modelDetail->ambilTotalHarga($faktur), '0', ',', '.');
            $json = [
                'data' => view('barangmasuk/dataDetail', $data),
                'totalharga' => $totalHargaFaktur
            ];
            echo json_encode($json);
        }
    }


    public function editItem()
    {

        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');

            $modelDetail = new ModelDetailBarangMasuk();
            $ambilData = $modelDetail->ambilDetailId($iddetail);
            $row = $ambilData->getRowArray();

            $data = [
                'kodebarang' => $row['detkodebrg'],
                'namabarang' => $row['nama_brg'],
                'hargajual' => $row['dethargajual'],
                'hargabeli' => $row['dethargamasuk'],
                'jumlah' => $row['detjumlah']
            ];

            $json = [
                'sukses' => $data
            ];

            echo json_encode($json);
        }
    }


    public function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $hargajual = $this->request->getPost('hargajual');
            $jumlah = $this->request->getPost('jumlah');

            $modelDetailBarang = new ModelDetailBarangMasuk();
            $modelBarangmasuk = new ModelBarangMasuk();
            $modelDetailBarang->insert([
                'detfaktur' => $faktur,
                'detkodebrg' => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'dethargajual' => $hargajual,
                'detjumlah' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetailBarang->ambilTotalHarga($faktur);
            $modelBarangmasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' =>  'Item berhasil ditambahkan'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil!');
        }
    }

    public function updateItem()
    {

        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $hargajual = $this->request->getPost('hargajual');
            $jumlah = $this->request->getPost('jumlah');
            $iddetail = $this->request->getPost('iddetail');

            $modelDetail = new ModelDetailBarangMasuk();
            $modelBarangmasuk = new ModelBarangMasuk();

            $modelDetail->update($iddetail, [
                'dethargamasuk' => $hargabeli,
                'dethargajual' => $hargajual,
                'detjumlah' => $jumlah,
                'detsubtotal' => intval($hargabeli) * intval($jumlah)
            ]);

            // update totalHarga
            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);
            $modelBarangmasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' => 'Item ' . $kodebarang . ' Berhasil Diubah!'
            ];
            echo json_encode($json);
        }
    }

    public function hapusItemDetail()
    {

        if ($this->request->isAJAX()) {

            $iddetail = $this->request->getPost('id');
            $faktur = $this->request->getPost('faktur');

            // hapus data di detail_barangmasuk
            $modelDetail = new ModelDetailBarangMasuk();
            $modelDetail->delete($iddetail);


            // update harga dari faktur di barangmasuk
            $updateTotalHarga = $modelDetail->ambilTotalHarga($faktur);
            $modelBarangmasuk = new ModelBarangMasuk();
            $modelBarangmasuk->update($faktur, [
                'totalharga' => $updateTotalHarga
            ]);

            $json = [
                'sukses' => 'Item Berhasil Dihapus!'
            ];

            echo json_encode($json);
        }
    }


    public function hapusFaktur()
    {
        if ($this->request->isAJAX()) {

            $faktur = $this->request->getPost('faktur');

            $modelDetail = new ModelDetailBarangMasuk();
            $modelBarangMasuk = new ModelBarangMasuk();

            $modelDetail->delete([
                'detfaktur' => $faktur
            ]);
            $modelBarangMasuk->delete($faktur);

            $json = [
                'sukses' => 'Data Transaksi berhasil Dihapus!'
            ];

            echo json_encode($json);
        }
    }
}
