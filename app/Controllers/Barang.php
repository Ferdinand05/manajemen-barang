<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;

class Barang extends BaseController
{
    protected $barang, $satuan, $kategori;

    public function __construct()
    {
        $this->barang = new ModelBarang();
        $this->satuan = new ModelSatuan();
        $this->kategori = new ModelKategori();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Data Barang',
            'subtitle' => 'Barang',
            'content' => '',
            'barang' => $this->barang->tampilData(),
        ];

        return view('barang/vw_barang', $data);
    }

    public function formTambah()
    {


        $data = [
            'title' => 'Barang',
            'subtitle' => 'Form Tambah Barang',
            'content' => '',
            'satuan' => $this->satuan->findAll(),
            'kategori' => $this->kategori->findAll(),
        ];

        return view('barang/tambahData', $data);
    }

    public function simpanData()
    {
        $kodeBarang = $this->request->getVar('kode_barang', FILTER_SANITIZE_SPECIAL_CHARS);
        $namaBarang = $this->request->getVar('nama_barang', FILTER_SANITIZE_SPECIAL_CHARS);
        $kategori = $this->request->getVar('select_kategori');
        $satuan = $this->request->getVar('select_satuan');
        $hargaBarang = $this->request->getVar('harga_barang');
        $stokBarang = $this->request->getVar('stok_barang');


        $validation = \Config\Services::validation();

        $rules = $this->validate([
            'kode_barang' => [
                'label' => 'Kode Barang',
                'rules' => 'required|is_unique[barang.kode_brg]|string',
                'errors' => [
                    'required' => '{field} Harus Diisi!',
                    'is_unique' => 'Kode Barang sudah digunakan!'
                ]
            ],
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus Diisi!'
                ]
            ],
            'select_kategori' => [
                'label' => 'Kategori Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus Diisi!'
                ]
            ],
            'select_satuan' => [
                'label' => 'Satuan Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus Diisi!'
                ]
            ],
            'harga_barang' => [
                'label' => 'harga Barang',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus Diisi!',
                    'numeric' => '{field} hanya menerima Angka!'
                ]
            ],
            'stok_barang' => [
                'label' => 'Stok Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus Diisi!'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar Barang',
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'errors' => [
                    'mime_in' => 'Yang diupload harus gambar!',
                    'ext_in' => 'Extensi gambar tidak sesuai (jpg,png,jpeg)'
                ]
            ]

        ]);

        if (!$rules) {
            $pesanError = [
                'errorKode' => '<div class="alert alert-danger mt-3">' . $validation->getError('kode_barang') . '</div>',
                'errorNama' => '<div class="alert alert-danger mt-3">' . $validation->getError('nama_barang') . '</div>',
                'errorKategori' => '<div class="alert alert-danger mt-3">' . $validation->getError('select_kategori') . '</div>',
                'errorSatuan' => '<div class="alert alert-danger mt-3">' . $validation->getError('select_satuan') . '</div>',
                'errorHarga' => '<div class="alert alert-danger mt-3">' . $validation->getError('harga_barang') . '</div>',
                'errorStok' => '<div class="alert alert-danger mt-3">' . $validation->getError('stok_barang') . '</div>',
                'errorGambar' =>  '<div class="alert alert-danger mt-3">' . $validation->getError('gambar') . '</div>',
            ];

            session()->setFlashdata($pesanError);
            return redirect()->back()->withInput();
        }

        $gambar = $this->request->getFile('gambar');
        if ($gambar->getError() === 0) {

            $namaFileGambar = $kodeBarang;
            $gambar->move('upload', $namaFileGambar . '.' . $gambar->getExtension());

            $pathGambar = '/upload/' . $gambar->getName();
        } else {
            $pathGambar = '';
        }

        $this->barang->insert([
            'kode_brg' => $kodeBarang,
            'nama_brg' => $namaBarang,
            'brg_katid' => $kategori,
            'brg_satid' => $satuan,
            'harga_brg' => $hargaBarang,
            'stok_brg' => $stokBarang,
            'gambar_brg' => $pathGambar
        ]);

        $pesan = [
            'success' => '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class = "fa fa-check"></i> <strong> SELAMAT!</strong> <br> Data dengan Kode <u>' . $kodeBarang . '</u> Berhasil ditambah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
        ];

        session()->setFlashdata($pesan);

        return redirect()->to(base_url('barang'))->withInput();
    }
}
