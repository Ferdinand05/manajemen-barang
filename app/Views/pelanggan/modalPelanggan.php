<!-- Modal -->
<div class="modal fade" id="modalDaftarPelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Daftar Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nama Pelanggan" id="modalKeyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="btnModalCari"><i class="fa fa-search"></i></button>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($pelanggan as $p) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= $p['nama']; ?></td>
                                <td><?= $p['telepon']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-secondary" onclick="pilihPelanggan('<?= $p['nama']; ?>')">Select</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="badge badge-primary p-2">
                    Total Pelanggan : <?= $totalPelanggan; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function pilihPelanggan(nama) {
        $('#namaPelanggan').val(nama);
        $('#modalDaftarPelanggan').modal('hide');
    }
</script>