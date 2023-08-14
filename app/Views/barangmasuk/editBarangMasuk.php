<?= $this->extend('main/layout'); ?>


<?= $this->section('content'); ?>

<div class="container-fluid">

    <table class="table table-sm table-striped table-hover table-bordered">
        <thead>
            <tr>
                <input type="hidden" name="" id="faktur" value="<?= $nofaktur; ?>">
                <td class="font-weight-bold">No. Faktur</td>
                <td>: <?= $nofaktur; ?></td>
                <td rowspan="2" class="text-center font-weight-bold align-middle">
                    <h4 id="totalHarga" class="font-weight-bold"></h4>
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Tanggal Faktur</td>
                <td>: <?= date('d-m-Y', strtotime($tanggal)) ?></td>
            </tr>
        </thead>
    </table>

    <div class="card">
        <div class="card-header bg-primary">
            Cari Data Barang
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="kdbarang">Kode Barang </label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="kode barang" name="kdbarang" id="kdbarang">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="btnCariBarang" name="btnCariBarang"><i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="nmbarang">Nama Barang</label>
                    <input type="text" class="form-control" name="nmbarang" id="nmbarang" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="nmbarang">Harga Jual</label>
                    <input type="text" class="form-control" name="hrgjual" id="hrgjual" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="nmbarang">Harga Beli</label>
                    <input type="number" class="form-control" name="hrgbeli" id="hrgbeli">
                </div>
                <div class="form-group col-md-1">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah">
                </div>
                <div class="form-group col-md-1">
                    <label for="" class="d-block">Aksi</label>
                    <div class="input-group">
                        <button type="submit" class="btn btn-info btn-sm" title="Tambah item" name="btnTambahItem" id="btnTambahItem">
                            <i class="fa fa-plus-square"></i>
                        </button>&nbsp;
                        <button type="submit" style="display: none;" class="btn btn-primary btn-sm" title="Edit Item" name="btnEditItem" id="btnEditItem">
                            <i class="fa fa-edit"></i>
                        </button>&nbsp;
                        <button type="submit" style="display: none;" class="btn btn-secondary btn-sm" title="Reload" name="btnReload" id="btnReload">
                            <i class="fa fa-sync-alt"></i>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
            <input type="hidden" name="iddetail" id="iddetail">
        </div>
        <div class="row" id="tampilDataDetail">
            <!-- view dataDetail + $data -->
        </div>
    </div>
    <div class="modalcaribarang" style="display: none;">

    </div>
</div>



<script>
    function dataDetail() {
        let faktur = $('#faktur').val();
        $.ajax({
            type: "post",
            url: "/barangmasuk/dataDetail",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    // table detail
                    $('#tampilDataDetail').html(response.data);
                    // total harga faktur
                    $('#totalHarga').html('Total Harga : ' + response.totalharga);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }


    function kosong() {
        $('#kdbarang').val('');
        $('#nmbarang').val('');
        $('#hrgjual').val('');
        $('#jumlah').val('');
        $('#hrgbeli').val('');
    }

    function ambilDataBarang() {
        let kodebarang = $('#kdbarang').val();

        $.ajax({
            type: "post",
            url: "/barangmasuk/ambilDataBarang",
            data: {
                kodebarang: kodebarang
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    let data = response.sukses;
                    $('#nmbarang').val(data.namabarang);
                    $('#hrgjual').val(data.hargajual);
                    $('#hrgbeli').focus();
                }

                if (response.error) {
                    alert(response.error);
                    kosong();

                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }













    // ketika halam siap
    $(document).ready(function() {
        dataDetail();

        $('#btnEditItem').click(function(e) {
            e.preventDefault();
            let faktur = $('#faktur').val();
            let kodebarang = $('#kdbarang').val();
            let hargabeli = $('#hrgbeli').val();
            let jumlah = $('#jumlah').val();
            let hargajual = $('#hrgjual').val();
            let iddetail = $('#iddetail').val();

            $.ajax({
                type: "post",
                url: "/barangmasuk/updateItem",
                data: {
                    iddetail: iddetail,
                    faktur: faktur,
                    kodebarang: kodebarang,
                    hargabeli: hargabeli,
                    hargajual: hargajual,
                    jumlah: jumlah
                },
                dataType: "json",
                success: function(response) {

                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.sukses,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        kosong();
                        dataDetail();
                    }

                }
            });


        });



        $('#btnReload').click(function(e) {
            e.preventDefault();

            $(this).hide();
            $('#btnEditItem').hide();
            $('#btnTambahItem').show();
            $('#iddetail').val('');

            kosong();
        });

        $('#btnTambahItem').click(function(e) {
            e.preventDefault();
            let faktur = $('#faktur').val();
            let kodebarang = $('#kdbarang').val();
            let hargabeli = $('#hrgbeli').val();
            let jumlah = $('#jumlah').val();
            let hargajual = $('#hrgjual').val();

            if (faktur.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Faktur tidak boleh kosong!',
                })
            } else if (kodebarang.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Kode Barang tidak boleh kosong!',
                })
            } else if (hargabeli == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harga Beli tidak boleh kosong!',
                })
            } else if (jumlah == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Jumlah tidak boleh kosong!',
                })
            } else {

                $.ajax({
                    type: "post",
                    url: "/barangmasuk/simpanDetail",
                    data: {
                        faktur: faktur,
                        kodebarang: kodebarang,
                        hargabeli: hargabeli,
                        hargajual: hargajual,
                        jumlah: jumlah

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.sukses,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            kosong();
                            dataDetail();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });

            }

        });



        $('#btnCariBarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                // type: 'post',
                url: "/barangMasuk/cariDataBarang",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.modalcaribarang').html(response.data).show();
                        $('#modalcaribarang').modal('show');

                        $('#modalcaribarang').on('shown.bs.modal', function(event) {
                            $('#cari').focus();
                        })
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