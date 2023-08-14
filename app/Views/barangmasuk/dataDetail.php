<div class="container-fluid">

    <table class="table table-sm table-striped table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th class="text-center">#</th>
            </tr>
        </thead>
        <tbody>


            <?php
            $i = 1;
            foreach ($dataDetail->getResultArray() as $row) :
            ?>


                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['kode_brg']; ?></td>
                    <td><?= $row['nama_brg']; ?></td>
                    <td><?= number_format($row['dethargajual'], 0, ',', '.'); ?></td>
                    <td><?= number_format($row['dethargamasuk'], 0, ',', '.'); ?></td>
                    <td><?= number_format($row['detjumlah'], 0, ',', '.'); ?></td>
                    <td><?= number_format($row['detsubtotal'], 0, ',', '.'); ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem(<?= $row['iddetail']; ?>)">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="editItem('<?= $row['iddetail']  ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script>
    function editItem(id) {
        $('#iddetail').val(id)

        $.ajax({
            type: "post",
            url: "/barangmasuk/editItem",
            data: {
                iddetail: $('#iddetail').val()
            },
            dataType: "json",
            success: function(response) {

                if (response.sukses) {
                    $('#kdbarang').val(response.sukses.kodebarang);
                    $('#nmbarang').val(response.sukses.namabarang);
                    $('#hrgjual').val(response.sukses.hargajual);
                    $('#hrgbeli').val(response.sukses.hargabeli);
                    $('#jumlah').val(response.sukses.jumlah);


                    $('#btnTambahItem').hide();
                    $('#btnEditItem').show();
                    $('#btnReload').show();

                }

            }
        });

    }



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
                    url: "/barangmasuk/hapusItemDetail",
                    data: {
                        id: id,
                        faktur: $('#faktur').val()
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
                            dataDetail();

                        }

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }
</script>