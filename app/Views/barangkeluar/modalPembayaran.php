<!-- Modal -->
<div class="modal fade" id="modalPembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('barangkeluar/simpanPembayaran', ['class' => 'formPembayaran', 'id' => 'formPembayaran']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">No. Faktur</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-qrcode"></i></span>
                        </div>
                        <input type="text" class="form-control" disabled value="<?= $nofaktur; ?>" name="fakturPembayaran" id="fakturPembayaran">

                        <input type="hidden" id="tglFaktur" value="<?= $tglfaktur; ?>" name="tglFaktur">
                        <input type="hidden" id="idPelanggan" value="<?= $idpelanggan; ?>" name="idPelanggan">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Harga</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                        <input type="text" class="form-control" disabled value="<?= $totalharga; ?>" id="totalBayar" name="totalBayar">
                    </div>
                </div>
                <hr class="border-secondary">
                <div class="form-group">
                    <label for="">Pembayaran</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Jumlah Uang Anda" id="uang" name="uang">

                    </div>
                    <label for="">Sisa</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                        </div>
                        <input type="text" class="form-control" disabled id="sisaUang" placeholder="Sisa Uang Anda" name="sisaUang">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSimpanPembayaran">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>
<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>

<script>
    $(document).ready(function() {

        $('#uang').autoNumeric('init', {
            aSign: 'Rp. ',
            mDec: '0',
            aDec: ',',
            aSep: '.'
        });
        $('#totalBayar').autoNumeric('init', {
            aSign: 'Rp. ',
            mDec: '0',
            aDec: ',',
            aSep: '.'
        });
        $('#sisaUang').autoNumeric('init', {
            aSign: 'Rp. ',
            mDec: '0',
            aDec: ',',
            aSep: '.'
        });


        $('#uang').keyup(function(e) {

            let totalharga = $('#totalBayar').autoNumeric('get');
            let jumlahUang = $('#uang').autoNumeric('get');

            if (parseInt(jumlahUang) <= parseInt(totalharga)) {
                let sisaUang = 0;
                $('#sisaUang').autoNumeric('set', sisaUang);
            } else {
                let sisaUang = parseInt(jumlahUang) - parseInt(totalharga);
                $('#sisaUang').autoNumeric('set', sisaUang);
            }

        });


        $('.formPembayaran').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $('.formPembayaran').attr('action'),
                data: {
                    fakturPembayaran: $('#fakturPembayaran').val(),
                    idPelanggan: $('#idPelanggan').val(),
                    tglFaktur: $('#tglFaktur').val(),
                    uang: $('#uang').val(),
                    sisaUang: $('#sisaUang').val(),
                    totalBayar: $('#totalBayar').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('#btnSimpanPembayaran').prop('disabled', true);
                    $('#btnSimpanPembayaran').html('<i class="fa fa-spinner fa-pulse fa-lg"></i>');
                },
                complete: function() {
                    $('#btnSimpanPembayaran').prop('disabled', false);
                    $('#btnSimpanPembayaran').html('Simpan');
                },
                success: function(response) {

                    if (response.sukses) {

                        Swal.fire({
                            title: response.sukses,
                            text: "Apakah anda Ingin Mencetak Faktur ?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Cetak Faktur'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let windowCetak = window.open(response.cetakfaktur, "Cetak Faktur Barang Keluar", "width=250,height=500");
                                windowCetak.focus();
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        })

                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });


            return false;
        });




    });
</script>