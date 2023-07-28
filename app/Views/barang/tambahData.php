<?= $this->extend('main/layout'); ?>

<?= $this->section('content'); ?>

<div class="container">

    <?= form_button('', '<i class="fa fa-backward" ></i> Kembali', [
        'class' => 'btn btn-danger mb-3',
        'onclick' => 'location.href=("' . site_url('barang') . '")'
    ]) ?>

    <div class="row">
        <div class="col">
            <?= form_open_multipart('barang/simpanData') ?>
            <div class="form-group">
                <div class="col-md-8">
                    <label for="kodebarang" class="">Kode Barang </label>
                    <input type="text" id="kodebarang" autofocus class="form-control" name="kode_barang" placeholder="Kode barang..." value="<?= old('kode_barang') ?>">
                    <?= session('errorKode') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <label for="namabarang" class="">Nama Barang </label>
                    <input type="text" id="namabarang" autofocus class="form-control" name="nama_barang" placeholder="Nama barang..." value="<?= old('nama_barang') ?>">
                    <?= session('errorNama') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <label for="kategori" class="">Kategori </label>
                    <select class="form-control custom-select" name="select_kategori" id="kategori">
                        <option value="" disabled selected class="text-center">=Pilih Kategori=</option>

                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k['kat_id']; ?>"><?= $k['kat_nama']; ?></option>
                        <?php endforeach; ?>

                    </select>
                    <?= session('errorKategori') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <label for="satuan" class="">Satuan </label>
                    <select class="form-control custom-select" name="select_satuan" id="satuan">
                        <option value="" disabled selected class="text-center">=Pilih Satuan=</option>

                        <?php foreach ($satuan as $s) : ?>
                            <option value="<?= $s['sat_id']; ?>"><?= $s['sat_nama']; ?></option>
                        <?php endforeach; ?>

                    </select>
                    <?= session('errorSatuan') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga_barang" id="harga" placeholder="Harga barang...">
                    <?= session('errorHarga') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok_barang" id="stok" placeholder="Stok barang...">
                    <?= session('errorStok') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-5">
                    <label for="gambar">Gambar (<i>Optional</i>)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih Gambar</label>

                        <?php if (session()->has('errorGambar')) : ?>
                            <?= session('errorGambar') ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md">
                    <button type="submit" name="submit" class="btn btn-success">Kirim</button>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>