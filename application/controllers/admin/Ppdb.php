<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ppdb extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin');
        $this->load->model('Ppdb_Model');
        $this->load->model('auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');
        $this->load->library('form_validation');

        $current_user = $this->auth_admin->current_user();
        if (!$current_user) {
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginadmin');
        }

        if ($current_user->role != 'admin') {
            show_error('Anda tidak diizinkan mengakses resources ini', 403, 'Akses Ditolak');
        }
    }

    // Setting PPDB
    public function settingppdb()
    {
        $data['setting_ppdb'] = $this->Ppdb_Model->get_setting();
        $data['jalur_ppdb'] = $this->Ppdb_Model->get_all_jalur();

        // Hitung kuota per jalur jika multi jalur aktif
        if ($data['setting_ppdb'] && $data['setting_ppdb']->is_multi_jalur == 1) {
            $data['kuota_per_jalur'] = $this->Ppdb_Model->get_kuota_per_jalur($data['setting_ppdb']->kuota);
        }

        $data['current_user'] = $this->auth_admin->current_user();
        $data['logo'] = $this->admin->get_logo()['logo'];
        $data['logopemerintah'] = $this->admin->get_logopemerintah()['logopemerintah'];
        $data['profilsekolah'] = $this->admin->get_profilsekolah_data();

        $this->load->view('admin/ppdb/settingppdb', $data);
    }

    // Update Setting PPDB
    public function update_setting()
    {
        $this->form_validation->set_rules('status_ppdb', 'Status PPDB', 'required|in_list[0,1]');
        $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required|callback_validate_date');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required|callback_validate_date|callback_validate_date_range');
        $this->form_validation->set_rules('kuota', 'Kuota', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('is_multi_jalur', 'Multi Jalur', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_message', validation_errors());
            redirect('admin/ppdb/settingppdb');
        }

        // Dapatkan data lama untuk log
        $old_setting = $this->Ppdb_Model->get_setting();

        $data = [
            'status_ppdb' => $this->input->post('status_ppdb', TRUE),
            'tahun_ajaran' => $this->input->post('tahun_ajaran', TRUE),
            'tanggal_mulai' => $this->input->post('tanggal_mulai', TRUE),
            'tanggal_selesai' => $this->input->post('tanggal_selesai', TRUE),
            'kuota' => $this->input->post('kuota', TRUE),
            'is_multi_jalur' => $this->input->post('is_multi_jalur', TRUE),
            'pesan' => $this->input->post('pesan', TRUE),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Ppdb_Model->update_setting($data)) {
            // Log perubahan
            $this->Ppdb_Model->add_log([
                'action' => 'update',
                'table' => 'ppdb_setting',
                'record_id' => $old_setting->id,
                'old_value' => $old_setting,
                'new_value' => $data
            ]);

            $this->session->set_flashdata('success_message', 'Setting PPDB berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal memperbarui setting PPDB');
        }
        redirect('admin/ppdb/settingppdb');
    }

    // Callback validasi tanggal
    public function validate_date($date)
    {
        if (!DateTime::createFromFormat('Y-m-d', $date)) {
            $this->form_validation->set_message('validate_date', 'Format tanggal {field} tidak valid (YYYY-MM-DD)');
            return false;
        }
        return true;
    }

    // Callback validasi range tanggal
    public function validate_date_range($end_date)
    {
        $start_date = $this->input->post('tanggal_mulai');
        if (strtotime($end_date) <= strtotime($start_date)) {
            $this->form_validation->set_message('validate_date_range', 'Tanggal selesai harus setelah tanggal mulai');
            return false;
        }
        return true;
    }

    // Kelola Jalur PPDB
    public function save_jalur()
    {
        $this->form_validation->set_rules('nama_jalur', 'Nama Jalur', 'required|max_length[100]');
        $this->form_validation->set_rules('persentase_kuota', 'Persentase Kuota', 'required|numeric|less_than_equal_to[100]|greater_than[0]');
        $this->form_validation->set_rules('persyaratan', 'Persyaratan', 'required|max_length[250]');
        $this->form_validation->set_rules('ketentuan', 'Ketentuan', 'required|max_length[250]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_message', validation_errors());
            redirect('admin/ppdb/settingppdb');
        }

        $data = [
            'nama_jalur'        => $this->input->post('nama_jalur', TRUE),
            'persentase_kuota'  => $this->input->post('persentase_kuota', TRUE),
            'persyaratan'       => $this->input->post('persyaratan', TRUE),
            'ketentuan'         => $this->input->post('ketentuan', TRUE),

            'is_active' => $this->input->post('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Jika edit jalur
        if ($this->input->post('id')) {
            $id = $this->input->post('id', TRUE);
            $old_jalur = $this->Ppdb_Model->get_jalur_by_id($id);

            if ($this->Ppdb_Model->update_jalur($id, $data)) {
                // Log perubahan
                $this->Ppdb_Model->add_log([
                    'action' => 'update',
                    'table' => 'ppdb_jalur',
                    'record_id' => $id,
                    'old_value' => $old_jalur,
                    'new_value' => $data
                ]);

                $this->session->set_flashdata('success_message', 'Jalur PPDB berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal memperbarui jalur PPDB');
            }
        }
        // Jika tambah jalur baru
        else {
            $data['created_at'] = date('Y-m-d H:i:s');

            if ($id = $this->Ppdb_Model->insert_jalur($data)) {
                // Log perubahan
                $this->Ppdb_Model->add_log([
                    'action' => 'insert',
                    'table' => 'ppdb_jalur',
                    'record_id' => $id,
                    'new_value' => $data
                ]);

                $this->session->set_flashdata('success_message', 'Jalur PPDB berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menambahkan jalur PPDB');
            }
        }

        redirect('admin/ppdb/settingppdb');
    }

    // Toggle status jalur
    public function toggle_jalur($id)
    {
        $id = (int)$id;
        $jalur = $this->Ppdb_Model->get_jalur_by_id($id);

        if (!$jalur) {
            $this->session->set_flashdata('error_message', 'Jalur tidak ditemukan');
            redirect('admin/ppdb/settingppdb');
        }

        $new_status = $jalur->is_active ? 0 : 1;

        if ($this->Ppdb_Model->update_jalur_status($id, $new_status)) {
            // Log perubahan
            $this->Ppdb_Model->add_log([
                'action' => 'update',
                'table' => 'ppdb_jalur',
                'record_id' => $id,
                'old_value' => ['is_active' => $jalur->is_active],
                'new_value' => ['is_active' => $new_status]
            ]);

            $message = $new_status ? 'Jalur diaktifkan' : 'Jalur dinonaktifkan';
            $this->session->set_flashdata('success_message', $message);
        } else {
            $this->session->set_flashdata('error_message', 'Gagal mengubah status jalur');
        }

        redirect('admin/ppdb/settingppdb');
    }

    // Hapus jalur
    public function delete_jalur($id)
    {
        $id = (int)$id;
        $jalur = $this->Ppdb_Model->get_jalur_by_id($id);

        if (!$jalur) {
            $this->session->set_flashdata('error_message', 'Jalur tidak ditemukan');
            redirect('admin/ppdb/settingppdb');
        }

        // Dapatkan setting untuk cek apakah jalur utama
        $setting = $this->Ppdb_Model->get_setting();

        // Jika bukan multi jalur dan mencoba hapus jalur utama
        if ($setting->is_multi_jalur == 0 && $id == 1) {
            $this->session->set_flashdata('error_message', 'Tidak dapat menghapus jalur utama ketika mode single jalur aktif');
            redirect('admin/ppdb/settingppdb');
        }

        if ($this->Ppdb_Model->delete_jalur($id)) {
            // Log perubahan
            $this->Ppdb_Model->add_log([
                'action' => 'delete',
                'table' => 'ppdb_jalur',
                'record_id' => $id,
                'old_value' => $jalur
            ]);

            $this->session->set_flashdata('success_message', 'Jalur PPDB berhasil dihapus');
        } else {
            $this->session->set_flashdata('error_message', 'Gagal menghapus jalur PPDB');
        }

        redirect('admin/ppdb/settingppdb');
    }






    // Kelola Pendaftaran
    public function pendaftaran()
    {
        $data['pendaftaran'] = $this->Ppdb_Model->get_all_pendaftar();
        $data['jalur_options'] = $this->Ppdb_Model->get_active_jalur();
        $data['current_user'] = $this->auth_admin->current_user();
        $data['logo'] = $this->admin->get_logo()['logo'];
        $data['profilsekolah'] = $this->admin->get_profilsekolah_data();

        $this->load->view('admin/ppdb/pendaftar', $data);
    }

    // Detail Pendaftaran
    public function detail_pendaftaran($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            show_404();
        }

        // Ambil data pendaftaran
        $data['pendaftaran'] = $this->Ppdb_Model->get_pendaftar_by_id($id);

        // Jika data tidak ditemukan
        if (!$data['pendaftaran']) {
            show_404();
        }

        // Ambil data lain
        $data['current_user'] = $this->auth_admin->current_user();
        $data['logo'] = $this->admin->get_logo()['logo'] ?? '';
        $data['profilsekolah'] = $this->admin->get_profilsekolah_data();

        // Load view
        $this->load->view('admin/ppdb/detail_pendaftaran', $data);
    }


    // Update Status Pendaftaran
    public function update_status_pendaftaran($id)
    {
        $status = $this->input->get('status'); // pakai get()

        if (in_array($status, ['pending', 'terverifikasi', 'diterima', 'ditolak'])) {
            $this->Ppdb_Model->update_status_pendaftar($id, $status);
            $this->session->set_flashdata('success_message', 'Status pendaftaran berhasil diupdate');
        } else {
            $this->session->set_flashdata('error_message', 'Status tidak valid');
        }

        redirect('admin/ppdb/pendaftaran');
    }


    // Hapus Pendaftaran
    public function hapus_pendaftaran($id)
    {
        $pendaftaran = $this->Ppdb_Model->get_pendaftar_by_id($id);
        if (!$pendaftaran) {
            $this->session->set_flashdata('error_message', 'Pendaftaran tidak ditemukan');
            redirect('admin/ppdb/pendaftaran');
        }

        // Hapus data
        $this->Ppdb_Model->delete_pendaftaran($id);

        // Set flashdata untuk notifikasi sukses
        $this->session->set_flashdata('delete_success', 'Data pendaftaran berhasil dihapus'); // Gunakan key 'delete_success'

        // Redirect kembali ke daftar pendaftaran
        redirect('admin/ppdb/pendaftaran');
    }




    // Laporan PPDB
    public function laporan()
    {
        $data['total_pendaftar'] = $this->Pendaftaran_Model->count_all();
        $data['pendaftar_diterima'] = $this->Pendaftaran_Model->count_by_status('diterima');
        $data['pendaftar_ditolak'] = $this->Pendaftaran_Model->count_by_status('ditolak');
        $data['pendaftar_pending'] = $this->Pendaftaran_Model->count_by_status('pending');
        $data['pendaftar_per_jalur'] = $this->Pendaftaran_Model->count_by_jalur();
        $data['current_user'] = $this->auth_admin->current_user();

        $this->load->view('admin/ppdb/laporan', $data);
    }

    // Export Data
    public function export()
    {
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Ambil data dari model PTK
        $data = $this->Ppdb_Model->get_all_pendaftar();

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Data SPMB")
            ->setSubject("Data SPMB")
            ->setDescription("Laporan data SPMB")
            ->setKeywords("SPMB excel")
            ->setCategory("Laporan");

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'NO');
        $sheet->setCellValue('B1', 'NO PENDAFTARAN');
        $sheet->setCellValue('C1', 'NO PESERTA UJIAN');
        $sheet->setCellValue('D1', 'NAMA LENGKAP');
        $sheet->setCellValue('E1', 'JK');
        $sheet->setCellValue('F1', 'NISN');
        $sheet->setCellValue('G1', 'NIK');
        $sheet->setCellValue('H1', 'NO KK');
        $sheet->setCellValue('I1', 'JALUR');
        $sheet->setCellValue('J1', 'NILAI IJAZAH');
        $sheet->setCellValue('K1', 'PRESTASI');
        $sheet->setCellValue('L1', 'TEMPAT LAHIR');
        $sheet->setCellValue('M1', 'TANGGAL LAHIR');
        $sheet->setCellValue('N1', 'AGAMA');
        $sheet->setCellValue('O1', 'ASAL SEKOLAH');
        $sheet->setCellValue('P1', 'ALAMAT');
        $sheet->setCellValue('Q1', 'RT');
        $sheet->setCellValue('R1', 'RW');
        $sheet->setCellValue('S1', 'KELURAHAN');
        $sheet->setCellValue('T1', 'KECAMATAN');
        $sheet->setCellValue('U1', 'KABUPATEN');
        $sheet->setCellValue('V1', 'STATUS ORTU');
        $sheet->setCellValue('W1', 'ANAK KE');
        $sheet->setCellValue('X1', 'JUMLAH SAUDARA');
        $sheet->setCellValue('Y1', 'NAMA AYAH');
        $sheet->setCellValue('Z1', 'PEKERJAAN AYAH');
        $sheet->setCellValue('AA1', 'PENDIDIKAN AYAH');
        $sheet->setCellValue('AB1', 'NAMA IBU');
        $sheet->setCellValue('AC1', 'PEKERJAAN IBU');
        $sheet->setCellValue('AD1', 'PENDIDIKAN IBU');
        $sheet->setCellValue('AE1', 'TELP ORTU');
        $sheet->setCellValue('AF1', 'STATUS');
        $sheet->setCellValue('AG1', 'FOTO');
        $sheet->setCellValue('AH1', 'TAHUN LULUS');

        // Set auto width untuk semua kolom
        $columns = array_merge(range('A', 'Z'), ['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH']);
        foreach ($columns as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }


        // Isi data
        $row = 2;
        $no = 1;
        foreach ($data as $d) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d->no_pendaftaran);
            $sheet->setCellValue('C' . $row, $d->no_peserta_ujian);
            $sheet->setCellValue('D' . $row, $d->nama_lengkap);
            $sheet->setCellValue('E' . $row, $d->jenis_kelamin);
            $sheet->setCellValueExplicit('F' . $row, $d->nisn, PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' . $row, $d->nik, PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('H' . $row, $d->no_kk, PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue('I' . $row, $d->nama_jalur);
            $sheet->setCellValue('J' . $row, $d->rata_nilai_ijazah);
            $sheet->setCellValue('K' . $row, $d->prestasi);
            $sheet->setCellValue('L' . $row, $d->tempat_lahir);
            $sheet->setCellValue('M' . $row, $d->tanggal_lahir);
            $sheet->setCellValue('N' . $row, $d->agama);
            $sheet->setCellValue('O' . $row, $d->asal_sekolah);
            $sheet->setCellValue('P' . $row, $d->alamat);
            $sheet->setCellValue('Q' . $row, $d->rt);
            $sheet->setCellValue('R' . $row, $d->rw);
            $sheet->setCellValue('S' . $row, $d->kelurahan);
            $sheet->setCellValue('T' . $row, $d->kecamatan);
            $sheet->setCellValue('U' . $row, $d->kabupaten);
            $sheet->setCellValue('V' . $row, $d->status_ortu);
            $sheet->setCellValue('W' . $row, $d->anakke);
            $sheet->setCellValue('X' . $row, $d->jumlah_saudara);
            $sheet->setCellValue('Y' . $row, $d->nama_ayah);
            $sheet->setCellValue('Z' . $row, $d->pekerjaan_ayah);
            $sheet->setCellValue('AA' . $row, $d->pendidikan_ayah);
            $sheet->setCellValue('AB' . $row, $d->nama_ibu);
            $sheet->setCellValue('AC' . $row, $d->pekerjaan_ibu);
            $sheet->setCellValue('AD' . $row, $d->pendidikan_ibu);
            $sheet->setCellValueExplicit('AE' . $row, $d->telp_ortu, PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValue('AF' . $row, $d->status);
            $sheet->setCellValue('AG' . $row, $d->foto_siswa);
            $sheet->setCellValue('AH' . $row, $d->tahun_lulus);


            $row++;
        }

        // Nama file
        $filename = "Data_SPMB_" . date('YmdHis') . ".xlsx";

        // Output ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
}
