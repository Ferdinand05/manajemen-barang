<?= $this->extend('main/layout'); ?>

<?= $this->section('content');  ?>

<div class="container">
    <?= form_button('', '<i class=" fa fa-backward"></i> Kembali', [
        'class' => 'btn btn-danger mb-3',
        'onclick' => "location.href=('" . site_url('kategori') . "')"
    ]); ?>

    <?= form_open('kategori/updateData', '', [
        'idKategori' => $id
    ]); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                <label for="namakategori">Nama Kategori :</label>
                <?= form_input('namaKategori', $nama, [
                    'class' => 'form-control mb-2',
                    'id' => 'namakategori',
                    'autofocus' => true,
                    'placeholder' => 'Nama kategori...'
                ]); ?>

                <?= session()->getFlashdata('errorNamaKategori') ?>

            </div>
            <div class="form-group">
                <?= form_submit('', 'Update', [
                    'class' => 'btn btn-success',
                ]); ?>
            </div>
        </div>
    </div>
    <?= form_close(); ?>

</div>

<?= $this->endSection();  ?>