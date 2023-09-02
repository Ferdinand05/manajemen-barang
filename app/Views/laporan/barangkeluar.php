<?= $this->extend('main/layout'); ?>


<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Pilih Periode</div>
                <div class="card-body bg-white">
                    <?= form_open('laporan/cetakBarangkeluarPeriode', ['target' => '_blank']); ?>
                    <div class="form-group mb-2">
                        <label for="tglawal">Tanggal Awal</label>
                        <input type="date" class="form-control mb-2" required id="tglAwal" name="tglAwalBarangkeluar">

                        <label for="tglakhir">Tanggal Akhir</label>
                        <input type="date" class="form-control mb-2" required id="tglAkhir" name="tglAkhirBarangkeluar">

                        <button type="submit" class="btn btn-success btn-block mb-2" id="btnPeriode">
                            <i class="fa fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                    <?= form_close(); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label for="bulan">Tahun & Bulan Grafik</label>
                    <div class="form-group">
                        <input type="date" name="bulan" id="bulan" class="form-control">
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">

            <div class="card bg-light mb-3">
                <div class="card-header">Grafik Barang Keluar</div>
                <div class="card-body viewGrafik">

                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function showGrafikBarangkeluar(bulan = "2023-08") {
        $.ajax({
            type: "post",
            url: "/laporan/showGrafikBarangkeluar",
            data: {
                bulan: bulan
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewGrafik').html("<i class='fa fa-spin fa-spinner'></i>");
            },
            success: function(response) {
                if (response.data) {
                    $('.viewGrafik').html(response.data);

                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        showGrafikBarangkeluar();


        $('#bulan').change(function(e) {
            e.preventDefault();
            let bulan = $('#bulan').val();
            let tahunBulan = bulan.substr(0, 7);

            showGrafikBarangkeluar(tahunBulan);
        });



    });
</script>

<?= $this->endSection() ?>