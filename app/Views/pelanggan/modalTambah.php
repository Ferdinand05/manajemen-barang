<!-- Modal -->
<div class="modal  fade" id="modalTambahPelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?= form_open('pelanggan/simpan', ['class' => 'formOpen']) ?>
                <div class="form-group mb-3">
                    <label for="namaPelanggan">Nama Pelanggan </label>
                    <input type="text" class="form-control" name="namaPelanggan" id="namaPelangganModal" placeholder="Nama Pelanggan">
                    <div class="invalid-feedback errorNamaPelanggan">

                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="telp">No. HP/Telp</label>
                    <input type="text" class="form-control" name="telp" id="telp" placeholder="HP/Telp">
                    <div class="invalid-feedback errorTelp">

                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-block btn-success" id="btnSimpanPelanggan">Simpan</button>
                </div>
                <?= form_close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('.formOpen').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $('.formOpen').attr('action'),
                data: $('.formOpen').serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#btnSimpanPelanggan').prop('disabled', true);
                    $('#btnSimpanPelanggan').html('<i class="fa fa-spinner fa-pulse fa-lg"></i>');
                },
                complete: function() {
                    $('#btnSimpanPelanggan').prop('disabled', false);
                    $('#btnSimpanPelanggan').html('Simpan');
                },
                success: function(response) {

                    if (response.error) {
                        let e = response.error;

                        if (e.errorNamaPelanggan) {
                            $('#namaPelangganModal').addClass('is-invalid');
                            $('.errorNamaPelanggan').html(e.errorNamaPelanggan);
                        }

                        if (e.errorTelp) {
                            $('#telp').addClass('is-invalid');
                            $('.errorTelp').html(e.errorTelp);
                        }

                    }

                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.sukses,
                            showConfirmButton: false,
                            timer: 1000
                        })

                        if (response.data) {
                            let data = response.data;
                            $('#namaPelanggan').val(data.namaPelanggan);
                            $('#idPelanggan').val(data.idPelanggan);

                            $('#modalTambahPelanggan').modal('hide');
                        }

                    }

                }
            });


            return false;
        });












    });
</script>