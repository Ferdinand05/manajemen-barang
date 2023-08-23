<hr class="border border-primary">
<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jumlah</th>
            <th>Sub.Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($tampilData->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['kode_brg']; ?></td>
                <td><?= $row['nama_brg']; ?></td>
                <td><?= number_format($row['dethargajual'], 0, ',', '.');   ?></td>
                <td><?= $row['detjumlah']; ?></td>
                <td><?= number_format($row['detsubtotal'], 0, ',', '.'); ?></td>
                <td class=" text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['id'] ?>','<?= $row['nama_brg'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>


        <?php
        $totalharga = 0;
        foreach ($tampilData->getResultArray() as $r) {
            $totalharga += $r['detsubtotal'];
        }
        ?>
        <tr>
            <td colspan="5" class="text-right">
                <h5>Total Harga </h5>
            </td>
            <td colspan="2" class="text-center">
                <h5><?= number_format($totalharga, 0, ',', '.') ?></h5>
            </td>
        </tr>

    </tbody>
</table>


<script>
    function hapusItem(id, nama) {
        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Anda Akan Menghapus Item : " + nama,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/hapusItem",
                    data: {
                        id: id
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
                            viewDataTemp();
                        }
                    }
                });
            }
        })
    }
</script>