<?= $this->extend('main/layout'); ?>




<?= $this->section('content'); ?>
<div class="container-fluid">
    <table class="table table-sm">
        <tr>
            <td style="width: 20%;" class="align-middle">No.Faktur</td>
            <td style="width: 35%;"><input type="text" name="faktur" id="faktur" value="<?= $faktur; ?>" class="form-control" disabled></td>
            <td class="text-center align-middle font-weight-bold" rowspan="3" id="labelTotalHarga">TOTAL HARGA</td>
        </tr>
        <tr>
            <td class="align-middle">Tanggal Faktur </td>
            <td style="width: 35%;"><input type="text" name="tglfaktur" id="tglfaktur" value="<?= $tglfaktur; ?>" class="form-control" disabled></td>
        </tr>
        <tr>
            <td class="align-middle">Nama Pelanggan </td>
            <td style="width: 35%;"><input type="text" name="namapelanggan" id="namapelanggan" value="<?= $namapelanggan; ?>" class="form-control" disabled></td>
        </tr>
    </table>
    <hr class="border border-primary" </div>
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
                <input type="hidden" name="iddetail" id="iddetail">
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
                    <button type="button" class="btn btn-success" id="btnTambahItem"> <i class="fa fa-save"></i> Tambah Item</button>
                    <button type="button" class="btn btn-primary" id="btnEditDetail" title="Edit" style="display: none;"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-secondary" id="btnCancel" title="Refresh" style="display: none;"><i class="fa fa-sync"></i></button>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12 viewDataDetail">

        </div>
    </div>
    <div class="viewModalCariBarang" id="viewModalCariBarang">

    </div>
    <script>
        function getTotalHarga() {
            let faktur = $('#faktur').val();

            $.ajax({
                type: "post",
                url: "/barangkeluar/getTotalHarga",
                data: {
                    faktur: faktur
                },
                dataType: "json",
                success: function(response) {
                    $('#labelTotalHarga').html(response.totalharga);
                    $('#labelTotalHarga').css('font-size', '35px');
                    $('#labelTotalHarga').css('color', 'blue');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }

        function Kosongkan() {
            $('#kodeBarang').val('');
            $('#namaBarang').val('');
            $('#hargaJual').val('');
            $('#jumlah').val(1);
        }

        function viewDataDetail() {
            let faktur = $('#faktur').val();

            $.ajax({
                type: "post",
                url: "/barangkeluar/viewDataDetail",
                data: {
                    faktur: faktur
                },
                dataType: "json",
                beforeSend: function() {
                    $('.viewDataDetail').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.data) {
                        $('.viewDataDetail').html(response.data);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

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

        function simpanItem() {

            let nofaktur = $('#faktur').val();
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
                    url: "/barangkeluar/simpanItemDetail",
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
                            viewDataDetail();
                            getTotalHarga();
                            Kosongkan();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });

            }

        }

        $(document).ready(function() {
            getTotalHarga();
            viewDataDetail();

            // Menambah Item, FORM EDIT TRANSAKSI
            $('#btnTambahItem').click(function(e) {
                e.preventDefault();
                simpanItem();
            });

            $('#btnEditDetail').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/editItem",
                    data: {
                        iddetail: $('#iddetail').val(),
                        jumlah: $('#jumlah').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: response.sukses,
                                showConfirmButton: false,
                                timer: 1000
                            })
                            viewDataDetail();
                            getTotalHarga();
                            Kosongkan();
                        }
                    }
                });
            });

        });
    </script>

    <?= $this->endSection(); ?>