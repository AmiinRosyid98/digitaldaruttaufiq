<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#" target="_blank">SISMA</a>.</strong> All rights reserved.
</footer>
</div> <!-- Ini menutup <div class="wrapper"> dari AdminLTE -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
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





<script>
    flatpickr("#tanggal_start", {
        dateFormat: "d/m/Y",
        altInput: true,
        altFormat: "d/m/Y",
    });

    flatpickr("#tanggal_finish", {
        dateFormat: "d/m/Y",
        altInput: true,
        altFormat: "d/m/Y",
    });
</script>
<script>
    $(document).ready(function() {
        // Inisialisasi DatePicker
        $('#tanggal_lahir').datetimepicker({
            format: 'DD-MM-YYYY' // Format input dd-mm-yyyy
        });
    });
</script>

<script>
    function limitCheckboxSelection(checkbox) {
        var checkboxes = document.querySelectorAll('input[name="' + checkbox.name + '"]');
        checkboxes.forEach(function(cb) {
            if (cb !== checkbox) {
                cb.checked = false;
            }
        });
    }
</script>



<script>
    // Fungsi untuk mengupdate waktu setiap detik
    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();

        // Menambahkan nol di depan angka jika hanya satu digit
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        // Menampilkan waktu dalam format HH:mm:ss
        var timeString = hours + ':' + minutes + ':' + seconds;

        // Memperbarui teks waktu di elemen dengan id 'live-clock'
        document.getElementById('live-clock').textContent = timeString;
    }

    // Memanggil fungsi updateClock setiap detik
    setInterval(updateClock, 1000);

    // Memanggil fungsi untuk memperbarui waktu saat halaman dimuat
    updateClock();
</script>

<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{
                    'header': '1'
                }, {
                    'header': '2'
                }, {
                    'font': []
                }],
                [{
                    size: []
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    },
                    {
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }
                ],
                ['link', 'image', 'video'],
                ['clean']
            ]
        },
    });

    // Menyimpan isi editor ke textarea tersembunyi saat form disubmit
    var form = document.querySelector('form');
    form.onsubmit = function() {
        var isi_berita = document.querySelector('textarea[name=isi_berita]');
        isi_berita.value = quill.root.innerHTML; // Simpan dalam format HTML
    };

    // Alternatif untuk menyimpan dalam format teks mentah (plain text)
    // Jika Anda ingin menyimpan dalam format teks mentah:
    // form.onsubmit = function() {
    //     var isi_berita = document.querySelector('textarea[name=isi_berita]');
    //     isi_berita.value = quill.root.textContent || quill.root.innerText;
    // };
</script>
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
            "autoWidth": false,
            "searching": true,
            "columnDefs": [{
                    "targets": [1],
                    "searchable": true
                } // Mengaktifkan pencarian hanya pada kolom dengan indeks 1 (kolom nama)
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#example12").DataTable({
            "responsive": false, // Pertahankan ini false agar scrollX dan fixedColumns bekerja optimal
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
            }],
            "scrollX": true, // Tetap aktifkan scroll horizontal
            "fixedColumns": {
                leftColumns: 2 // Membekukan 3 kolom pertama (No, Nama, NIP/No Pegawai)
                // rightColumns: 0 // Jika ada kolom di kanan yang ingin dibekukan, set di sini
            }
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
    // cek simpan kelas 

    let allowSubmit = false;

    $('#btn_simpan_kelas').on('click', function(e) {
        const form = $('#simpan_kelas');
        // alert(allowSubmit);

        if (!allowSubmit) {
            e.preventDefault(); // cegah default hanya jika belum boleh submit
            e.stopPropagation(); // ← opsional tapi aman

            $.ajax({
                url: 'ceksimpan_kelas',
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response === 'tidak_ada') {
                        allowSubmit = true;
                        setTimeout(function () {
                            form.submit();
                        }, 500);
                        // form.submit(); // akan lewat karena flag true
                    } else {
                        showToast('error', 'Wali Kelas sudah di setting di kelas lain');
                        return false
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan saat menyimpan data.');
                    return false
                }
            });
        } else {
            // Reset flag agar tidak submit dua kali kalau user klik lagi
            allowSubmit = false;
        }
    });



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
                $('#edit_id_guru').val(response.kelas.id_guru);
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
                    if(response=="ada"){
                        
                        showToast('error', 'Wali Kelas sudah di setting di kelas lain');
                        return false
                    
                    }
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
<script>
    $(document).ready(function() {
        $('#importSubmit').on('click', function(e) {
            e.preventDefault();

            // Menutup modal sebelum memulai proses import
            $('#importPenggunaModal').modal('hide');

            // Menampilkan indikator loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mengimpor data, mohon tunggu...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            var formData = new FormData($('#importForm')[0]);

            $.ajax({
                url: "<?php echo base_url('admin/siswa/import_data_excel'); ?>",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Menutup loading saat proses selesai
                    Swal.close();

                    if (response.success) {
                        // Menampilkan notifikasi sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Melakukan soft refresh dengan mengganti URL (refresh tanpa pengguna menyadari)
                                window.location.replace(window.location.href);
                            }
                        });
                    } else {
                        // Menampilkan notifikasi error jika import gagal
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Menutup loading jika terjadi error
                    Swal.close();

                    // Menampilkan pesan error
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: 'Kesalahan saat mengimpor data: ' + xhr.responseText,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
</body>

</html>