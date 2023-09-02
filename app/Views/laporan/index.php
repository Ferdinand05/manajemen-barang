<?= $this->extend('main/layout'); ?>


<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">

            <a href="/laporan/cetak_barang_masuk" class="btn btn-warning p-5 btn-block font-weight-bold">Laporan Barang Masuk</a>
        </div>
        <div class="col-md-6">

            <a href="/laporan/cetak_barang_keluar" class="btn btn-success p-5 btn-block font-weight-bold">Laporan Barang Keluar</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>