<table class="table table-sm table-stripped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>

            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['kode_brg']; ?></td>
                <td><?= $row['nama_brg']; ?></td>
                <td><?= $row["harga_brg"]; ?></td>
                <td><?= $row['stok_brg']; ?></td>
                <td>
                    <button type="button" class="btn-sm btn-info" onclick="pilih('<?= $row['kode_brg']; ?>')">
                        Pilih
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function pilih(kode) {
        $('#kdbarang').val(kode);
        $('#modalcaribarang').modal('hide');
        $('#modalcaribarang').on('hidden.bs.modal', function(event) {
            ambilDataBarang();
        })

    }
</script>