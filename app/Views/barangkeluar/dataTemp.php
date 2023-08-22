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
                <td><?= $row['dethargajual']; ?></td>
                <td><?= $row['detjumlah']; ?></td>
                <td><?= $row['detsubtotal']; ?></td>
                <td><?= "aksi" ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>