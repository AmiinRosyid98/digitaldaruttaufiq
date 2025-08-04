<?php

class Masterdata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Kelas_Model');
        $this->load->model('Tingkat_Model');
        $this->load->model('Tahunangkatan_Model');
        $this->load->model('Tahunpelajaran_Model');
        $this->load->model('Mapel_Model');
        $this->load->model('auth_admin');
        $this->load->model('Ptk_Model');
        $this->load->library('pagination');
        $this->load->library('upload');

        // Pemeriksaan apakah pengguna telah login
        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            // Simpan URL halaman sebelumnya
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginadmin');
        }

        // Pemeriksaan apakah pengguna memiliki peran 'admin'
        if ($current_user->role != 'admin') {
            // Mengarahkan pengguna ke halaman kesalahan kustom
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }


    // FUNGSI TAHUN ANGKATAN
    public function tahunangkatan()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['tahunangkatan']  = $this->Tahunangkatan_Model->get_tahunangkatan();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/tahunangkatan', $data);
    }


    public function get_tahunangkatan()
    {
        $tahunangkatan_id   = $this->input->get('tahunangkatan_id');
        $tahunangkatan      = $this->Tahunangkatan_Model->get_tahunangkatan_by_id($tahunangkatan_id);
        echo json_encode(array('tahunangkatan' => $tahunangkatan));
    }


    public function simpan_tahunangkatan()
    {
        $tahun = $this->input->post('tahun');

        $existing_kelas = $this->Tahunangkatan_Model->get_tahunangkatan_by_tahun($tahun);
        if ($existing_kelas) {
            $this->session->set_flashdata('error_message', 'Tahun Angkatan Telah Tersedia. Silakan Ganti Tahun Angkatan lain.');
            redirect('admin/masterdata/tahunangkatan');
            return;
        }
        $insert_data = array(
            'tahun' => $tahun
        );
        $insert_result = $this->Tahunangkatan_Model->simpan_tahunangkatan($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Angkatan berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Tahun Angakatan.');
        }
        redirect('admin/masterdata/tahunangkatan');
    }


    public function update_tahunangkatan()
    {
        $tahunangkatan_id   = $this->input->post('editTahunAngkatanId');
        $data         = array(
            'tahun'     => $this->input->post('editTahunAngkatan')
        );
        $result = $this->Tahunangkatan_Model->update_tahunangkatan($tahunangkatan_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Angkatan berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Tahun Angkatan');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_tahunangkatan($tahun_id)
    {
        $result = $this->Tahunangkatan_Model->hapus_tahunangkatan($tahun_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Tahun Angkatan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tahun Angkatan.');
        }
        redirect('admin/masterdata/tahunangkatan');
    }




    //FUNGSI TAHUN PELAJARAN
    public function tahunpelajaran()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['tahunpelajaran'] = $this->Tahunpelajaran_Model->get_tahunpelajaran();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/tahunpelajaran', $data);
    }

    public function get_tahunpelajaran()
    {
        $tahunpelajaran_id   = $this->input->get('tahunpelajaran_id');
        $tahunpelajaran      = $this->Tahunpelajaran_Model->get_tahunpelajaran_by_id($tahunpelajaran_id);
        echo json_encode(array('tahunpelajaran' => $tahunpelajaran));
    }


    public function simpan_tahunpelajaran()
    {
        $tahun_pelajaran = $this->input->post('tahun_pelajaran');

        $existing_tahunpelajaran = $this->Tahunpelajaran_Model->get_tahunpelajaran_by_tahun($tahun_pelajaran);
        if ($existing_tahunpelajaran) {
            $this->session->set_flashdata('error_message', 'Tahun Pelajaran Telah Tersedia. Silakan Ganti Tahun Pelajaran lain.');
            redirect('admin/masterdata/tahunpelajaran');
            return;
        }
        $insert_data = array(
            'tahun_pelajaran' => $tahun_pelajaran
        );
        $insert_result = $this->Tahunpelajaran_Model->simpan_tahunpelajaran($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Pelajaran berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Tahun Pelajaran.');
        }
        redirect('admin/masterdata/tahunpelajaran');
    }


    public function update_tahunpelajaran()
    {
        $tahunpelajaran_id   = $this->input->post('editTahunPelajaranId');
        $data         = array(
            'tahun_pelajaran'     => $this->input->post('editTahunPelajaran')
        );
        $result = $this->Tahunpelajaran_Model->update_tahunpelajaran($tahunpelajaran_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Tahun Pelajaran berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Tahun Pelajaran');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_tahupelajaran($tahunpelajaran_id)
    {
        $result = $this->Tahunpelajaran_Model->hapus_tahunpelajaran($tahunpelajaran_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Tahun Pelajaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tahun Pelajaran.');
        }
        redirect('admin/masterdata/tahunpelajaran');
    }





    //FUNGSI TINGKAT
    public function tingkat()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['tingkat']        = $this->Tingkat_Model->get_tingkat();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $this->load->view('admin/tingkat', $data);
    }


    public function get_tingkat()
    {
        $tingkat_id   = $this->input->get('tingkat_id');
        $tingkat      = $this->Tingkat_Model->get_tingkat_by_id($tingkat_id);
        echo json_encode(array('tingkat' => $tingkat));
    }


    public function simpan_tingkat()
    {
        $nama_tingkat = $this->input->post('nama_tingkat');
        $existing_tingkat = $this->Tingkat_Model->get_tingkat_by_nama($nama_tingkat);

        if ($existing_tingkat) {
            $this->session->set_flashdata('error_message', 'Tingkat sudah tersedia. Silakan gunakan nama tingkat lain.');
            redirect('admin/masterdata/tingkat');
            return;
        }

        $insert_data = array(
            'nama_tingkat' => $nama_tingkat
        );

        $insert_result = $this->Tingkat_Model->simpan_tingkat($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data tingkat berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data tingkat.');
        }

        redirect('admin/masterdata/tingkat');
    }

    public function update_tingkat()
    {
        $tingkat_id   = $this->input->post('editTingkatId');
        $data       = array(
            'nama_tingkat'     => $this->input->post('editNamaTingkat')
        );
        $result = $this->Tingkat_Model->update_tingkat($tingkat_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Tingkat berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Tingkat');
            echo json_encode(array('success' => false));
        }
    }

    public function hapus_tingkat($tingkat_id)
    {
        $result = $this->Tingkat_Model->hapus_tingkat($tingkat_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Tingkat berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Tingkat.');
        }
        redirect('admin/masterdata/tingkat');
    }








    // FUNGSI KELAS
    public function kelas()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['kelas']          = $this->Kelas_Model->get_kelas('nama_kelas');
        $data['tingkat']        = $this->Tingkat_Model->get_tingkat();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['ptk']            = $this->Ptk_Model->get_ptk();
        $this->load->view('admin/kelas', $data);
    }


    public function get_kelas()
    {
        $kelas_id   = $this->input->get('kelas_id');
        $kelas      = $this->Kelas_Model->get_kelas_by_id($kelas_id);
        echo json_encode(array('kelas' => $kelas));
    }

    public function ceksimpan_kelas(){
        $id_guru = $_POST['id_guru'];

        $cekwali = $this->Kelas_Model->cekwali($id_guru);
        if($cekwali->num_rows() > 0){
            echo json_encode("ada");
        } else {
            echo json_encode("tidak_ada");
        }
    }

    public function simpan_kelas()
    {
        $nama_kelas   = $this->input->post('nama_kelas');
        $no_kelas     = $this->input->post('no_kelas');
        $kode_tingkat = $this->input->post('kode_tingkat');
        $id_guru = $this->input->post('id_guru');

        $existing_kelas = $this->Kelas_Model->get_kelas_by_no($no_kelas);
        if ($existing_kelas) {
            $this->session->set_flashdata('error_message', 'Kode kelas sudah Tersedia. Silakan gunakan kode kelas lain.');
            redirect('admin/masterdata/kelas');
            return;
        }
        $insert_data = array(
            'nama_kelas'    => $nama_kelas,
            'no_kelas'      => $no_kelas,
            'kode_tingkat'  => $kode_tingkat,
            'id_guru'  => $id_guru,
        );
        $insert_result = $this->Kelas_Model->simpan_kelas($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Kelas berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Kelas.');
        }
        redirect('admin/masterdata/kelas');
    }

    public function update_kelas()
    {

        $id_guru = $_POST['edit_id_guru'];

        $kelas_id   = $this->input->post('editKelasId');

        $cekwali = $this->Kelas_Model->cekwali($id_guru, $kelas_id);
        if($cekwali->num_rows() > 0){
            echo json_encode("ada");die;
        } else {
            // echo json_encode("tidak_ada");
        }

        $data       = array(
            'nama_kelas'          => $this->input->post('editNamaKelas'),
            'kode_tingkat'        => $this->input->post('editKodeTingkat'),
            'id_guru'        => $this->input->post('edit_id_guru')
        );
        $result = $this->Kelas_Model->update_kelas($kelas_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Kelas berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Kelas');
            echo json_encode(array('success' => false));
        }
    }


    public function hapus_kelas($kelas_id)
    {
        if (is_null($kelas_id) || !is_numeric($kelas_id)) {
            $this->session->set_flashdata('error_message', 'ID Kelas tidak valid.');
            redirect('admin/masterdata/kelas');
            return;
        }

        // Coba hapus kelas
        $kelas = $this->Kelas_Model->get_kelas_by_id($kelas_id);
        if ($kelas && $this->Kelas_Model->is_kelas_digunakan($kelas->no_kelas)) {
            $this->session->set_flashdata('error_message', 'Gagal menghapus kelas karena masih digunakan oleh siswa.');
        } else {
            $result = $this->Kelas_Model->hapus_kelas($kelas_id);
            if ($result) {
                $this->session->set_flashdata('success_message', 'Kelas berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menghapus kelas.');
            }
        }
        redirect('admin/masterdata/kelas');
    }






    //FUNGSI MAPEL
    public function mapel()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['mapel']          = $this->Mapel_Model->get_mapel();

        $this->load->view('admin/mapel', $data);
    }

    //FUNGSI Metode
    public function metodepembayaran()
    {
        $logo_data              = $this->admin->get_logo();
        $data['logo']           = $logo_data['logo'];
        $data['current_user']   = $this->auth_admin->current_user();
        $data['profilsekolah']  = $this->admin->get_profilsekolah_data();
        $data['metode']          = $this->admin->get_metode_pembayaran();
        $data['kategori']          = $this->admin->get_kategori_metode_pembayaran();

        $this->load->view('admin/metodepembayaran', $data);
    }


    public function get_mapel()
    {
        $mapel_id   = $this->input->get('mapel_id');
        $mapel      = $this->Mapel_Model->get_mapel_by_id($mapel_id);
        echo json_encode(array('mapel' => $mapel));
    }
    public function get_metode()
    {
        $metodeid   = $this->input->get('metodeid');
        $metode      = $this->admin->get_metode_by_id($metodeid);
        echo json_encode(array('metode' => $metode));
    }


    public function simpan_mapel()
    {
        $nama_mapel         = $this->input->post('nama_mapel');
        $kelompok_mapel     = $this->input->post('kelompok_mapel');
        $nourut_mapel       = $this->input->post('nourut_mapel');
        $existing_mapel     = $this->Mapel_Model->get_mapel_by_nama($nama_mapel);

        if ($existing_mapel) {
            $this->session->set_flashdata('error_message', 'Mapel sudah tersedia. Silakan gunakan nama Mapel lain.');
            redirect('admin/masterdata/mapel');
            return;
        }

        $insert_data = array(
            'nama_mapel'        => $nama_mapel,
            'kelompok_mapel'    => $kelompok_mapel,
            'nourut_mapel'      => $nourut_mapel
        );

        $insert_result = $this->Mapel_Model->simpan_mapel($insert_data);
        if ($insert_result) {
            $this->session->set_flashdata('success_message', 'Data Mapel berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menyimpan data Mapel.');
        }

        redirect('admin/masterdata/mapel');
    }

    public function simpan_metode()
    {
        $nama         = $this->input->post('nama');
        $kode     = $this->input->post('kode');
        $id_kategori       = $this->input->post('id_kategori');
        $min       = $this->input->post('min');
        $max       = $this->input->post('max');
        $biayaadmin       = $this->input->post('biayaadmin');
        $status       = $this->input->post('status');
        // $logo       = $this->input->post('logo');

        $upload_path = './upload/payment/';


        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|png|JPG|PNG'; // Izinkan file pdf dan word
        $config['max_size'] = 70240; // Ukuran maksimal dalam KB
        $config['file_name'] = 'LogoPayment' . date('YmdHis');

        // Inisialisasi konfigurasi upload
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('logo')) {
            // Jika gagal unggah file
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error_message', 'Gagal mengunggah file: ' . $error);
            redirect('admin/masterdata/metodepembayaran');
            
        } else {
            // Jika berhasil unggah file
            $upload_data = $this->upload->data();
            $file_path = $upload_data['file_name'];

            $insert_data = array(
                'nama'        => $nama,
                'kode'    => $kode,
                'id_kategori'      => $id_kategori,
                'min'      => $min,
                'max'      => $max,
                'biayaadmin'      => $biayaadmin,
                'status'      => $status,
                'logo'      => $file_path,
            );

            $insert_result = $this->admin->simpan_metode($insert_data);
            if ($insert_result) {
                $this->session->set_flashdata('success_message', 'Data Metode berhasil disimpan.');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menyimpan data Metode.');
            }

            redirect('admin/masterdata/metodepembayaran');
        }

        
    }




    public function update_mapel()
    {
        $mapel_id   = $this->input->post('editMapelId');

        $data       = array(
            'nama_mapel'        => $this->input->post('editNamaMapel'),
            'kelompok_mapel'    => $this->input->post('editKelompokMapel'),
            'nourut_mapel'      => $this->input->post('editNourutMapel')

        );
        $result = $this->Mapel_Model->update_mapel($mapel_id, $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data Mapel berhasil diperbarui.');
            echo json_encode(array('success' => true));
        } else {
            $this->session->set_flashdata('error_message', 'Tidak ada perubahan Mapel');
            echo json_encode(array('success' => false));
        }
    }

    public function update_metode()
    {
        $metodeid   = $this->input->post('editMetodeId');

        $nama         = $this->input->post('editNama');
        $kode     = $this->input->post('editKode');
        $id_kategori       = $this->input->post('editId_kategori');
        $min       = $this->input->post('editMin');
        $max       = $this->input->post('editMax');
        $biayaadmin       = $this->input->post('editBiayaadmin');
        $status       = $this->input->post('editStatus');

        if (isset($_FILES['editlogo']) && $_FILES['editlogo']['error'] !== UPLOAD_ERR_NO_FILE) {

            $upload_path = './upload/payment/';


            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|png|JPG|PNG'; // Izinkan file pdf dan word
            $config['max_size'] = 70240; // Ukuran maksimal dalam KB
            $config['file_name'] = 'LogoPayment' . date('YmdHis');

            // Inisialisasi konfigurasi upload
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('editlogo')) {
                // Jika gagal unggah file
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', 'Gagal mengunggah file: ' . $error);
                // redirect('admin/masterdata/metodepembayaran');
                echo json_encode(array('success' => false,'eror'=>$error));

                
            } else {
                // Jika berhasil unggah file
                $upload_data = $this->upload->data();
                $file_path = $upload_data['file_name'];

                $data = array(
                    'nama'        => $nama,
                    'kode'    => $kode,
                    'id_kategori'      => $id_kategori,
                    'min'      => $min,
                    'max'      => $max,
                    'biayaadmin'      => $biayaadmin,
                    'status'      => $status,
                    'logo'      => $file_path,
                );

                $result = $this->admin->update_metode($metodeid, $data);
                if ($result) {
                    $this->session->set_flashdata('success_message', 'Data Metode berhasil disimpan.');
                    echo json_encode(array('success' => true));

                } else {
                    $this->session->set_flashdata('error_message', 'Gagal menyimpan data Metode.');
                    echo json_encode(array('success' => false));

                }

                // redirect('admin/masterdata/metodepembayaran');
            }
        } else{
            $data       = array(
                'nama'        => $nama,
                'kode'    => $kode,
                'id_kategori'      => $id_kategori,
                'min'      => $min,
                'max'      => $max,
                'biayaadmin'      => $biayaadmin,
                'status'      => $status,

            );
            $result = $this->admin->update_metode($metodeid, $data);

            if ($result) {
                $this->session->set_flashdata('success_message', 'Data Metode berhasil diperbarui.');
                echo json_encode(array('success' => true));
            } else {
                $error = $this->db->error();
                $this->session->set_flashdata('error_message', 'Tidak ada perubahan Metode');
                echo json_encode(array('success' => false, "error"=>$error));
            }
        }

        
    }



    public function hapus_mapel($mapel_id)
    {
        $result = $this->Mapel_Model->hapus_mapel($mapel_id);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Mapel berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Mapel.');
        }
        redirect('admin/masterdata/mapel');
    }
    public function hapus_metode($metodeid)
    {
        // sdfsdsd
        $result = $this->admin->hapus_metode($metodeid);
        if ($result) {
            $this->session->set_flashdata('error_message', 'Metode berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus Mapel.');
        }
        redirect('admin/masterdata/metodepembayaran');
    }
}
