<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangkeluar;
use App\Models\ModelBarangMasuk;
use App\Models\ModelTempBarangkeluar;
use App\Models\ModelDataBarang;
use App\Models\ModelDetailBarangkeluar;
use App\Models\ModelPelanggan;
use App\Models\ModelDataBarangkeluar;
use CodeIgniter\Model;
use Config\Services;

class BarangKeluar extends BaseController
{
    protected $barangmasuk, $temp_barangkeluar, $barangkeluar, $detail_barangkeluar;

    public function __construct()
    {
        $this->barangmasuk = new ModelBarangMasuk();
        $this->temp_barangkeluar = new ModelTempBarangkeluar();
        $this->barangkeluar = new ModelBarangkeluar();
        $this->detail_barangkeluar = new ModelDetailBarangkeluar();
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
        $noFaktur = date('dmy', strtotime($tglSekarang)) . sprintf('%04s', $nextNoUrut);
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
        $noFaktur =  date('dmy', strtotime("$tglSekarang")) . sprintf('%04s', $nextNoUrut);

        $json = [
            'nofaktur' => $noFaktur,
        ];

        echo json_encode($json);
    }

    public function data()
    {
        $btnInput = '    <a href="/barangkeluar/input" class="btn btn-primary mb-2">Input Barang Keluar <i class="fa fa-plus"></i></a>';
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

    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {

            $kodebarang = $this->request->getPost('kodebarang');
            $modelBarang = new ModelBarang();
            $cekdata =  $modelBarang->find($kodebarang);
            if ($cekdata == null) {
                $json = [
                    'error' => 'Maaf Data Barang Tidak Ditemukan'
                ];
            } else {
                $data =  [
                    'namabarang' => $cekdata['nama_brg'],
                    'hargajual' => $cekdata['harga_brg']
                ];

                $json = [
                    'sukses' => $data
                ];
            }
        }
        echo json_encode($json);
    }


    public function simpanItem()
    {


        if ($this->request->isAJAX()) {

            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = $this->request->getPost('hargajual');
            $nofaktur = $this->request->getPost('nofaktur');
            $jumlah = $this->request->getPost('jumlah');

            $modelBarang = new ModelBarang();
            $cekStokBarang = $modelBarang->find($kodebarang);
            $stokBarang = $cekStokBarang['stok_brg'];

            if ($jumlah > $stokBarang) {

                $json = [
                    'error' => 'Stok Barang Tidak Mencukupi!'
                ];
            } else {

                $this->temp_barangkeluar->insert([
                    'detfaktur' => $nofaktur,
                    'detkodebrg' => $kodebarang,
                    'dethargajual' => $hargajual,
                    'detjumlah' => $jumlah,
                    'detsubtotal' => intval($hargajual) * intval($jumlah)
                ]);

                $json = [
                    'sukses' => 'Item Berhasil Ditambahkan!'
                ];
            }
        }
        echo json_encode($json);
    }


