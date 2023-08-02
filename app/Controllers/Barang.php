<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use Config\Pager;

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
        $keyword = $this->request->getVar('keyword');
        // $modelBarang = $keyword ? $this->barang->cariData($keyword)->get() : $this->barang->tampilData()->get();
        $modelBarang = $keyword ? $this->barang->cariData($keyword) : $this->barang->tampilData();
        // $modelBarang = $keyword ? $this->barang->cariData($keyword) : $this->barang->tampilData();



        $nohalaman = $this->request->getVar('page_barang');
        ($nohalaman) ? $nohalaman : $nohalaman = 1;
        $data = [
            'title' => 'Manajemen Data Barang',
            'subtitle' => 'Barang',
            'content' => '',
            'barang' => $modelBarang->paginate(5, 'barang'),
            'pager' => $this->barang->pager,
            'nohalaman' => $nohalaman,
            // 'totaldata' => $totaldata,

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

            $pathGambar =  $gambar->getName();
        } else {
            $pathGambar = 'unknown.jpg';
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




    public function edit($kode)
    {
        $rowData = $this->barang->find($kode);
        $data = [
            'kodebarang' => $rowData['kode_brg'],
            'namabarang' => $rowData['nama_brg'],
            'kategori' => $rowData['brg_katid'],
            'satuan' => $rowData['brg_satid'],
            'harga' => $rowData['harga_brg'],
            'stok' => $rowData['stok_brg'],
            'gambar' => $rowData['gambar_brg'],
            'datakategori' => $this->kategori->findAll(),
            'datasatuan' => $this->satuan->findAll(),
            'title' => 'Edit Barang',
            'subtitle' => 'Form Edit Barang',
            'content' => ''
        ];


        return view('barang/formEdit', $data);
    }




    public function updateData()
    {
        $kodeBarang = $this->request->getVar('kode_barang', FILTER_SANITIZE_SPECIAL_CHARS);
        $namaBarang = $this->request->getVar('nama_barang', FILTER_SANITIZE_SPECIAL_CHARS);
        $kategori = $this->request->getVar('select_kategori');
        $satuan = $this->request->getVar('select_satuan');
        $hargaBarang = $this->request->getVar('harga_barang');
        $stokBarang = $this->request->getVar('stok_barang');


        $validation = \Config\Services::validation();

        $rules = $this->validate([
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

        $fileGambar = $this->request->getFile('gambar');
        $cekGambar = $this->barang->find($kodeBarang);
        $gambarLama = $cekGambar['gambar_brg'];
        $fileGambarLama = $this->request->getVar('gambarLama');
        // /upload/
        if ($fileGambar->getError() === 0) {

            if ($gambarLama == 'unknown.jpg') {
                $namaFileGambar = $kodeBarang;
                $fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());
                $namaGambar = $fileGambar->getName();
            } else {
                unlink('upload/' . $gambarLama);
                $namaFileGambar = $kodeBarang;
                $fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());
                $namaGambar = $fileGambar->getName();
            }
        } else {
            $namaGambar = $gambarLama;
        }


        $this->barang->update($kodeBarang, [
            'nama_brg' => $namaBarang,
            'brg_katid' => $kategori,
            'brg_satid' => $satuan,
            'harga_brg' => $hargaBarang,
            'stok_brg' => $stokBarang,
            'gambar_brg' => $namaGambar
        ]);

        $pesan = [
            'success' => '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <i class = "fa fa-check"></i> <strong> SELAMAT!</strong> <br> Data dengan Kode <u>' . $kodeBarang . '</u> Berhasil Diubah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
        ];

        session()->setFlashdata($pesan);

        return redirect()->to(base_url('barang'))->withInput();
    }

    public function delete($kode)
    {
        $cekData = $this->barang->find($kode);

        if ($cekData) {
            unlink('upload/' . $cekData['gambar_brg']);
            $this->barang->delete($kode);

            session()->setFlashdata('berhasil', 'Data Kategori Berhasil Dihapus');
            return redirect()->back()->withInput();
        } else {
            exit('Data Tidak Ditemukan');
        }
    }
}
