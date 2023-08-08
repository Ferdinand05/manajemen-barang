<?= $this->extend('main/layout'); ?>




<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="faktur">Input Faktur Barang Masuk</label>
            <input type="text" class="form-control" placeholder="Nomor faktur" name="faktur" id="faktur">
        </div>
        <div class="form-group col-md">
            <label for="tglfaktur">Tanggal Faktur</label>
            <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" name="tglfaktur" id="tglfaktur">
        </div>
    </div>

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
                            <button class="btn btn-primary" type="button" id="btnCariBarang" name="btnCariBarang"><i class="fa fa-search"></i></button>
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
                        <button type="submit" class="btn btn-warning btn-sm" title="Reload" name="btnReload" id="btnReload">
                            <i class="fa fa-sync"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row" id="tampilDataTemp"></div>

    <div class="row justify-content-end">
        <button type="button" class="btn btn-lg btn-success" id="tombolSelesaiTransaksi">
            <i class="fa fa-save"></i>Selesai Transaksi
        </button>
    </div>

    <div class="modalcaribarang" style="display: none;">

    </div>

</div>


<script>
    function hapusItem(id) {
        Swal.fire({
            title: 'Hapus Item',
            text: "Apakah anda yakin ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangmasuk/hapus",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {

                        if (response.sukses) {
                            dataTemp();

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.sukses,
                                showConfirmButton: false,
                                timer: 1500
                            })

                        }

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
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

    function dataTemp() {
        let faktur = $('#faktur').val();
        $.ajax({
            type: "post",
            url: "/barangmasuk/dataTemp",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {

                    $('#tampilDataTemp').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataTemp();

        $('#kdbarang').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();

                ambilDataBarang();

            }
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
                    url: "/barangmasuk/simpanTemp",
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
                            alert(response.sukses);
                            kosong();
                            dataTemp();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });

            }

        });

        $('#btnReload').click(function(e) {
            e.preventDefault();
            dataTemp();
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

        $('#tombolSelesaiTransaksi').click(function(e) {
            e.preventDefault();

            let faktur = $('#faktur').val();
            if (faktur.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Faktur tidak boleh kosong!'
                });
            } else {
                swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Transaksi akan diselesaikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Simpan'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: "post",
                            url: "/barangmasuk/selesaiTransaksi",
                            data: {
                                faktur: faktur,
                                tglfaktur: $('#tglfaktur').val()
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.error,
                                    });
                                } else if (response.sukses) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: response.sukses,
                                        showConfirmButton: true,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })
                                }

                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + '\n' + thrownError);
                            }
                        });

                    }
                })
            }

        });

    });
</script>

<?= $this->endSection(); ?>