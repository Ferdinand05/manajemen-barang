<?= $this->extend('main/layout'); ?>



<?= $this->section('content'); ?>

<div class="container-fluid">
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
        <div class="col-lg">
            <div class="form-group">
                <label for="jumlah">Quantity</label>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" placeholder="Jumlah" id="jumlah" name="jumlah" value="1">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="jumlah">Aksi</label>
                <div class="input-group mb-2 btn-group">
                    <button type="button" class="btn btn-success" title="simpan item" id="btnSimpan"> <i class="fa fa-save"></i> Simpan </button>
                    <button type="button" class="btn btn-primary " title="selesai transaksi" id="btnSelesaiTransaksi"> <i class="fas fa-hand-holding-usd"></i> Selesai Transaksi </button>
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

    <div class="viewModalCariBarang" id="viewModalCariBarang">

    </div>


</div>


<script>
    function simpanItem() {

        let nofaktur = $('#nofaktur').val();
        let kodebarang = $('#kodeBarang').val();
        let namabarang = $('#namaBarang').val();
        let jumlah = $('#jumlah').val();
        let hargajual = $('#hargaJual').val();

        if (kodebarang.length == 0) {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Kode Barang Tidak Boleh  Kosong!',
            });
            Kosongkan();
        } else {

            $.ajax({
                type: "post",
                url: "/barangkeluar/simpanItem",
                data: {
                    nofaktur: nofaktur,
                    kodebarang: kodebarang,
                    namabarang: namabarang,
                    jumlah: jumlah,
                    hargajual: hargajual
                },
                dataType: "json",
                success: function(response) {

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.error,
                        });
                        Kosongkan();
                    }

                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.sukses,
                            showConfirmButton: false,
                            timer: 1000
                        })
                        viewDataTemp();
                        Kosongkan();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

        }

    }

    function Kosongkan() {
        $('#kodeBarang').val('');
        $('#namaBarang').val('');
        $('#hargaJual').val('');
        $('#jumlah').val(1);
    }

    function ambilDataBarang() {

        let kodebarang = $('#kodeBarang').val();
        if (kodebarang.length == 0) {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Kode Barang Kosong!',
            });
            Kosongkan();
        } else {
            $.ajax({
                type: "post",
                url: "/barangkeluar/ambilDataBarang",
                data: {

                    kodebarang: kodebarang,
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.error,
                        });
                        Kosongkan();
                    }


                    if (response.sukses) {
                        let data = response.sukses;
                        $('#namaBarang').val(data.namabarang);
                        $('#hargaJual').val(data.hargajual);
                        $('#jumlah').focus();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    }

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
                viewDataTemp();
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

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

        });


        $('#kodeBarang').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                ambilDataBarang();
            }
        });


        $('#btnSimpan').click(function(e) {
            e.preventDefault();

            simpanItem();
        });



        $('#btnCariBarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/barangkeluar/modalCariBarang",
                dataType: "json",
                success: function(response) {
                    if (response.data) {

                        $('#viewModalCariBarang').html(response.data);
                        $('#modalCariBarang').modal('show');

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });



        $('#btnSelesaiTransaksi').click(function(e) {
            e.preventDefault();

            let nofaktur = $('#nofaktur').val();
            let tglfaktur = $('#tglfaktur').val();
            let idpelanggan = $('#idPelanggan').val();
            let totalharga = $('#totalHarga').val();

            $.ajax({
                type: "post",
                url: "/barangkeluar/modalPembayaran",
                data: {
                    nofaktur: nofaktur,
                    tglfaktur: tglfaktur,
                    idpelanggan: idpelanggan,
                    totalharga: totalharga
                },
                dataType: "json",
                success: function(response) {

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.error,
                        })
                    }

                    if (response.data) {
                        $('.viewModalPelanggan').html(response.data);
                        $('#modalPembayaran').modal('show');
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });


        });















    });
</script>









<?= $this->endSection(); ?>