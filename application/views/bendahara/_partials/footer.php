<footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="xcode.co.id">Xcode.co.id</a>.</strong> All rights reserved.
</footer>

</div>
<!-- REQUIRED SCRIPTS -->


<!-- jQuery -->
<script src="https://cdn.excode.my.id/assets/admin/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.excode.my.id/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Sweet alert -->
<script src="https://cdn.excode.my.id/assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="https://cdn.excode.my.id/assets/admin/plugins/toastr/toastr.min.js"></script>
<!-- Datatable -->
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/jszip/jszip.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.excode.my.id/assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.excode.my.id/assets/admin/js/adminlte.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>




<!-- table -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "searching": true,
            "columnDefs": [{
                    "targets": [1],
                    "searchable": true
                } // Mengaktifkan pencarian hanya pada kolom dengan indeks 1 (kolom nama)
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $(function() {
        $("#example2").DataTable({
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "autoWidth": false,
            "searching": true,
            "columnDefs": [{
                    "targets": [1],
                    "searchable": true
                } // Mengaktifkan pencarian hanya pada kolom dengan indeks 1 (kolom nama)
            ]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
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




<!-------------------------------------------Layanan-------------------------------------------->
<script>
    //Fungsi Edit Tahun Angkatan
    function editTahunAngkatan(tahunangkatanId) {
        $.ajax({
            url: 'get_tahunangkatan',
            type: 'GET',
            data: {
                tahunangkatan_id: tahunangkatanId
            },
            dataType: 'json',
            success: function(response) {
                $('#editTahunAngkatanId').val(response.tahunangkatan.id_tahunangkatan);
                $('#editTahunAngkatan').val(response.tahunangkatan.tahun);
                $('#editTahunAngkatanModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat data Kelas.');
            }
        });
    }


    $(document).ready(function() {
        $('#editTahunangkatanForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'update_tahunangkatan',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editTahunAngkatanModal').modal('hide');
                        showToast('success', 'Data Tahun Angkatan berhasil diperbarui.');
                        location.reload();
                    } else {
                        showToast('error', 'Gagal menyimpan perubahan.');
                    }
                },
                error: function() {
                    showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                }
            });
        });
    });

    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }
</script>


<script>
    function deletetahunangkatan(tahunangkatanId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Tahun Angakatan ini akan terhapus permanen !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('/admin/masterdata/hapus_tahunangkatan/'); ?>" + tahunangkatanId;
            }
        });
    }
</script>




<script>
    //Fungsi Edit Tahun Pelajaran
    function editTahunPelajaran(tahunpelajaranId) {
        $.ajax({
            url: 'get_tahunpelajaran',
            type: 'GET',
            data: {
                tahunpelajaran_id: tahunpelajaranId
            },
            dataType: 'json',
            success: function(response) {
                $('#editTahunPelajaranId').val(response.tahunpelajaran.id_tahunpelajaran);
                $('#editTahunPelajaran').val(response.tahunpelajaran.tahun_pelajaran);
                $('#editTahunPelajaranModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat data Kelas.');
            }
        });
    }


    $(document).ready(function() {
        $('#editTahunPelajaranForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'update_tahunpelajaran',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editTahunPelajaranModal').modal('hide');
                        showToast('success', 'Data Tahun Pelajaran berhasil diperbarui.');
                        location.reload();
                    } else {
                        showToast('error', 'Gagal menyimpan perubahan.');
                    }
                },
                error: function() {
                    showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                }
            });
        });
    });

    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }
</script>


<script>
    function deletetahunpelajaran(tahunpelajaranId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Tahun Pelajaran ini akan terhapus permanen !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('/admin/masterdata/hapus_tahupelajaran/'); ?>" + tahunpelajaranId;
            }
        });
    }
</script>





