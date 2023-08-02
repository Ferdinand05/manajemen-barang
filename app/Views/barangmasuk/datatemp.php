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
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($dataTemp->getResultArray() as $row) :
        ?>

            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['kode_brg']; ?></td>
                <td><?= $row['nama_brg']; ?></td>
                <td style="text-align: right;"><?= number_format($row['dethargajual'], 0, ',', '.'); ?></td>
                <td style="text-align: right;"><?= number_format($row['dethargamasuk'], 0, ',', '.'); ?></td>
                <td style="text-align: right;"><?= number_format($row['detjumlah'], 0, ',', '.'); ?></td>
                <td style="text-align: right;"><?= number_format($row['detsubtotal'], 0, ',', '.'); ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem(<?= $row['iddetail']; ?>)">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>