    public function hapusItem()
    {

        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');

            $this->temp_barangkeluar->delete($id);

            $json = [
                'sukses' => 'Item Berhasil Dihapus!'
            ];
        }
        echo json_encode($json);
    }

    public function modalCariBarang()
    {

        if ($this->request->isAJAX()) {

            $data = [];

            $json = [
                'data' => view('barangkeluar/modalCariBarang', $data)
            ];
        }

        echo json_encode($json);
    }


    public function listDataBarang()
    {

        $request = Services::request();
        $datamodel = new ModelDataBarang($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnPilih = '<button type="button" class="btn btn-secondary btn-sm" onclick="pilihBarang(\'' . $list->kode_brg . '\')">Select</button>';
                $row[] = $no;
                $row[] = $list->kode_brg;
                $row[] = $list->nama_brg;
                $row[] = number_format($list->harga_brg, 0, ',', '.');
                $row[] = $list->stok_brg;
                $row[] = $btnPilih;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function modalPembayaran()
    {

        if ($this->request->isAJAX()) {

            $nofaktur = $this->request->getPost('nofaktur');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $totalharga = $this->request->getPost('totalharga');
            $tglfaktur = $this->request->getPost('tglfaktur');

            $Cekdata = $this->temp_barangkeluar->tampilDataTemp($nofaktur);

            if ($Cekdata->getNumRows() <= 0) {
                $json = [
                    'error' => 'Item/Barang Masih Kosong'
                ];
            } else {

                $data = [
                    'nofaktur' => $nofaktur,
                    'idpelanggan' => $idpelanggan,
                    'totalharga' => $totalharga,
                    'tglfaktur' => $tglfaktur
                ];

                $json =  [
                    'data' => view('barangkeluar/modalPembayaran', $data)
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function simpanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $arr = ['Rp.', '.'];
            $nofaktur = $this->request->getVar('fakturPembayaran');
            $tglfaktur = $this->request->getPost('tglFaktur');
            $idPelanggan = $this->request->getPost('idPelanggan');
            $totalBayar = str_replace($arr, '', $this->request->getPost('totalBayar'));
            $uang = str_replace($arr, '', $this->request->getPost('uang'));
            $sisauang = str_replace($arr, '', $this->request->getPost('sisaUang'));


            // simpan ke table Barangkeluar

            $this->barangkeluar->insert([
                'faktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'idplgn' => $idPelanggan,
                'totalharga' => $totalBayar,
                'jumlahuang' => $uang,
                'sisauang' => $sisauang
            ]);

            $row = $this->temp_barangkeluar->getWhere(['detfaktur' => $nofaktur]);
            $fieldData = [];
            foreach ($row->getResultArray() as $r) {
                $fieldData[] = [
                    'detfaktur' => $r['detfaktur'],
                    'detkodebrg' => $r['detkodebrg'],
                    'dethargajual' => $r['dethargajual'],
                    'detjumlah' => $r['detjumlah'],
                    'detsubtotal' => $r['detsubtotal'],
                ];
            }

            $this->detail_barangkeluar->insertBatch($fieldData);
            $this->temp_barangkeluar->where('detfaktur', $nofaktur)->delete();

            $json = [
                'sukses' => 'Pembayaran Berhasil Diinput!',
                'cetakfaktur' => site_url('barangkeluar/cetakfaktur/' . $nofaktur)
            ];

            return $this->response->setJSON($json);
        }
    }

    public function cetakfaktur($faktur)
    {
        $modelPelanggan = new ModelPelanggan();

        $dataFaktur = $this->barangkeluar->find($faktur);
        $pelanggan = $modelPelanggan->find($dataFaktur['idplgn']);
        $namapelanggan = ($dataFaktur['idplgn'] != 0) ? $pelanggan['nama'] : '-';
        // dd($namapelanggan);

        $detail_barangkeluar = $this->detail_barangkeluar->tampilDataFaktur($faktur);
        // dd($detail_barangkeluar->getResultArray());
        if ($dataFaktur != null) {
            $data = [
                'faktur' => $faktur,
                'tglfaktur' => $dataFaktur['tglfaktur'],
                'nama' => $namapelanggan,
                'detailbarang' => $detail_barangkeluar,
                'jumlahuang' => $dataFaktur['jumlahuang'],

            ];
        } else {
            echo "faktur tidak ada!";
        }

        return view('barangkeluar/cetakfaktur', $data);
    }



    // dataTable serverside

    public function listData()
    {
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');
        $request = Services::request();
        $datamodel = new modelDataBarangkeluar($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {


                $no++;
                $row = [];
                $btnCetak = '<button type="button" class="btn btn-primary btn-sm" onclick="cetakFaktur(\'' . $list->faktur . '\')"><i class="fa fa-print"></i></button>';
                $btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="hapusFaktur(\'' . $list->faktur . '\')"><i class="fa fa-trash-alt"></i></button>';
                $btnEdit = '<button type="button" class="btn btn-success btn-sm" onclick="editFaktur(\'' . $list->faktur . '\')"><i class="fa fa-edit"></i></button>';
                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tglfaktur;
                $row[] = $list->nama;
                $row[] = $list->totalharga;
                $row[] = $btnCetak . " " . $btnHapus . " " . $btnEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }



    public function hapusTransaksi()
    {
        if ($this->request->isAJAX()) {

            $faktur = $this->request->getPost('faktur');

            $this->barangkeluar->delete($faktur);
            $this->detail_barangkeluar->where('detfaktur', $faktur)->delete();
            $json = [
                'sukses' => 'Data Transaksi Berhasil Dihapus!'
            ];
        }
        return $this->response->setJSON($json);
    }

    public function edit($faktur)
    {
        $btnInput = '    <a href="/barangkeluar/data" class="btn btn-danger mb-2">Kembali <i class="fa fa-backward"></i></a>';

        $dataBarangKeluar = $this->barangkeluar->find($faktur);
        $modelPelanggan = new ModelPelanggan();
        $dataPelanggan = $modelPelanggan->find($dataBarangKeluar['idplgn']);
        $namapelanggan = $dataPelanggan['nama'];
        $data = [
            'title' => 'FORM EDIT TRANSAKSI BARANG KELUAR',
            'subtitle' => $btnInput,
            'content' => '',
            'faktur' => $dataBarangKeluar['faktur'],
            'tglfaktur' => $dataBarangKeluar['tglfaktur'],
            'namapelanggan' => $namapelanggan

        ];
        return view('barangkeluar/formedit', $data);
    }


    public function getTotalHarga()
    {
        if ($this->request->isAJAX()) {

            $faktur = $this->request->getPost('faktur');

            $totalHarga = $this->detail_barangkeluar->getTotalHarga($faktur);

            $json = [
                'totalharga' => number_format($totalHarga, 0, ',', '.')
            ];

            return $this->response->setJSON($json);
        } else {
            exit('Tidak Bisa Diakses');
        }
    }

    public function viewDataDetail()
    {
        if ($this->request->isAJAX()) {

            $nofaktur = $this->request->getPost('faktur');

            $dataTemp = $this->detail_barangkeluar->tampilDataFaktur($nofaktur);

            $data = [
                'tampilData' => $dataTemp
            ];

            $json = [
                'data' => view('barangkeluar/dataDetail', $data)
            ];
        }
        echo json_encode($json);
    }

    public function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $tableDetailBarangkeluar = $this->detail_barangkeluar->find($id);
            $nofaktur = $tableDetailBarangkeluar['detfaktur'];

            // Hapus Item Detail Barang keluar
            $this->detail_barangkeluar->delete($id);

            $totalHarga = $this->detail_barangkeluar->getTotalHarga($nofaktur);

            // update total haraga
            $this->barangkeluar->update($nofaktur, [
                'totalharga' => $totalHarga
            ]);

            $json = [
                'sukses' => 'Item Berhasil Dihapus'
            ];
        }

        return $this->response->setJSON($json);
    }

    public function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $jumlah = $this->request->getPost('jumlah');

            $tableDetailBarangkeluar = $this->detail_barangkeluar->find($iddetail);
            $faktur = $tableDetailBarangkeluar['detfaktur'];

            // update jumlah dan subtotal, table detail BK
            $this->detail_barangkeluar->update($iddetail, [
                'detjumlah' => $jumlah,
                'detsubtotal' => $jumlah * intval($tableDetailBarangkeluar['dethargajual'])
            ]);

            $totalHarga = $this->detail_barangkeluar->getTotalHarga($faktur);
            // update totalharga
            $this->barangkeluar->update($faktur, [
                'totalharga' => $totalHarga
            ]);

            $json = [
                'sukses' => 'Item Berhasil Diubah!'
            ];
        }

        return $this->response->setJSON($json);
    }

    public function simpanItemDetail()
    {
        if ($this->request->isAJAX()) {

            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = $this->request->getPost('hargajual');
            $nofaktur = $this->request->getPost('nofaktur');
            $jumlah = $this->request->getPost('jumlah');

            $modelBarang = new ModelBarang();
            $cekStokBarang = $modelBarang->find($kodebarang);
            $stokBarang = $cekStokBarang['stok_brg'];

            if ($jumlah > $stokBarang) {

                $json = [
                    'error' => 'Stok Barang Tidak Mencukupi!'
                ];
            } else {

                $this->detail_barangkeluar->insert([
                    'detfaktur' => $nofaktur,
                    'detkodebrg' => $kodebarang,
                    'dethargajual' => $hargajual,
                    'detjumlah' => $jumlah,
                    'detsubtotal' => intval($hargajual) * intval($jumlah)
                ]);

                $totalHarga = $this->detail_barangkeluar->getTotalHarga($nofaktur);
                // update totalharga
                $this->barangkeluar->update($nofaktur, [
                    'totalharga' => $totalHarga
                ]);

                $json = [
                    'sukses' => 'Item Berhasil Ditambahkan!'
                ];
            }
        }
        echo json_encode($json);
    }
}
