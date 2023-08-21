<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPelanggan;

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

        $totalPelanggan = $this->pelanggan->countAllResults();
        $data = [
            'pelanggan' => $this->pelanggan->findAll(),
            'totalPelanggan' => $totalPelanggan,
        ];

        $json = [
            'data' => view('pelanggan/modalPelanggan', $data)
        ];

        echo json_encode($json);
    }
}
