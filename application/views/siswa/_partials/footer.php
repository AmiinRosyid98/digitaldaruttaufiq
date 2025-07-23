<footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="xcode.co.id">Xcode.co.id</a>.</strong> All rights reserved.
</footer>


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="https://cdn.excode.my.id/assets/member/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.excode.my.id/assets/member/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Sweet alert -->
<script src="https://cdn.excode.my.id/assets/member/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="https://cdn.excode.my.id/assets/member/plugins/toastr/toastr.min.js"></script>
<!-- Datatable -->
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/jszip/jszip.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/pdfmake/pdfmake.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/pdfmake/vfs_fonts.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.excode.my.id/assets/member/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.excode.my.id/assets/member/js/adminlte.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


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
</script>











</body>

</html>