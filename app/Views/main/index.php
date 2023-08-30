<?= $this->extend('main/layout'); ?>




<?= $this->section('content'); ?>

<div class="container p-3">

    <div class="card-deck justify-content-center">
        <a href="<?= base_url('barang') ?>" class="card text-white bg-primary mb-3" style="max-width: 15rem; min-width:15rem">
            <div class="card-header ">
                <h4 class="font-weight-bold">Barang </h4>
            </div>
            <div class="card-body text-center m-0 p-0 pt-2">
                <h5>Jumlah Barang</h5>
                <p class="card-text ">
                <h5 class="font-weight-bold"><?= $barang; ?></h5>
                </p>
            </div>
        </a>

        <a href="<?= base_url('kategori') ?>" class="card text-white bg-success mb-3" style="max-width: 15rem; min-width:15rem">
            <div class="card-header">
                <h4 class="font-weight-bold">Kategori</h4>
            </div>
            <div class="card-body text-center m-0 p-0 pt-2">
                <h5>Jumlah Kategori</h5>
                <p class="card-text">
                <h5 class="font-weight-bold"><?= $kategori; ?></h5>
                </p>
            </div>
        </a>
        <a href="<?= base_url('barangmasuk') ?>" class="card text-white bg-danger mb-3" style="max-width: 15rem; min-width:15rem">
            <div class="card-header">
                <h4 class="font-weight-bold">Barang Masuk</h4>
            </div>
            <div class="card-body text-center m-0 p-0 pt-2">
                <h5>Jumlah Barang Masuk</h5>
                <p class="card-text">
                <h5 class="font-weight-bold"><?= $barangmasuk; ?></h5>
                </p>
            </div>
        </a>
        <a href="<?= base_url('barangkeluar/data') ?>" class="card text-white bg-secondary mb-3" style="max-width: 15rem; min-width:15rem">
            <div class="card-header">
                <h4 class="font-weight-bold"> Barang Keluar </h4>
            </div>
            <div class="card-body text-center m-0 p-0 pt-2">
                <h5>Jumlah Barang Keluar</h5>
                <p class="card-text">
                <h5 class="font-weight-bold"><?= $barangkeluar; ?></h5>
                </p>
            </div>
        </a>
    </div>


</div>




<?= $this->endSection(); ?>