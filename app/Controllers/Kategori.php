<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use Config\Pager;

class Kategori extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new ModelKategori();
    }
    public function index()
    {

        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $modelKategori = $this->kategori->cariData($keyword);
        } else {
            $modelKategori = $this->kategori;
        }



        $noHalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        $data = [
            'title' => 'Manajemen Data Kategori',
            'subtitle' => 'Kategori Barang',
            'content' => '',
            'kategori' => $modelKategori->paginate(5, 'kategori'),
            'pager' => $this->kategori->pager,
            'totaldata' => $this->kategori->pager->getTotal('kategori'),
            'nohalaman' => $noHalaman
        ];

        return view('kategori/vw_kategori', $data);
    }

    public function formTambah()
    {

        $data = [
            'title' => 'Kategori Barang',
            'subtitle' => 'Form Tambah Kategori Barang',
            'content' => ''

        ];

        return view('kategori/tambahData', $data);
    }

    public function simpanData()
    {
        $namaKategori = $this->request->getVar('namaKategori');
        $validation = \Config\Services::validation();

        $valid = $this->validate(
            [
                'namaKategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required|is_unique[kategori.kat_nama]',
                    'errors' => [
                        'required' => 'Kolom {field} harus Di isi!',
                        'is_unique' => 'Nama Kategori telah digunakan!'
                    ]
                ]
            ]
        );

        if (!$valid) {

            $pesan = [
                'errorNamaKategori' => '<div class="alert alert-danger mt-3">' . $validation->getError('namaKategori') . '</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->back()->withInput();
        }

        $this->kategori->insert([
            'kat_nama' => $namaKategori,
        ]);
        session()->setFlashdata('berhasil', 'Data Kategori Berhasil Ditambah');
        return redirect()->to(base_url('kategori'))->withInput();
    }


    public function formEdit($id)
    {
        $rowData = $this->kategori->find($id);

        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['kat_nama'],
                'title' => ' Edit Kategori',
                'subtitle' => 'Form Edit Kategori',
                'content' => '',
            ];

            return view('/kategori/formEdit', $data);
        } else {
            exit('Data Tidak Ditemukan');
        }
    }






    public function updateData()
    {
        $namaKategori = $this->request->getVar('namaKategori');
        $idKategori = $this->request->getVar('idKategori');
        $validation = \Config\Services::validation();

        $valid = $this->validate(
            [
                'namaKategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required|is_unique[kategori.kat_nama]',
                    'errors' => [
                        'required' => 'Kolom {field} harus Di isi!',
                        'is_unique' => 'Nama Kategori telah digunakan!'
                    ]
                ]
            ]
        );

        if (!$valid) {

            $pesan = [
                'errorNamaKategori' => '<div class="alert alert-danger mt-3">' . $validation->getError('namaKategori') . '</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->back()->withInput();
        }

        $this->kategori->update($idKategori, [
            'kat_nama' => $namaKategori,
        ]);
        session()->setFlashdata('berhasil', 'Data Kategori Berhasil Diubah');
        return redirect()->to(base_url('kategori'))->withInput();
    }

    public function hapus($id)
    {
        $rowData = $this->kategori->find($id);

        if ($rowData) {
            $this->kategori->delete($id);

            session()->setFlashdata('berhasil', 'Data Kategori Berhasil Dihapus');
            return redirect()->back()->withInput();
        } else {
            exit('Data Tidak Ditemukan');
        }
    }
}
