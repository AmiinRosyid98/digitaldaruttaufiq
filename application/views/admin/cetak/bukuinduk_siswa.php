<html>
    <head>
        <style>
            body {
                font-size: 10px;
            }
            
            .title {
                font-weight: bold;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>

    <h3 style="text-align: center; font-weight: bold;">DATA PESERTA DIDIK</h3>

    <table border="0" style="width: 100%">
        <tr>
            <td style="width: 15%;">NOMOR INDUK SEKOLAH</td>
            <td style="width: 1%;">:</td>
            <td style="width: 25%;"><?php echo $siswa['nis']; ?></td>
        </tr>
        <tr>

            <td style="width: 15%;">NOMOR INDUK NASIONAL </td>
            <td style="width: 1%;">:</td>
            <td style="width: 25%;"><?php echo $siswa['nisn']; ?></td>
        </tr>
    </table>
    <hr><br>


        <table border="0" style="width: 100%">
            <tr><br>
                <td style="width: 40%;">
                    <ol type="A">
                        <li>
                            <span class="title">KETERANGAN TENTANG DIRI PESERTA DIDIK</span> <br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">Nama Lengkap Peserta Didik</td>
                                    <td style="width: 53%;">: <?php echo $siswa['nama_siswa']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Jenis Kelamin</td>
                                    <td style="width: 53%;">:  <?php echo $siswa['jeniskelamin']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Tempat / Tanggal lahir</td>
                                    <td style="width: 53%;">: <?php echo $siswa['tempatlahir']; ?> - <?php echo date('d-m-Y', strtotime($siswa['tanggallahir'])); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Agama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['agama']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Kewarganegaraan</td>
                                    <td style="width: 53%;">: Indonesia</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Anak Ke</td>
                                    <td style="width: 53%;">: <?php echo $siswa['anakke']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Jumlah Saudara</td>
                                    <td style="width: 53%;">: <?php echo $siswa['jumlahsaudara']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Yatim/Piatu/Yatim Piatu</td>
                                    <td style="width: 53%;">: <?php echo $siswa['status_anakyatim']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Bahasa Sehari-Hari</td>
                                    <td style="width: 53%;">: Indonesia</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Hobi</td>
                                    <td style="width: 53%;">:  <?php echo $siswa['hobi']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Cita - Cita</td>
                                    <td style="width: 53%;">:  <?php echo $siswa['citacita']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">No Telepon / No HP</td>
                                    <td style="width: 53%;">: <?php echo $siswa['nohp']; ?></td>
                                </tr>
                            </table>
                        </li>
                        
                        <li>
                            <span class="title">KETERANGAN TEMPAT TINGGAL</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">Alamat</td>
                                    <td style="width: 2%;">:</td>
                                    <td style="width: 50%;"><?php echo $siswa['siswa_alamat']; ?>, <?php echo $siswa['siswa_kelurahan']; ?>, <?php echo $siswa['siswa_kecamatan']; ?>, <?php echo $siswa['siswa_kabupaten']; ?>, <?php echo $siswa['siswa_provinsi']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="width: 2%;"></td>
                                    <td style="width: 53%;"></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Jarak Tempat Tinggal ke Sekolah</td>
                                    <td style="width: 53%;">: <?php echo $siswa['siswa_jaraksekolah']; ?> KM</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Transportasi</td>
                                    <td style="width: 53%;">: <?php echo $siswa['siswa_transportasi']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Tinggal Dengan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['siswa_tinggal']; ?></td>
                                </tr>
                            </table>
                        </li>
                        
                        <li>
                            <span class="title">KETERANGAN KESEHATAN</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">Golongan Darah</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pendukung_golongandarah']; ?></td>
                                </tr>  
                                <tr>
                                    <td style="width: 40%;">Penyakit yang pernah diderita</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pendukung_penyakit']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Kelainan Jasmani</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pendukung_kelainanjasmani']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Tinggi dan berat badan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pendukung_tinggibadan']; ?> Cm , <?php echo $siswa['pendukung_beratbadan']; ?> Kg</td>
                                </tr>
                            </table>
                         </li>
                         <li>
                            <span class="title">PENDIDIKAN SEBELUMNYA</span><br>
                                <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;"><strong>Pendidikan Sebelumnya</strong></td>
                                    <td style="width: 53%;"></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">a. Tamatan dari</td>
                                    <td style="width: 53%;">: <?php echo $siswa['asal_sekolah']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">b. Nomor Ijazah</td>
                                    <td style="width: 53%;">: <?php echo $siswa['asal_noijazah']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">c. Nomor STL/SKHUN</td>
                                    <td style="width: 53%;">: <?php echo $siswa['asal_noskhu']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">d. Tanggal Lulus</td>
                                    <td style="width: 53%;">: <?php echo $siswa['asal_tanggal']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;"><strong>Siswa Pindahan</strong></td>
                                    <td style="width: 53%;"></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">a. Dari Sekolah</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pindahan_asalsekolah']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">b. Alasan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pindahan_alasan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 37%;">c. Tanggal</td>
                                    <td style="width: 53%;">: <?php echo $siswa['pindahan_tanggal']; ?></td>
                                </tr>

                            </table>
                        </li>
                        
                        <li>
                            <span class="title">KETERANGAN TENTANG AYAH KANDUNG</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">NIK</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_nik']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Nama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_nama']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Tempat dan Tanggal Lahir</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_tempatlahir']; ?>, <?php echo date('d-m-Y', strtotime($siswa['ayah_tanggallahir'])); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Agama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_agama']; ?></td>
                                </tr>
                                 <tr>
                                    <td style="width: 40%;">Kewarganegaraan</td>
                                    <td style="width: 53%;">: Indonesia</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pendidikan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_pendidikan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pekerjaan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_pekerjaan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pendapatan Perbulan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_penghasilan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Alamat Rumah</td>
                                    <td style="width: 2%;">: </td>
                                    <td style="width: 53%;"><?php echo $siswa['ayah_alamat']; ?>, <?php echo $siswa['ayah_desakel']; ?>, <?php echo $siswa['ayah_kecamatan']; ?>, <?php echo $siswa['ayah_kabupaten']; ?>, <?php echo $siswa['ayah_provinsi']; ?> </td>
                                </tr>  
                                <tr>
                                    <td style="width: 40%;">No Hp</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_nohp']; ?></td>
                                </tr>                           
                                <tr>
                                    <td style="width: 40%;">Masih Hidup/Meninggal Dunia</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ayah_status']; ?></td>
                                </tr>

                            </table>
                        </li>
                    </ol>
                </td>




                <td style="width: 50%;">
                    <ol type="A" start="6">
                   
                        <li>
                            <span class="title">KETERANGAN TENTANG IBU KANDUNG</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">NIK</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_nik']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Nama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_nama']; ?></td>
                                </tr>

                                <tr>
                                    <td style="width: 40%;">Tempat dan Tanggal Lahir</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_tempatlahir']; ?>, <?php echo $siswa['ibu_tanggallahir']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Agama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_agama']; ?></td>
                                </tr>
                                 <tr>
                                    <td style="width: 40%;">Kewarganegaraan</td>
                                    <td style="width: 53%;">: Indonesia</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pendidikan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_pendidikan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pekerjaan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_pekerjaan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pendapatan Perbulan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_penghasilan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Alamat Rumah</td>
                                    <td style="width: 2%;">:</td>
                                    <td style="width: 53%;"><?php echo $siswa['ibu_alamat']; ?>, <?php echo $siswa['ibu_desakel']; ?>, <?php echo $siswa['ibu_kecamatan']; ?>, <?php echo $siswa['ibu_kabupaten']; ?>, <?php echo $siswa['ibu_provinsi']; ?> </td>
                                </tr> 
                                <tr>
                                    <td style="width: 40%;">No Hp</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_nohp']; ?></td>
                                </tr>                               
                                <tr>
                                    <td style="width: 40%;">Masih Hidup/Meninggal Dunia</td>
                                    <td style="width: 53%;">: <?php echo $siswa['ibu_status']; ?></td>
                                </tr>
            
                            </table>
                        </li>


                        <li>
                            <span class="title">KETERANGAN TENTANG WALI</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">NIK</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_nik']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Nama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_nama']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Tempat dan Tanggal Lahir</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_tempatlahir']; ?>, <?php echo $siswa['wali_tanggallahir']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Agama</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_agama']; ?></td>
                                </tr>
                                 <tr>
                                    <td style="width: 40%;">Kewarganegaraan</td>
                                    <td style="width: 53%;">: Indonesia</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pendidikan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_pendidikan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pekerjaan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_pekerjaan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Pendapatan Perbulan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_penghasilan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Alamat Rumah / No HP</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_alamat']; ?>, <?php echo $siswa['wali_desakel']; ?>, <?php echo $siswa['wali_kecamatan']; ?>, <?php echo $siswa['wali_kabupaten']; ?>, <?php echo $siswa['wali_provinsi']; ?></td>
                                </tr>       
                                <tr>
                                    <td style="width: 40%;">No HP</td>
                                    <td style="width: 53%;">: <?php echo $siswa['wali_nohp']; ?></td>
                                </tr>   
                                <tr>
                                    <td style="width: 40%;">Masih Hidup/Meninggal Dunia</td>
                                    <td style="width: 2%;">: </td>
                                    <td style="width: 53%;"><?php echo $siswa['wali_status']; ?></td>
                                </tr>         
                            </table>
                        </li>
                        <li>
                            <span class="title">KEGEMARAN PESERTA DIDIK</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">Kesenian</td>
                                    <td style="width: 53%;">: <?php echo $siswa['kegemaran_kesenian']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Olah Raga</td>
                                    <td style="width: 53%;">: <?php echo $siswa['kegemaran_olahraga']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Kemasyarakatan/Organisasi</td>
                                    <td style="width: 53%;">: <?php echo $siswa['kegemaran_organisasi']; ?></td>
                                </tr>
                                 <tr>
                                    <td style="width: 40%;">Lain-lain</td>
                                    <td style="width: 53%;">: <?php echo $siswa['kegemaran_lainlain']; ?></td>
                                </tr>
                            </table>
                        </li>
                        <li>
                            <span class="title">KETERANGAN PERKEMBANGAN PESERTA DIDIK</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 40%;">Menerima Beasiswa</td>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 53%;">: <?php echo $siswa['beasiswa_nama']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;"></td>
                                    <td style="width: 53%;">: Tahun <?php echo $siswa['beasiswa_tahun']; ?> / Nominal <?php echo $siswa['beasiswa_nominal']; ?></td>
                                </tr>
                              
                                <tr>
                                    <td style="width: 40%;">Meninggalkan Sekolah ini</td>
                                    <td style="width: 53%;"></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">a. Tanggal meninggalkan sekolah</td>
                                    <td style="width: 53%;">: </td>
                                </tr>
                                 <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">b. Alasan</td>
                                    <td style="width: 53%;">: </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Akhir Pendidikan</td>
                                    <td style="width: 53%;"></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">a. Lulus</td>
                                    <td style="width: 53%;">: <?php echo $siswa['lulus_tahun']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">b. Nomor/Tanggal Ijazah</td>
                                    <td style="width: 53%;">: <?php echo $siswa['lulus_noijazah']; ?> / <?php echo $siswa['lulus_tanggalijazah']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">c. Nomor/Tanggal SKHU</td>
                                    <td style="width: 53%;">: <?php echo $siswa['lulus_noskhu']; ?> / <?php echo $siswa['lulus_tanggalskhu']; ?></td>
                                </tr>
                            </table>
                        </li>
                        <li>
                            <span class="title">KETERANGAN SETELAH SELESAI PENDIDIKAN</span><br>
                            <table border="0" style="width: 100%;">
                                <tr>
                                    
                                    <td style="width: 40%;">Melanjutkan ke</td>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 53%;">: <?php echo $siswa['lanjut_nama']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Bekerja di</td>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 53%;">: <?php echo $siswa['lanjut_bekerja']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">a. Tanggal mulai bekerja</td>
                                    <td style="width: 53%;">: <?php echo $siswa['lanjut_bekerjamulai']; ?></td>
                                </tr>
                                 <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">b. Nama Perusahaan/Lembaga</td>
                                    <td style="width: 53%;">: <?php echo $siswa['lanjut_bekerjaperusahaan']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 3%;"></td>
                                    <td style="width: 40%;">c. Penghasilan</td>
                                    <td style="width: 53%;">: <?php echo $siswa['lanjut_penghasilan']; ?></td>
                                </tr>
                            </table>
                        </li>
                    </ol>
                </td>
                

                
                <td style="width: 0%;">
                    
                    <table border="0"> 
                        <tr>
                            <td> <br><br><br> <br><br><br> <br><br><br></td>
                        </tr>

                    </table>

                    <table border="1">
                        <tr>
                            <td style="text-align: center;">
                                <br><br><br><br>
                                Pas Photo
                                <br><br><br>
                                3 x 4
                                <br><br><br><br>
                            </td>
                        </tr>
                    </table>
                    <table border="0">
                        <tr>
                            <td style="text-align: center;">Waktu diterima disekolah ini</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td style="text-align: center;">
                                <br><br><br><br>
                                Pas Photo
                                <br><br><br>
                                3 x 4
                                <br><br><br><br>
                            </td>
                        </tr>
                    </table>
                    <table border="0">
                        <tr>
                            <td style="text-align: center;">Waktu meninggalkan sekolah ini</td>
                        </tr>
                    </table>
                </td>
            </tr>










        </table>
        
    </body>
</html>