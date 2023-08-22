<?= $this->extend('main/layout'); ?>



<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="nofaktur">No. Faktur </label>
                <input type="text" name="nofaktur" id="nofaktur" class="form-control" value="<?= $nofaktur; ?>" readonly>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="nofaktur">Tanggal Faktur </label>
                <input type="date" name="tglfaktur" id="tglfaktur" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="pelanggan">Cari Pelanggan </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nama Pelanggan" id="namaPelanggan" readonly>
                    <input type="hidden" name="idPelanggan" id="idPelanggan">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" name="btnCariPelanggan" id="btnCariPelanggan" title="Cari Pelanggan"><i class="fa fa-search"></i></button>
                        <button class="btn btn-outline-primary" type="button" name="btnTambahPelanggan" id="btnTambahPelanggan" title="Tambahkan Pelanggan"><i class="fa fa-user-plus"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label for="kodeBarang">Kode Barang</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Kode Barang" name="kodeBarang" id="kodeBarang">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" id="btnCariBarang" name="btnCariBarang"><i class="fa fa-search-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="namaBarang">Nama Barang</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" placeholder="Nama Barang" id="namaBarang" name="namaBarang" readonly>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="hargaJual">Harga Jual (Rp)</label>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" placeholder="Harga Jual" id="hargaJual" name="hargaJual" readonly>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="jumlah">Quantity</label>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" placeholder="Jumlah" id="jumlah" name="jumlah" value="1">
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="jumlah">#</label>
                <div class="input-group mb-2">
                    <button type="button" class="btn btn-success" title="simpan item" id="btnSimpan"><i class="fa fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 viewDataTemp">

        </div>
    </div>
    <div class="viewDaftarPelanggan" id="viewModalPelanggan">

    </div>

    <div class="viewModalPelanggan" id="modalPelanggan">

    </div>


</div>


<script>
    function viewDataTemp() {
        let faktur = $('#nofaktur').val();

        $.ajax({
            type: "post",
            url: "/barangkeluar/viewDataTemp",
            data: {
                nofaktur: faktur
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewDataTemp').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.viewDataTemp').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    }


    function buatNoFaktur() {
        let tanggal = $('#tglfaktur').val();

        $.ajax({
            type: "post",
            url: "/barangkeluar/buatNoFaktur",
            data: {
                tanggal: tanggal
            },
            dataType: "json",
            success: function(response) {
                $('#nofaktur').val(response.nofaktur);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    }


    $(document).ready(function() {

        viewDataTemp();


        $('#tglfaktur').change(function(e) {
            e.preventDefault();
            buatNoFaktur();
            viewDataTemp();
        });

        $('#btnTambahPelanggan').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "/pelanggan/formTambah",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewModalPelanggan').html(response.data);
                        $('#modalTambahPelanggan').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

        });


        $('#btnCariPelanggan').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "/pelanggan/daftarPelanggan",
                dataType: "json",
                success: function(response) {

                    if (response.data) {
                        $('.viewDaftarPelanggan').html(response.data);
                        $('#modalDaftarPelanggan').modal('show');
                    }

                }
            });

        });










    });
</script>









<?= $this->endSection(); ?>