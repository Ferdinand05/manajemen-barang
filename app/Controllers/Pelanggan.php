<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDataPelanggan;
use App\Models\ModelPelanggan;
use Config\Services;

class Pelanggan extends BaseController
{
    protected $pelanggan;

    public function __construct()
    {
        $this->pelanggan = new ModelPelanggan();
    }

    public function formTambah()
    {

        $json = [
            'data' => view('pelanggan/modalTambah')
        ];

        echo json_encode($json);
    }

    public function simpan()
    {

        $namaPelanggan = $this->request->getPost('namaPelanggan');
        $telp = $this->request->getPost('telp');

        $rules = [
            'namaPelanggan' => [
                'label' => 'Nama Pelanggan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong!',
                ]
            ],
            'telp' => [
                'label' => 'Telepon Pelanggan',
                'rules' => 'required|is_unique[pelanggan.telepon]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong!',
                    'is_unique' => '{field}  Sudah Digunakan'
                ]
            ]
        ];

        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $json = [
                'error' => [
                    'errorNamaPelanggan' => $validation->getError('namaPelanggan'),
                    'errorTelp' => $validation->getError('telp')
                ]
            ];

            echo json_encode($json);
        } else {

            $this->pelanggan->insert([
                'nama' => $namaPelanggan,
                'telepon' => $telp
            ]);


            // Ambil Baris Terakhir
            $row = $this->pelanggan->ambilDataTerakhir()->getLastRow('array');
            // $row = $modelPelanggan->ambilDataTerakhir()->getRowArray();
            $json = [
                'sukses' => 'Pelanggan Berhasil Ditambah.',
                'data' => [
                    'namaPelanggan' => $row['nama'],
                    'idPelanggan' => $row['id']
                ]
            ];

            echo json_encode($json);
        }
    }


    public function daftarPelanggan()
    {

        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('pelanggan/modalPelanggan')
            ];
        }
        echo json_encode($json);
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelDataPelanggan($request);
        if ($request->getPost()) {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $btnPilih = '<button type="button" class="btn btn-secondary btn-sm" onclick="pilihPelanggan(\'' . $list->id . '\',\'' . $list->nama . '\')">Select</button>';
                $btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="hapusPelanggan(\'' . $list->id . '\',\'' . $list->nama . '\')">Delete</button>';
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->telepon;
                $row[] = $btnPilih . " " . $btnHapus;
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

    public function hapusPelanggan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $this->pelanggan->delete($id);

            $json = [
                'sukses' => 'Data Pelanggan Berhasil Dihapus!'
            ];
        }
        echo json_encode($json);
    }
}
