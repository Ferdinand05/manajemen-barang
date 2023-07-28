<?= $this->extend('main/layout'); ?>

<?= $this->section('content'); ?>
<div class="container">

    <?php if (session()->has('berhasil')) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Selamat!</strong> <?= session('berhasil') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <?= form_open('satuan') ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Caari sesuatu..." aria-describedby="button-addon2" name="keyword">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2" name="search">Button</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>


    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Satuan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?= form_button('', '<i class=" fa fa-plus"></i> Tambah Data', [
                'class' => 'btn btn-primary mb-3',
                'onclick' => "location.href=('" . site_url('satuan/formTambah') . "')"
            ]); ?>
            <?php
            $i = 1 + ($nohalaman - 1) * 5;
            foreach ($satuan as $row) :
            ?>
                <tr>
                    <th scope="row" style="width: 10%;"><?= $i; ?></th>
                    <td><?= $row["sat_nama"]; ?></td>
                    <td style="width: 20%;">
                        <button type="button" class="btn btn-info mb-2" title="Edit Data" onclick="edit('<?= $row['sat_id']; ?>');">
                            <i class="fa fa-edit"></i>
                        </button>
                        <form action="/satuan/hapus/<?= $row['sat_id']; ?>" method="POST" style="display: inline;" onclick="return confirm('Apakah yakin ingin menghapus?');">
                            <input type="hidden" value="DELETE" name="_method">

                            <button type="submit" class="btn btn-danger mb-2" title="Hapus Data">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
    <?= $pager->links('satuan', 'page_gudang') ?>
</div>

<script>
    function edit(id) {
        window.location = ('/satuan/formEdit/' + id);
    }
</script>

<?= $this->endSection(); ?>