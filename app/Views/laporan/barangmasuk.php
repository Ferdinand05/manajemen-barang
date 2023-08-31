<?= $this->extend('main/layout'); ?>


<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Pilih Periode</div>
                <div class="card-body bg-white">

                    <?= form_open('laporan/cetakBarangmasukPeriode', ['target' => '_blank']); ?>
                    <div class="form-group mb-2">
                        <label for="tglawal">Tanggal Awal</label>
                        <input type="date" class="form-control mb-2" required id="tglAwal" name="tglAwal">

                        <label for="tglakhir">Tanggal Akhir</label>
                        <input type="date" class="form-control mb-2" required id="tglAkhir" name="tglAkhir">

                        <button type="submit" class="btn btn-success btn-block mb-2" id="btnPeriode">
                            <i class="fa fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                    <?= form_close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>