<?= $this->extend('main/layout'); ?>



<?= $this->section('content') ?>

<div class="container-fluid">
    <a href="/barangmasuk" class="btn btn-primary mb-2">Input Barang Masuk <i class="fa fa-plus"></i></a>

    <div class="row">
        <div class="col-md-7">
            <?= form_open('barangmasuk/data') ?>
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Cari sesuatu..." aria-describedby="button-addon2" name="keyword" autofocus>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2" name="search">Cari</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
    <div class="badge badge-primary mb-1">
        Hasil Pencarian : <?= $totaldata; ?>
    </div>

    <table class="table table-sm table-bordered table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Faktur</th>
                <th>Tanggal</th>
                <th>Jumlah Item</th>
                <th>Total Harga</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>

            <?php



            $db = \Config\Database::connect();
            $i = 1 + ($nohalaman - 1) * 3;
            foreach ($barangmasuk as $row) : ?>
                <tr>
                    <td style="width: 5%;"><?= $i++; ?></td>
                    <td><?= $row['faktur']; ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tglfaktur'])); ?></td>
                    <td class="text-center" style="width: 10%;">
                        <?php
                        $jumlahitem = $db->table('detail_barangmasuk')->where('detfaktur', $row['faktur'])->countAllResults();
                        ?>
                        <span style="cursor: pointer;" class="btn btn-info btn-sm" onclick="detailItem('<?= $row['faktur'] ?>')"><?= $jumlahitem; ?></span>
                    </td>
                    <td><?= number_format($row['totalharga'], 0, ',', '.'); ?></td>
                    <td>
                    </td>
                </tr>


            <?php endforeach; ?>

        </tbody>
    </table>

    <?= $pager->links('barangmasuk', 'page_gudang'); ?>

</div>

<div class="viewmodal" id="viewmodal" style="display: none;">

</div>

<script>
    function detailItem(faktur) {
        $.ajax({
            type: "post",
            url: "/barangmasuk/detailItem",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(response) {

                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalitem').modal('show');
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
</script>


<?= $this->endSection(); ?>