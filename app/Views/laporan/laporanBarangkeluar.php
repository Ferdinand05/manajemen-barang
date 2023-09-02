<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="header text-center border-bottom border-2 mb-5">
            <h3>TOKO FERDINAND 🛍️</h3>
            <h5>Laporan Barang Keluar</h5>
            <p>Periode : <?= $tglawal . '-' .  $tglakhir ?></p>
        </div>
        <div class="body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Faktur</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $totalFull = 0;
                    foreach ($dataLaporan as $row) :
                        $totalFull += $row['totalharga'];
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row['faktur']; ?></td>
                            <td><?= $row['tglfaktur']; ?></td>
                            <td><?= number_format($row['totalharga'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">Total Keseluruhan Harga</th>
                        <th class="text-center"> <?= number_format($totalFull, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>