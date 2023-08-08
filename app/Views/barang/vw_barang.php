<?= $this->extend('main/layout'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">

    <?= session()->getFlashdata('success'); ?>


    <div class="row">
        <div class="col-md-7">
            <?= form_open('barang') ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari sesuatu..." aria-describedby="button-addon2" name="keyword">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2" name="search">Cari</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>



    <table class="table table-stripped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 3%;">No.</th>
                <th scope="col">Gambar</th>
                <th scope="col" style="width: 10%;">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Kategori</th>
                <th scope="col">Stok</th>
                <th scope="col" style="width:3%">Satuan</th>
                <th scope="col">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>


            <?= form_button('', '<i class="fa fa-plus"></i> Tambah Barang', [
                'class' => 'btn btn-primary mb-3',
                'onclick' => "location.href=('" . site_url('barang/formTambah') . "')"
            ]); ?>


            <br>
            <h5 class="badge badge-info p-1"> Hasil Pencarian : <?= $totaldata ?></h5>

            <?php
            $i = 1 + ($nohalaman - 1) * 5;
            foreach ($barang as $row) :
            ?>
                <tr>
                    <th scope="row"><?= $i; ?></th>
                    <td style="width:80px;" class="p-2"><img src="/upload/<?= $row['gambar_brg']; ?>" alt="<?= $row['nama_brg']; ?>" width="100%" class="img-fluid"></td>
                    <td class="align-middle"><?= strtoupper($row['kode_brg']); ?></td>
                    <td class="align-middle"><?= strtoupper($row['nama_brg']); ?></td>
                    <td class="align-middle"><?= ucfirst($row['kat_nama']); ?></td>
                    <td class="align-middle"><?= $row['stok_brg']; ?></td>
                    <td class="align-middle"><?= ucfirst($row['sat_nama']); ?></td>
                    <td class="align-middle"><?= number_format($row['harga_brg'], 0, ',', '.'); ?></td>
                    <td class="text-center align-middle">

                        <form action="/barang/edit/<?= $row['kode_brg']; ?>" method="post" class="d-inline">
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-primary" title="Edit Data">
                                <i class="fa fa-edit"></i>
                            </button>
                        </form>

                        <form action="/barang/delete/<?= $row['kode_brg']; ?>" method="post" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">

                            <button type="submit" class="btn btn-danger" title="Hapus Data" onclick="return confirm('Apakah anda yakin ingin menghapus, <?= $row['nama_brg']; ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
                $i++;
            endforeach;
            ?>

        </tbody>
    </table>
    <?= $pager->links('barang', 'page_gudang'); ?>
</div>


<script>

</script>




<?= $this->endSection(); ?>