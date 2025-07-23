<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Materi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ptk');
        $this->load->model('Auth_ptk');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('text'); // ✅ Tambahkan ini untuk fungsi character_limiter

        if (!$this->Auth_ptk->current_user()) {
            redirect('auth/loginptk');
        }
    }

    public function index()
    {
        $logo_data = $this->Ptk->get_logo();
        $current_user = $this->Auth_ptk->current_user();
        $id_guru = $current_user->id_guru;

        $data = [
            "current_user"     => $current_user,
            "profilsekolah"    => $this->Ptk->get_profilsekolah_data(),
            "logo"             => $logo_data['logo'],
            "materi"           => $this->Ptk->get_materi_by_guru($id_guru),
            "mapel"            => $this->Ptk->get_mapel_mengajar($id_guru),
            "kelas"            => $this->Ptk->get_kelasmengajar($id_guru)
        ];

        $this->load->view('ptk/elearning/materi_index', $data);
    }



    public function detail($id_materi)
    {
        $logo_data = $this->Ptk->get_logo();
        $current_user = $this->Auth_ptk->current_user();
        $id_guru = $current_user->id_guru;

        // Ambil detail materi
        $materi = $this->Ptk->get_detail_materi($id_materi);

        // Ambil daftar tugas dari materi
        $tugas = $this->Ptk->get_tugas_by_materi($id_materi);

        // Ambil siswa yang mengerjakan
        $siswa_mengerjakan = $this->Ptk->get_siswa_yang_mengerjakan($id_materi);

        // Ambil jawaban dan nilai PG jika tugas jenis PG
        foreach ($tugas as &$t) {
            $t->jawaban = $this->Ptk->get_jawaban_by_tugas($t->id_tugas);

            // Cek jika jenis tugas adalah pilihan ganda (PG)
            if (strtolower($t->jenis_tugas) == 'pg') {
                // Ambil semua soal PG berdasarkan id_tugas
                $soal_pg = $this->Ptk->get_soal_pg_by_tugas($t->id_tugas);

                // Simpan kunci jawaban dalam array [id_soal => jawaban_benar]
                $kunci_jawaban = [];
                foreach ($soal_pg as $soal) {
                    $kunci_jawaban[$soal->id_soal] = strtoupper(trim($soal->jawaban_benar));
                }

                // Ambil semua jawaban siswa untuk tugas ini
                $jawaban_pg = $this->Ptk->get_jawaban_pg_by_tugas($t->id_tugas);

                // Hitung jumlah soal PG
                $jumlah_soal = count($soal_pg);

                // Hitung skor per siswa
                $skor_siswa = []; // Format: [id_siswa => total_benar]

                foreach ($jawaban_pg as $j) {
                    $id_siswa = $j->id_siswa;
                    $id_soal  = $j->id_soal;
                    $jawaban  = strtoupper(trim($j->jawaban));
                    $kunci    = $kunci_jawaban[$id_soal] ?? '';

                    if (!isset($skor_siswa[$id_siswa])) {
                        $skor_siswa[$id_siswa] = 0;
                    }

                    if ($jawaban === $kunci) {
                        $skor_siswa[$id_siswa]++;
                    }
                }

                // Simpan hasil nilai PG dalam bentuk persen
                $t->nilai_pg = []; // Format: [id_siswa => skor_persen]
                foreach ($skor_siswa as $id_siswa => $jumlah_benar) {
                    $t->nilai_pg[$id_siswa] = round(($jumlah_benar / $jumlah_soal) * 100, 2); // dua angka desimal
                }
            }
        }

        $data = [
            "current_user"        => $current_user,
            "profilsekolah"       => $this->Ptk->get_profilsekolah_data(),
            "logo"                => $logo_data['logo'],
            "materi"              => $materi,
            "tugas"               => $tugas,
            "siswa_mengerjakan"   => $siswa_mengerjakan
        ];

        $this->load->view('ptk/elearning/materi_detail', $data);
    }





    public function tambah_materi()
    {
        // Validasi form
        $this->form_validation->set_rules('judul_materi', 'Judul Materi', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('mapel', 'Mata Pelajaran', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_message', validation_errors());
            redirect('ptk/materi');
        } else {
            // Jika validasi berhasil, simpan materi
            $data = [
                'judul_materi' => $this->input->post('judul_materi'),
                'deskripsi'    => $this->input->post('deskripsi'),
                'id_mapel'     => $this->input->post('mapel'),
                'id_guru'      => $this->Auth_ptk->current_user()->id_guru,
                'id_kelas'     => $this->input->post('kelas'),
                'link_google_drive'     => $this->input->post('link_google_drive'),
                'tanggal_dibuat' => date('Y-m-d H:i:s')
            ];

            $insert_id = $this->Ptk->tambah_materi($data);

            if ($insert_id) {
                $this->session->set_flashdata('success_message', 'Materi berhasil ditambahkan!');
                redirect('ptk/materi');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menambahkan materi. Coba lagi.');
                redirect('ptk/materi');
            }
        }
    }

    public function update_materi()
    {
        $id_materi = $this->input->post('id_materi');
        $data = [
            'judul_materi' => $this->input->post('judul_materi'),
            'deskripsi'    => $this->input->post('deskripsi'),
            'id_mapel'     => $this->input->post('mapel'),
            'id_kelas'     => $this->input->post('kelas'),
            'link_google_drive' => $this->input->post('link_google_drive')
        ];

        $this->db->where('id_materi', $id_materi);
        $this->db->update('materi', $data);

        $this->session->set_flashdata('success_message', 'Materi berhasil diperbarui.');
        redirect('ptk/materi');
    }



    public function hapus_materi_ajax()
    {
        $id = $this->input->post('id_materi');

        $materi = $this->db->get_where('materi', ['id_materi' => $id])->row_array();

        if (!$materi) {
            echo json_encode(['status' => 'error', 'message' => 'Materi tidak ditemukan.']);
            return;
        }

        $this->db->trans_start();
        $this->db->delete('materi', ['id_materi' => $id]);
        $this->db->trans_complete();

        $db_error = $this->db->error();

        if ($db_error['code'] != 0) {
            // Kirim pesan error asli dari DB, misal FK constraint
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menghapus materi: ' . $db_error['message']
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Materi berhasil dihapus.'
            ]);
        }
    }




    public function simpan_tugas()
    {
        $id_materi = $this->input->post('id_materi');
        $jenis_tugas = $this->input->post('jenis_tugas');

        // Data umum untuk tugas
        $data = [
            'id_materi' => $id_materi,
            'judul_tugas' => $this->input->post('judul_tugas'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal_deadline' => $this->input->post('tanggal_deadline'),
            'tanggal_dibuat' => date('Y-m-d H:i:s'),
            'jenis_tugas' => $jenis_tugas
        ];

        // Menyimpan data tugas
        $this->db->insert('tugas_materi', $data);
        $id_tugas = $this->db->insert_id();  // Ambil ID tugas yang baru saja disimpan

        // Jika jenis tugas adalah PG, simpan soal-soal pilihan ganda
        if ($jenis_tugas == 'PG') {
            $soal_pg = $this->input->post('soal_pg');
            $jawaban_a = $this->input->post('jawaban_a');
            $jawaban_b = $this->input->post('jawaban_b');
            $jawaban_c = $this->input->post('jawaban_c');
            $jawaban_d = $this->input->post('jawaban_d');
            $jawaban_benar = $this->input->post('jawaban_benar');

            // Loop untuk menyimpan setiap soal PG
            for ($i = 0; $i < count($soal_pg); $i++) {
                $soal_data = [
                    'id_tugas' => $id_tugas,
                    'soal' => $soal_pg[$i],
                    'jawaban_a' => $jawaban_a[$i],
                    'jawaban_b' => $jawaban_b[$i],
                    'jawaban_c' => $jawaban_c[$i],
                    'jawaban_d' => $jawaban_d[$i],
                    'jawaban_benar' => $jawaban_benar[$i]
                ];
                $this->db->insert('soal_pg', $soal_data);  // Simpan soal ke tabel soal_pg
            }
        }

        // Jika ada lampiran, upload seperti biasa
        if (!empty($_FILES['lampiran']['name'])) {
            $config['upload_path'] = './upload/tugas/';
            $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png|zip';
            $config['max_size'] = 2048;
            $config['file_name'] = 'Tugas_' . date('YmdHis');

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('lampiran')) {
                $upload_data = $this->upload->data();
                $data['lampiran'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error_message', 'Gagal mengunggah file: ' . $error);
                redirect('ptk/materi/detail/' . $id_materi);
            }
        }

        $this->session->set_flashdata('success_message', 'Tugas berhasil disimpan');
        redirect('ptk/materi/detail/' . $id_materi);
    }


    public function hapus_tugas($id_tugas)
    {
        $tugas = $this->db->get_where('tugas_materi', ['id_tugas' => $id_tugas])->row();
        if (!$tugas) {
            show_404();
            return;
        }


        // Ambil ID soal terkait, misal:
        $soal_pg = $this->db->get_where('soal_pg', ['id_tugas' => $id_tugas])->result();

        // Hapus jawaban terkait setiap soal
        foreach ($soal_pg as $soal) {
            $this->db->delete('jawaban_pg', ['id_soal' => $soal->id_soal]);
        }

        // Hapus soal_pg terkait tugas
        $this->db->delete('soal_pg', ['id_tugas' => $id_tugas]);

        // Hapus jawaban_tugas yang berkaitan dengan tugas_materi
        $this->db->delete('jawaban_tugas', ['id_tugas' => $id_tugas]);


        // Hapus file lampiran jika ada
        if (!empty($tugas->lampiran) && file_exists('./upload/tugas/' . $tugas->lampiran)) {
            unlink('./upload/tugas/' . $tugas->lampiran);
        }

        // Baru hapus tugas_materi
        $this->db->delete('tugas_materi', ['id_tugas' => $id_tugas]);

        $this->session->set_flashdata('success_message', 'Tugas dan data terkait berhasil dihapus.');
        redirect('ptk/materi/detail/' . $tugas->id_materi);
    }

    public function beri_nilai_essay()
    {
        $id_tugas  = $this->input->post('id_tugas');
        $id_siswa  = $this->input->post('id_siswa');
        $nilai     = $this->input->post('nilai_essay');

        if ($id_tugas && $id_siswa && is_numeric($nilai)) {
            $this->db->where('id_tugas', $id_tugas)
                ->where('id_siswa', $id_siswa)
                ->update('jawaban_tugas', ['nilai_essay' => $nilai]);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
        }
        exit;
    }
}
