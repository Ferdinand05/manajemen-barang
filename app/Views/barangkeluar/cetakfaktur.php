<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>

    <style>
        body {
            font-family: monospace;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            #faktur {
                margin-top: 150px;
            }
        }
    </style>


</head>

<body onload="window.print()">
    <div id="faktur">


        <table border="0" cellspacing='0' cellpadding='0' width='100%'>
            <tr>
                <td colspan="2">
                    <h2 class="text-center">TOKO FERDINAND 🛍️</h2>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">📌 Jl.H.Holil No.31C, 003/005</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">📞 0896123122</td>
            </tr>
            <tr>
                <td>
                    <hr style="border: none; border:1px solid black">
                </td>
            </tr>
        </table>
        <table border="0" cellspacing='0' cellpadding='5' width='100%'>
            <tr>
                <td>Faktur</td>
                <td>: <?= $faktur; ?></td>
            </tr>
            <tr>
                <td>Tanggal Faktur</td>
                <td>: <?= date('d-m-Y', strtotime($tglfaktur)) ?></td>
            </tr>
            <tr>
                <td>Nama Pelanggan</td>
                <td>: <?= $nama; ?> </td>
            </tr>
            <tr>
                <td colspan="2"><b> Barang -></b></td>
            </tr>
            <?php
            foreach ($detailbarang->getResultArray() as $row) :
                $totalharga += $row['detsubtotal'];
            ?>
                <tr>
                    <td><?= $row['nama_brg'] . '(' . $row['detjumlah'] . ')' ?></td>
                    <td>: <?= number_format($row['detsubtotal'], 0, ',', '.'); ?></td>
                </tr>


            <?php
            endforeach; ?>
            <tr>
                <td class="text-right">Total Harga</td>
                <td>: <?= number_format($totalharga, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td class="text-right">Uang</td>
                <td>: <?= number_format($jumlahuang, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td class="text-right">Sisa Uang </td>
                <td>: <?= number_format($jumlahuang - $totalharga, 0, ',', '.')  ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr style="border: none; border:1px dashed black">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    Terima Kasih ❤️
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <?= date("Y-m-d H:i:s") ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <hr style="border: none; border:1px solid black">
                </td>
            </tr>
        </table>
    </div>
</body>

</html>