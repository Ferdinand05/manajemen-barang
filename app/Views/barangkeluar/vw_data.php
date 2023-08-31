<?= $this->extend('main/layout'); ?>



<?= $this->section('content'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="row p-2">
    <div class="col-md-2">
        <label for="">Filter Data</label>
    </div>
    <div class="col">
        <input type="date" name="tanggalAwal" id="tanggalAwal" class="form-control">
    </div>
    <div class="col">
        <input type="date" name="tanggalAkhir" id="tanggalAkhir" class="form-control">
    </div>
    <div class="col">
        <button class="btn btn-primary" id="btnFilter">Tampilkan</button>
    </div>
</div>

<table id="dataBarangkeluar" class="table table-bordered table-hover dataTable dtr-inline collapsed" style="width: 100%;">
    <thead class="bg-dark">
        <tr>
            <td>No.</td>
            <td>Faktur</td>
            <td>Tanggal</td>
            <td>Nama</td>
            <td>Total Harga</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script>
    function listDataBarangkeluar() {

        var table = $('#dataBarangkeluar').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/barangkeluar/listData",
                "type": "POST",
                "data": {
                    tglawal: $('#tanggalAwal').val(),
                    tglakhir: $('#tanggalAkhir').val()
                }
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }, ],
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        })
    }

    function cetakFaktur(faktur) {
        // window.location.href = ('/barangkeluar/cetakfaktur/') + faktur;
        let openWindow = window.open('/barangkeluar/cetakfaktur/' + faktur, 'Cetak Faktur Barang keluar', 'width=700,height=500');
        openWindow.focus();
    }

    function hapusFaktur(faktur) {
        Swal.fire({
            title: 'Apakah anda Yakin ?',
            text: "Anda akan menghapus No Faktur :" + faktur,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/hapusTransaksi",
                    data: {
                        faktur: faktur
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.sukses,
                                showConfirmButton: false,
                                timer: 1200
                            })
                            listDataBarangkeluar();
                        }
                    }
                });
            }
        })
    }

    function editFaktur(faktur) {

        window.location.href = ('/barangkeluar/edit/' + faktur);

    }


    $(document).ready(function() {


        listDataBarangkeluar();


        $('#btnFilter').click(function(e) {
            listDataBarangkeluar();
        });



    });
</script>

<?= $this->endSection(); ?>