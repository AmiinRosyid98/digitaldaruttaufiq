<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#" target="_blank">SISMA</a>.</strong> All rights reserved.
</footer>


<script src="<?= base_url('/assets/admin/plugins/jquery/jquery.min.js'); ?>"></script>

<!-- jQuery UI (optional, tapi harus setelah jQuery) -->
<script src="<?= base_url('/assets/admin/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- SweetAlert2 -->
<script src="<?= base_url('/assets/admin/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>

<!-- Toastr -->
<script src="<?= base_url('/assets/admin/plugins/toastr/toastr.min.js'); ?>"></script>

<!-- DataTables -->
<script src="<?= base_url('/assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/jszip/jszip.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/pdfmake/pdfmake.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/pdfmake/vfs_fonts.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>"></script>




<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

<!-- Bootstrap Colorpicker -->
<script src="<?= base_url('/assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'); ?>"></script>

<!-- AdminLTE App -->
<script src="<?= base_url('/assets/admin/js/adminlte.min.js'); ?>"></script>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

<!-- Quill Editor -->
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

<!-- Flatpickr (optional, kalau kamu mau datepicker simple) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Moment.js (Wajib sebelum Tempus Dominus) -->
<script src="<?= base_url('/assets/admin/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?= base_url('/assets/admin/plugins/moment/locale/id.js'); ?>"></script>

<!-- Tempus Dominus (datepicker bawaan AdminLTE) -->
<script src="<?= base_url('/assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
<!-- Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<!-- table -->
<script>
    $(document).ready(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": true,
            "searching": true,
            "columnDefs": [{
                    "targets": [1],
                    "searchable": true
                } // Mengaktifkan pencarian hanya pada kolom dengan indeks 1 (kolom nama)
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>





<!-- Toast -->
<script>
    $(function() {
        function showToast(message, type) {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };

            if (type === 'success') {
                toastr.success(message);
            } else if (type === 'error') {
                toastr.error(message);
            } else if (type === 'warning') {
                toastr.warning(message);
            } else if (type === 'info') {
                toastr.info(message);
            }
        }

        // Ambil parameter dari URL jika ada
        const params = new URLSearchParams(window.location.search);
        const successMessage = params.get('success');
        const errorMessage = params.get('error');
        const warningMessage = params.get('warning');
        const infoMessage = params.get('info');

        // Tampilkan notifikasi Toastr jika ada pesan sukses atau gagal
        if (successMessage) {
            showToast(successMessage, 'success');
        } else if (warningMessage) {
            showToast(warningMessage, 'warning');
        } else if (errorMessage) {
            showToast(errorMessage, 'error');
        } else if (infoMessage) {
            showToast(infoMessage, 'info');
        }

        // Handler untuk event click pada elemen dengan kelas .toastsDefaultWarning
        $('.toastsDefaultWarning').click(function() {
            showToast('Ini adalah notifikasi peringatan!', 'warning');
        });

        // Handler untuk event click pada elemen dengan kelas .toastsDefaultInfo
        $('.toastsDefaultInfo').click(function() {
            showToast('Ini adalah notifikasi informasi.', 'info');
        });

        // Handler untuk event click pada elemen dengan kelas .toastsDefaultError
        $('.toastsDefaultError').click(function() {
            showToast('Ini adalah notifikasi kesalahan.', 'error');
        });

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })
    });

    $('.btn-bayar-langsung').click(function(e){
        Swal.fire({
          icon: "info",
          title: "Bayar langsung",
          text: "Pembayaran langsung bisa dilakukan di kantor",
        });
    })
</script>











</body>

</html>