<script>
    //Fungsi Edit Siswa
    function editSiswa(siswaId) {
        $.ajax({
            url: 'siswa/get_siswa',
            type: 'GET',
            data: {
                siswa_id: siswaId
            },
            dataType: 'json',
            success: function(response) {
                $('#editSiswaId').val(response.siswa.id_siswa);
                $('#editNamaSiswa').val(response.siswa.nama_siswa);
                $('#editJeniskelamin').val(response.siswa.jeniskelamin);
                $('#editAgama').val(response.siswa.agama);
                $('#editTempatlahir').val(response.siswa.tempatlahir);
                $('#editTanggallahir').val(response.siswa.tanggallahir);
                $('#editAlamatSiswa').val(response.siswa.siswa_alamat);
                $('#editKodeKelas').val(response.siswa.kode_kelas);
                $('#editNomorAbsen').val(response.siswa.no_absen);
                $('#editNis').val(response.siswa.nis);
                $('#editNisn').val(response.siswa.nisn);
                $('#editTahunAngkatan').val(response.siswa.tahun_angkatan);
                $('#editMemberModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat data member.');
            }
        });
    }

    $(document).ready(function() {
        $('#editMemberForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'siswa/update_siswa',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editMemberModal').modal('hide');
                        showToast('success', 'Data member berhasil diperbarui.');
                        location.reload();
                    } else {
                        showToast('error', 'Gagal menyimpan perubahan.');
                    }
                },
                error: function() {
                    showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                }
            });
        });
    });

    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }
</script>


<script>
    //Fungsi Hapus Siswa
    function deleteSiswa(siswaId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Siswa ini akan terhapus secara permanen  !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('admin/siswa/hapus_siswa/'); ?>" + siswaId;
            }
        });

    }
</script>

<script>
    //Fungsi Hapus semua Siswa
    function deleteallSiswa() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua Data Siswa akan dihapus secara permanen !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('admin/siswa/kosongkan_siswa/'); ?>";
            }
        });

    }
</script>





<script>
    //Fungsi Edit Kelas
    function editKelas(kelasId) {
        $.ajax({
            url: 'get_kelas',
            type: 'GET',
            data: {
                kelas_id: kelasId
            },
            dataType: 'json',
            success: function(response) {
                $('#editKelasId').val(response.kelas.id_kelas);
                $('#editNamaKelas').val(response.kelas.nama_kelas);
                $('#editKodeTingkat').val(response.kelas.kode_tingkat);
                $('#editKodeKelas').val(response.kelas.no_kelas);
                $('#editKelasModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat data Kelas.');
            }
        });
    }


    $(document).ready(function() {
        $('#editKelasForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'update_kelas',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editKelasModal').modal('hide');
                        showToast('success', 'Data Kelas berhasil diperbarui.');
                        location.reload();
                    } else {
                        showToast('error', 'Gagal menyimpan perubahan.');
                    }
                },
                error: function() {
                    showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                }
            });
        });
    });

    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }
</script>












<script>
    //Fungsi Edit Tingkat
    function editTingkat(tingkatId) {
        $.ajax({
            url: 'get_tingkat',
            type: 'GET',
            data: {
                tingkat_id: tingkatId
            },
            dataType: 'json',
            success: function(response) {
                $('#editTingkatId').val(response.tingkat.id_tingkat);
                $('#editNamaTingkat').val(response.tingkat.nama_tingkat);
                $('#editTingkatModal').modal('show');
            },
            error: function() {
                alert('Gagal memuat data Tingkat.');
            }
        });
    }


    $(document).ready(function() {
        $('#editTingkatForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'update_tingkat',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#editTingkatModal').modal('hide');
                        showToast('success', 'Data Tingkat berhasil diperbarui.');
                        location.reload();
                    } else {
                        showToast('error', 'Gagal menyimpan perubahan.');
                    }
                },
                error: function() {
                    showToast('error', 'Terjadi kesalahan saat menyimpan perubahan.');
                }
            });
        });
    });

    function showToast(type, message) {
        toastr.options.positionClass = 'toast-top-right';
        toastr[type](message);
    }
</script>



<script>
    //Fungsi Hapus Tingkat
    function deleteTingkat(tingkatId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Tingkat ini akan terhapus permanen !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('/admin/masterdata/hapus_tingkat/'); ?>" + tingkatId;
            }
        });
    }
</script>

















<script>
    // Form Generate Kode-Kelas
    $(document).ready(function() {
        generateAndSetRandomCode();

        $('#generateKode').click(function() {
            generateAndSetRandomCode();
        });

        function generateAndSetRandomCode() {
            var randomCode = generateRandomCode();
            $('#kodeLayanan').val(randomCode);
        }

        function generateRandomCode() {
            var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            var codeLength = 8;
            var randomCode = 'KEL-';
            for (var i = 0; i < codeLength; i++) {
                randomCode += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return randomCode;
        }
    });
</script>

</body>

</html>