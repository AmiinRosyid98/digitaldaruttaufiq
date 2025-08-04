<?php

class Historypembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin');
        $this->load->model('Pembayaransiswa_Model');
        $this->load->model('Auth_admin');
        $this->load->library('pagination');
        $this->load->library('upload');

        $current_user = $this->Auth_admin->current_user();
        if (!$current_user) {
            $this->session->set_userdata('previous_page', current_url());
            redirect('auth/loginbendahara');
        }
        if ($current_user->role != 'bendahara') {
            $error_msg = 'Anda tidak diizinkan mengakses resources ini';
            show_error($error_msg, 403, 'Akses Ditolak');
        }
    }

    public function index()
    {
        $no_kelas = $this->input->get('kelas');
        $pos_keuangan = $this->input->get('poskeuangan');
        $tahun_pelajaran = $this->input->get('tahunpelajaran');

        // Mengambil data logo dari model admin
        $logo_data = $this->Admin->get_logo();
        // Mendapatkan data pengguna yang sedang login
        $data['current_user'] = $this->Auth_admin->current_user();
        // Menyimpan data logo ke array data untuk dikirim ke view
        $data['logo'] = $logo_data['logo'];
        // Mengambil data profil sekolah dari model admin
        $data['profilsekolah'] = $this->Admin->get_profilsekolah_data();
        // Mengambil sejarah pembayaran dari model Pembayaransiswa_Model
        if(($this->input->get('kelas')) != null){

            $data['historypembayaran'] = $this->Pembayaransiswa_Model->get_historypembayaran($no_kelas, $pos_keuangan, $tahun_pelajaran);
        } else {
            $data['historypembayaran'] = $this->Pembayaransiswa_Model->get_historypembayaran();
        }

        $queryString = $_SERVER['QUERY_STRING'];


        $data['kelas'] = $this->Pembayaransiswa_Model->get_kelas();
        $data['tahunpelajaran'] = $this->Pembayaransiswa_Model->get_tahunpelajaran();
        $data['poskeuangan']    = $this->Pembayaransiswa_Model->get_poskeuangan();

        // Menghitung total pembayaran dan sisa total tagihan
        $total_pembayaran = 0;
        $total_tagihan = 0;
        foreach ($data['historypembayaran'] as $history) {
            $total_pembayaran += $history['jumlah_pembayaran'];
            $total_tagihan += $history['jumlah_tarif'];
        }
        $sisa_total_tagihan = $total_tagihan - $total_pembayaran;
        $jumlah_tarif = $total_tagihan;

        // Menyimpan total pembayaran dan sisa total tagihan ke array data untuk dikirim ke view
        $data['jumlah_pembayaran']  = $total_pembayaran;
        $data['sisa_total_tagihan'] = $sisa_total_tagihan;
        $data['jumlah_tarif']       = $jumlah_tarif;
        $data['queryString']       = $queryString;

        // Memuat view bendahara/historypembayaran dengan data yang telah diproses
        $this->load->view('bendahara/historypembayaran', $data);
    }

    public function cetak_pdf()
    {
        // Load TCPDF
        require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');



        // Mengambil data untuk dicetak
        $data['logo'] = $this->Admin->get_logo()['logo'];
        $data['current_user'] = $this->Auth_admin->current_user();
        $data['profilsekolah'] = $this->Admin->get_profilsekolah_data();
        $data['historypembayaran'] = $this->Pembayaransiswa_Model->get_historypembayaran();

        $total_pembayaran = 0;
        $total_tagihan = 0;
        foreach ($data['historypembayaran'] as $history) {
            $total_pembayaran += $history['jumlah_pembayaran'];
            $total_tagihan += $history['jumlah_tarif'];
        }
        $data['total_pembayaran'] = $total_pembayaran;
        $data['total_tagihan'] = $total_tagihan;
        $data['sisa_total_tagihan'] = $total_tagihan - $total_pembayaran;

        // Membuat instance baru dari TCPDF
        $pdf = new TCPDF('P', 'pt', 'A4', true, 'UTF-8', false);

        // Mengatur informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Laporan History Pembayaran');
        $pdf->SetSubject('Laporan');
        $pdf->SetKeywords('TCPDF, PDF, laporan, pembayaran, siswa');

        // Mengatur margin
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // Menambahkan halaman baru
        $pdf->SetPrintHeader(false);

        $pdf->AddPage();
        // Menghasilkan konten HTML dari view
        $pdfContent = $this->load->view('bendahara/historypembayaran_pdf', $data, true);

        // Menambahkan HTML ke PDF
        $pdf->writeHTML($pdfContent, true, false, true, false, '');

        // Mengatur nama file PDF ketika dibuka di browser
        $pdf->Output('Laporan_History_Pembayaran.pdf', 'I');
    }


    public function cetak_laporankeuangan_by_kelas()
    {
        // Tangkap no_kelas dan tahun_ajaran dari request GET
        $no_kelas = $this->input->get('kelas');
        $pos_keuangan = $this->input->get('poskeuangan');
        $tahun_pelajaran = $this->input->get('tahunpelajaran');

        // Mengambil data untuk dicetak berdasarkan no_kelas dan tahun_ajaran
        $data['historypembayaran'] = $this->Pembayaransiswa_Model->get_historypembayaran_by_kelas($no_kelas, $pos_keuangan, $tahun_pelajaran);

        // Periksa jika data siswa kosong
        if (empty($data['historypembayaran'])) {
            $this->session->set_flashdata('error_message', 'Tidak ada data siswa yang ditemukan untuk kelas dan tahun pelajaran ini.');
            redirect('bendahara/historypembayaran'); // Ganti dengan URL yang sesuai
        }

        // Load TCPDF
        require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');

        $data['logo'] = $this->Admin->get_logo()['logo'];
        $data['current_user'] = $this->Auth_admin->current_user();
        $data['profilsekolah'] = $this->Admin->get_profilsekolah_data();

        // Render view to HTML content
        $pdfContent = $this->load->view('bendahara/cetak/rekap_pembayaran', $data, true);

        // Create new TCPDF instance
        $pdf = new TCPDF('L', 'pt', 'LEGAL', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Xcode');
        $pdf->SetTitle('Laporan History Pembayaran');
        $pdf->SetSubject('Laporan');
        $pdf->SetKeywords('TCPDF, PDF, laporan, pembayaran, siswa');

        // Set margins
        $pdf->SetMargins(20, 20, 20);

        // Enable auto page break mode
        $pdf->SetAutoPageBreak(true, 25);

        // Disable header and footer
        $pdf->SetPrintHeader(false);

        // Add a page
        $pdf->AddPage();

        // Add HTML content to PDF
        $pdf->writeHTML($pdfContent, true, false, true, false, '');

        // Output PDF to browser ('I' untuk tampilkan, 'D' untuk unduh, 'F' untuk simpan di server)
        $pdf->Output('Laporan_History_Pembayaran.pdf', 'I');
    }
}
