<?= $this->extend('main/layout'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <?= form_button('', '<i class=" fa fa-backward"></i> Kembali', [
        'class' => 'btn btn-danger mb-3',
        'onclick' => "location.href=('" . site_url('satuan') . "')"
    ]); ?>

    <?= form_open('satuan/simpanData'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                <label for="namaSatuan">Nama Satuan :</label>
                <?= form_input('namaSatuan', '', [
                    'class' => 'form-control mb-2',
                    'id' => 'namasatuan',
                    'autofocus' => true,
                    'placeholder' => 'Nama Satuan...'
                ]); ?>

                <?= session()->getFlashdata('errorNamaSatuan') ?>

            </div>
            <div class="form-group">
                <?= form_submit('', 'Simpan', [
                    'class' => 'btn btn-success',
                ]); ?>
            </div>
        </div>
    </div>
    <?= form_close(); ?>

</div>

<?= $this->endSection(); ?>