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
    <tbody id="detailBody">
        <?php
        $i = 1;
        foreach ($tampilData->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $i++; ?>
                    <input type="hidden" name="id" id="id" value="<?= $row['id']; ?>">
                </td>
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
                    url: "/barangkeluar/hapusItemDetail",
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
                            viewDataDetail();
                            getTotalHarga();
                        }
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        $('tbody#detailBody tr').hover(function() {
            $(this).css('cursor', 'pointer');
            $(this).css('background-color', 'blue');
            $(this).css('color', 'white');
        }, function() {
            $(this).css('background-color', '');
            $(this).css('color', '');
        });

        $('#detailBody').on('click', 'tr', function() {
            let row = $(this).closest('tr');

            let kodebarang = row.find('td:eq(1)').text();
            let iddetail = row.find('td input').val();
            $('#kodeBarang').val(kodebarang);
            $('#iddetail').val(iddetail);
            ambilDataBarang();

            $('#btnTambahItem').fadeOut();
            $('#btnEditDetail').fadeIn();
            $('#btnCancel').fadeIn();
            $('#kodeBarang').prop('readonly', true);
            $('#btnCariBarang').prop('disabled', true);

        });


        $('#btnCancel').click(function(e) {
            e.preventDefault();
            Kosongkan();
            $('#btnTambahItem').fadeIn();
            $('#btnEditDetail').fadeOut();
            $('#btnCancel').fadeOut();
            $('#kodeBarang').prop('readonly', false);
            $('#btnCariBarang').prop('disabled', false);
        });

    });
</script>