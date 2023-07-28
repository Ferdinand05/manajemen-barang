<?= $this->extend('main/layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <?= session()->getFlashdata('success'); ?>

    <table class="table table-stripped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 3%;">No.</th>
                <th scope="col">Gambar</th>
                <th scope="col" style="width: 10%;">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Kategori</th>
                <th scope="col" style="width:3%">Satuan</th>
                <th scope="col">Stok</th>
                <th scope="col">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?= form_button('', '<i class="fa fa-plus"></i> Tambah Barang', [
                'class' => 'btn btn-primary mb-3',
                'onclick' => "location.href=('" . site_url('barang/formTambah') . "')"
            ]); ?>

            <?php

            $i = 1;
            foreach ($barang as $row) :
            ?>
                <tr>
                    <th scope="row"><?= $i; ?></th>
                    <td><img src="<?= $row['gambar_brg']; ?>" alt="<?= $row['nama_brg']; ?>" width="55px" class="img-fluid"></td>
                    <td class="align-middle"><?= $row['kode_brg'] ?></td>
                    <td class="align-middle"><?= $row['nama_brg'] ?></td>
                    <td class="align-middle"><?= $row['kat_nama']; ?></td>
                    <td class="align-middle"><?= $row['sat_nama']; ?></td>
                    <td class="align-middle"><?= $row['stok_brg']; ?></td>
                    <td class="align-middle"><?= number_format($row['harga_brg'], 0, ',', '.'); ?></td>
                    <td class="text-center align-middle">
                        <a href="" class="btn btn-primary" title="Edit Data">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="" class="btn btn-danger" title="Hapus Data">
                            <i class="fa fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php
                $i++;
            endforeach;
            ?>

        </tbody>
    </table>
</div>







<?= $this->endSection(); ?>