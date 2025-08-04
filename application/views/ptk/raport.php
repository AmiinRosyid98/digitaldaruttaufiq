<html lang="en">

<head>

    <?php $this->load->view('ptk/_partials/head.php') ?>
</head>

<body>
    <?php
    $success_message = $this->session->flashdata('success_message');
    $error_message = $this->session->flashdata('error_message');
    $info_message = $this->session->flashdata('info_message');
    ?>

    <body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php $this->load->view('ptk/_partials/navbar.php') ?>
            <!-- /.navbar -->


            <aside class="main-sidebar elevation-4 sidebar-dark-<?php echo $profilsekolah['menu_active'] ?? ''; ?>" style="background-color: <?php echo $profilsekolah['bg_active'] ?? ''; ?>;">
                <!-- Sidebar Information -->
                <?php $this->load->view('ptk/_partials/sidebar_information.php') ?>

                <!-- Sidebar Menu -->
                <?php $this->load->view('ptk/_partials/sidebar_menu.php') ?>

            </aside>

            <!-- ======================================================================================================= -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" >
                <!-- Content Header (Page header) -->
                <div class="content-header">
                </div>
                <!-- isi content -->
                <div class="content">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="card" style="margin-bottom:50px">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="card-title">Data Raport </h3>
                                        
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 " style="margin: 0;">Nama Kelas</label>
                                            <div class="col-sm-10">
                                                <?= $kelas->nama_kelas ;  ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 " style="margin: 0;">Tingkatan</label>
                                            <div class="col-sm-10">
                                                <?= $kelas->kode_tingkat ;  ?>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 " style="margin: 0;">Tahun Ajaran</label>
                                            <div class="col-sm-10">
                                                <?= $tahunajaran->tahun_pelajaran ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Siswa</th>
                                                <th>Semester 1</th>
                                                <th>Semester 2</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no=0;
                                                foreach ($siswa as $itembanksiswa) : ?>
                                                <tr>
                                                    <?php $no++; ?>
                                                    <td class="text-center"><?= $no ?></td>
                                                    <td class="text-left margin: 10;"><?php echo $itembanksiswa['nama_siswa']; ?></td>
                                                    <td class="text-center">
                                                        <?php 
                                                        $cek_raport_1 = $this->db->select("*")
                                                                                ->from("raport")
                                                                                ->where("id_siswa", $itembanksiswa['id_siswa'])
                                                                                ->where("id_tahunajaran", $tahunajaran->id_tahunpelajaran)
                                                                                ->where("id_kelas", $kelas->id_kelas)
                                                                                ->where("semester", "1")
                                                                                ->order_by("id_raport","DESC")
                                                                                ->limit(1)
                                                                                ->get()
                                                                                ;
                                                        if($cek_raport_1->num_rows() > 0){
                                                            $result = $cek_raport_1->row();
                                                            if($result->file == "Ya"){

                                                                $file = base_url('upload/dokumen/') . $result->url_path;
                                                            } else{
                                                                $file = $result->link;

                                                            }
                                                        ?>
                                                            <a class="btn btn-success btn-sm" href="<?= $file ?>" target="_blank"  style="padding-top: 7.5px; padding-bottom: 7.5px;"><i class="fas fa-download"></i></a>
                                                            <button class="btn btn-sm btn-info upload_raport sadsd btn-sm" class="" id_siswa="<?php echo $itembanksiswa['id_siswa']; ?>" nama_siswa="<?php echo $itembanksiswa['nama_siswa']; ?>" semester = "1"><i class="fas fa-upload"></i> Ubah</button>
                                                        
                                                        <?php                       
                                                        } else {
                                                        ?>
                                                            <button class="btn btn-sm btn-primary upload_raport sadsd btn-sm" class="" id_siswa="<?php echo $itembanksiswa['id_siswa']; ?>" nama_siswa="<?php echo $itembanksiswa['nama_siswa']; ?>" semester = "1"><i class="fas fa-upload"></i> Upload</button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php 
                                                        $cek_raport_2 = $this->db->select("*")
                                                                                ->from("raport")
                                                                                ->where("id_siswa", $itembanksiswa['id_siswa'])
                                                                                ->where("id_tahunajaran", $tahunajaran->id_tahunpelajaran)
                                                                                ->where("id_kelas", $kelas->id_kelas)
                                                                                ->where("semester", "2")
                                                                                ->order_by("id_raport","DESC")
                                                                                ->limit(1)
                                                                                ->get()
                                                                                ;
                                                        if($cek_raport_2->num_rows() > 0){
                                                            $result = $cek_raport_2->row();
                                                            if($result->file == "Ya"){

                                                                $file = base_url('upload/dokumen/') . $result->url_path;
                                                            } else{
                                                                $file = $result->link;

                                                            }
                                                        ?>
                                                            <a class="btn btn-success btn-sm" href="<?= $file ?>" target="_blank" style="padding-top: 7.5px; padding-bottom: 7.5px;"><i class="fas fa-download"></i></a>
                                                            <button class="btn btn-sm btn-info upload_raport sadsd btn-sm" class="" id_siswa="<?php echo $itembanksiswa['id_siswa']; ?>" nama_siswa="<?php echo $itembanksiswa['nama_siswa']; ?>" semester = "2"><i class="fas fa-upload"></i> Ubah</button>
                                                        
                                                        <?php                       
                                                        } else {
                                                        ?>
                                                            <button class="btn btn-sm btn-primary upload_raport sadsd btn-sm" class="" id_siswa="<?php echo $itembanksiswa['id_siswa']; ?>" nama_siswa="<?php echo $itembanksiswa['nama_siswa']; ?>" semester = "2"><i class="fas fa-upload"></i> Upload</button>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="pagination">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ======================================================================================================= -->

                    <!-- Modal Tambah Dokumen Digital -->
                    <div class="modal fade" id="modal_upload_raport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Upload Raport</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo site_url('ptk/filearsip/simpan_banksoal'); ?>" id="uploadForm" method="POST" enctype="multipart/form-data" role="form" onsubmit="return validateForm()">

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 " style="margin: 0;">Nama Siswa</label>
                                            <div class="col-sm-9">
                                                <span class="modal_nama_siswa"></span>
                                                <input type="hidden" name="id_siswa" class="modal_id_siswa" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 " style="margin: 0;">Kelas </label>
                                            <div class="col-sm-9">
                                                <span class="modal_kelas_siswa"></span>
                                                
                                                <input type="hidden" name="id_kelas" class="modal_id_kelas" value="<?= $kelas->id_kelas ;  ?>">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 " style="margin: 0;">Semester </label>
                                            <div class="col-sm-9">
                                                <span class="modal_semester"></span>
                                                <input type="hidden" name="semester" class="modal_semester_val" value="">


                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 " style="margin: 0;">Tahun Ajaran </label>
                                            <div class="col-sm-9">
                                                <?= $tahunajaran->tahun_pelajaran ?>
                                                <input type="hidden" name="tahun_pelajaran" class="modal_tahunajaran" value="<?= $tahunajaran->tahun_pelajaran ?>">
                                                <input type="hidden" name="id_tahunpelajaran" class="modal_tahunajaran" value="<?= $tahunajaran->id_tahunpelajaran ?>">


                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="custom-control custom-radio ml-2">
                                              <input type="radio" id="customRadio1" name="tipedokumen" value="file" class="custom-control-input" checked>
                                              <label class="custom-control-label" for="customRadio1">File</label>
                                            </div>
                                            <div class="custom-control custom-radio ml-3">
                                              <input type="radio" id="customRadio2" name="tipedokumen" value="link" class="custom-control-input">
                                              <label class="custom-control-label" for="customRadio2">Link Url</label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="input-file" >
                                            <label for="file_arsip">File Raport (PDF/Word)</label>
                                            <input type="file" class="form-control-file" id="file_raport" name="file_raport">
                                        </div>
                                        <div class="form-group" id="input-link" style="display: none;" >
                                            <label for="file_arsip">Link URL</label>
                                            <input type="text" class="form-control" id="link" name="link" placeholder="Masukkan URL" >
                                        </div>
                                        <button type="submit" class="btn btn-primary btn_upload_raport">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>










                    <?php $this->load->view('ptk/_partials/footer.php') ?>






                    <script>
                        //Fungsi Hapus Buku
                        function deleteBanksoal(banksoalId) {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: "File Bank Soal akan terhapus permanen !",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?php echo base_url('/ptk/filearsip/hapus_banksoal/'); ?>" + banksoalId;
                                }
                            });
                        }

                        $('.upload_raport').click(function(){
                            let id_siswa = $(this).attr('id_siswa');
                            let nama_siswa = $(this).attr('nama_siswa');
                            let semester = $(this).attr('semester');
                            $('.modal_kelas_siswa').html("<?= $kelas->kode_tingkat ;  ?>"+" / "+"<?= $kelas->nama_kelas ;  ?>")
                            $('.modal_nama_siswa').html(nama_siswa)
                            $('.modal_id_siswa').val(id_siswa)
                            $('.modal_semester').html(semester)
                            $('.modal_semester_val').val(semester)
                            $("#modal_upload_raport").modal('show')
                            $('input[name="tipe_dokumen"][value="file"]').prop('checked', true).trigger('change');
                            $('#link').val("")
                            $('#customRadio1').prop('checked', true).trigger('change');

                            let oldInput = $('#file_raport');
                            let newInput = oldInput.clone().val('');
                            oldInput.replaceWith(newInput);
                        })

                        $('input[name="tipedokumen"]').on('change', function() {
                            if ($(this).val() === 'file') {
                              $('#input-file').show();
                              $('#input-link').hide();
                            } else {
                              $('#input-file').hide();
                              $('#input-link').show();
                            }
                        });

                        $('#uploadForm').submit(function(e) {
                            e.preventDefault()
                            const selected = $('input[name="tipedokumen"]:checked').val();
                            // alert(selected) // asdasd
                            if (selected == "file") {
                                if ($('#file_raport')[0].files.length === 0) {
                                  // alert();
                                    showToast('error', "File belum dipilih");
                                    return false

                                }
                            } else {
                                if ($('#link').val()=="") {
                                  // alert();
                                    showToast('error', "Masukkan Link Download Raport");
                                    return false

                                }
                            }
                            var formData = new FormData(this);

                            $.ajax({
                              url: '<?= base_url("ptk/raport/upload_raport") ?>', // sesuaikan dengan route
                              type: 'POST',
                              data: formData,
                              contentType: false,
                              processData: false,
                              dataType: 'json',
                              success: function(res) {
                                if(res.status == "sukses"){
                                    location.reload();
                                } else {
                                    showToast('error', res.msg);
                                    return false
                                }
                              },
                              error: function(xhr) {
                                $('#response').html('<div style="color:red;">Terjadi kesalahan: ' + xhr.responseText + '</div>');
                              }
                            });

                            return false
                        });

                    </script>

                    <script>
                        function showToast(type, message) {
                            toastr.options.positionClass = 'toast-top-right';
                            toastr[type](message);
                        }

                        <?php if ($success_message) : ?>
                            showToast('success', '<?php echo $success_message; ?>');
                        <?php endif; ?>

                        <?php if ($info_message) : ?>
                            showToast('info', '<?php echo $info_message; ?>');
                        <?php endif; ?>

                        <?php if ($error_message) : ?>
                            showToast('error', '<?php echo $error_message; ?>');
                        <?php endif; ?>
                    </script>