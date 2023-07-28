<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;

class Satuan extends BaseController
{
    protected $satuan;

    public function __construct()
    {
        $this->satuan = new ModelSatuan();
    }

    public function index()
    {

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $modelSatuan = $this->satuan->cariData($keyword);
        } else {
            $modelSatuan = $this->satuan;
        }


        $noHalaman = $this->request->getVar('page_satuan') ? $this->request->getVar('page_satuan') : 1;
        $data = [
            'title' => 'Manajemen Data Satuan',
            'subtitle' => 'Satuan Barang',
            'content' => '',
            'satuan' => $modelSatuan->paginate(5, 'satuan'),
            'pager' => $this->satuan->pager,
            'nohalaman' => $noHalaman,
        ];

        return view('satuan/vw_satuan', $data);
    }

    public function formTambah()
    {
        $data = [
            'title' => 'Data Satuan',
            'subtitle' => 'Form Tambah Data Satuan',
            'content' => '',
        ];

        return view('satuan/tambahData', $data);
    }

    public function simpanData()
    {
        $namaSatuan = $this->request->getVar('namaSatuan');
        $validation = \Config\Services::validation();

        $valid = $this->validate(
            [
                'namaSatuan' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required|is_unique[satuan.sat_nama]',
                    'errors' => [
                        'required' => 'Kolom {field} harus Di isi!',
                        'is_unique' => 'Nama Satuan telah digunakan!'
                    ]
                ]
            ]
        );

        if (!$valid) {

            session()->setFlashdata('errorNamaSatuan', '<div class="alert alert-danger mt-3">' . $validation->getError('namaSatuan') . '</div>');
            return redirect()->back()->withInput();
        }

        $this->satuan->insert([
            'sat_nama' => $namaSatuan,
        ]);
        session()->setFlashdata('berhasil', 'Data Satuan Berhasil Ditambah');
        return redirect()->to(base_url('satuan'))->withInput();
    }

    public function formEdit($id)
    {
        $rowData = $this->satuan->find($id);

        if ($rowData) {
            $data = [
                'id' => $rowData,
                'nama' => $rowData['sat_nama'],
                'title' => 'Edit Data',
                'subtitle' => 'Form Edit Data',
                'content' => ''
            ];

            return view('satuan/formEdit', $data);
        }
    }

    public function updateData()
    {
        $idSatuan = $this->request->getVar('idSatuan');
        $namaSatuan = $this->request->getVar('namaSatuan');
        $validation = \Config\Services::validation();

        $valid = $this->validate(
            [
                'namaSatuan' => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required|is_unique[satuan.sat_nama]',
                    'errors' => [
                        'required' => 'Kolom {field} harus Di isi!',
                        'is_unique' => 'Nama Satuan telah digunakan!'
                    ]
                ]
            ]
        );

        if (!$valid) {

            session()->setFlashdata('errorNamaSatuan', '<div class="alert alert-danger mt-3">' . $validation->getError('namaSatuan') . '</div>');
            return redirect()->back()->withInput();
        }

        $this->satuan->update($idSatuan, [
            'sat_nama' => $namaSatuan,
        ]);
        session()->setFlashdata('berhasil', 'Data Satuan Berhasil Ditambah');
        return redirect()->to(base_url('satuan'))->withInput();
    }

    public function hapus($id)
    {

        $rowData = $this->satuan->find($id);

        if ($rowData) {
            $this->satuan->delete($id);
            session()->setFlashdata('berhasil', 'Data Satuan Berhasil Dihapus!');
            return redirect()->back()->withInput();
        } else {
            exit("Data Tidak Ditemukan!");
        }
    }
}
