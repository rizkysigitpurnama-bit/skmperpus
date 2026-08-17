<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Controller.php';

/** Dipakai di view admin/dashboard.php */
function predikatIkm($nilai) {
    if ($nilai >= 88.31) return "SANGAT BAIK";
    if ($nilai >= 76.61) return "BAIK";
    if ($nilai >= 65.00) return "KURANG BAIK";
    return "TIDAK BAIK";
}

function warnaPredikat($nilai) {
    if ($nilai >= 88.31) return "#28A745";
    if ($nilai >= 76.61) return "#007BFF";
    if ($nilai >= 65.00) return "#FFA500";
    return "#DC3545";
}

class Dashboard extends Admin_Controller {

    private $per_halaman = 20;

    public function __construct() {
        parent::__construct(); // otomatis cek login (lihat MY_Controller.php)
        $this->load->model('Admin_model');
        $this->load->helper(['csv_aman', 'url']);
    }

    /** Halaman Utama Admin Dashboard */
    public function index() {
        $notif = $this->session->flashdata('msg') ?? "";

        // ================== LOGIKA PROSES UPLOAD LAPORAN ==================
        if ($this->input->method() === 'post' && $this->input->post('action') === 'upload_laporan') {
            $this->cek_csrf(); // Menjaga keamanan token CSRF dashboard

            // Konfigurasi Upload PDF ke folder ./uploads/
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = 10240; // Maksimal 10MB
            $config['file_name']     = time() . '_' . str_replace(' ', '_', $_FILES['file_pdf']['name']);

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_pdf')) {
                $upload_data = $this->upload->data();
                $data_insert = [
                    'tahun'     => trim($this->input->post('tahun')),
                    'judul'     => trim($this->input->post('judul')),
                    'deskripsi' => trim($this->input->post('deskripsi')),
                    'file_pdf'  => $upload_data['file_name']
                ];
                
                // Menyimpan ke database melalui Admin_model
                $this->Admin_model->simpan_laporan($data_insert);
                $this->session->set_flashdata('msg', 'Laporan PDF berhasil dipublikasikan!');
                redirect('dashboard'); 
            } else {
                $error = $this->upload->display_errors('', '');
                echo "<script>alert('Gagal Upload: ".$error."'); window.location='".base_url('dashboard')."';</script>";
                exit;
            }
        }

        // ================== HAPUS DATA RESPONDEN (BAWAAN) ==================
        if ($this->input->method() === 'post' && $this->input->post('action') === 'hapus') {
            $this->cek_csrf();
            $id = (int) $this->input->post('id');
            if ($id > 0) {
                $notif = $this->Admin_model->hapus_responden($id)
                    ? "Data responden #$id berhasil dihapus."
                    : "Gagal menghapus data.";
            }
        }

        // ================== LOGIKA FILTER & PAGINATION DATA RESPONDEN ==================
        $cari     = trim($this->input->get('cari') ?? '');
        $tahunPil = trim($this->input->get('tahun') ?? '');
        $halaman  = max(1, (int) ($this->input->get('halaman') ?? 1));

        $filter = ['cari' => $cari, 'tahun' => $tahunPil];
        $totalFilter  = $this->Admin_model->hitung_total($filter);
        $totalHalaman = max(1, (int) ceil($totalFilter / $this->per_halaman));
        if ($halaman > $totalHalaman) $halaman = $totalHalaman;

        $filter['per_halaman'] = $this->per_halaman;
        $filter['offset'] = ($halaman - 1) * $this->per_halaman;

        // Data Grafik
        $grafikRaw = $this->Admin_model->grafik_per_tahun();
        $grafikTahun = array_map(fn($r) => (int) $r['tahun'], $grafikRaw);
        $grafikSkor  = array_map(fn($r) => round((float) $r['skor'], 2), $grafikRaw);

        $unsurRaw = $this->Admin_model->rata_per_unsur();
        $unsurData = [];
        for ($i = 1; $i <= 9; $i++) {
            $unsurData[] = round((float) ($unsurRaw["a$i"] ?? 0), 2);
        }

        $totalRespondenAsli = $this->db->count_all('responden');

        // Parsing semua data ke View Admin
        $data = [
            'notif'              => $notif,
            'dataResponden'      => $this->Admin_model->data_responden($filter),
            'tahunList'          => $this->Admin_model->daftar_tahun(),
            'ikmKeseluruhan'     => $this->Admin_model->ikm_keseluruhan(),
            'grafikTahun'        => $grafikTahun,
            'grafikSkor'         => $grafikSkor,
            'unsurData'          => $unsurData,
            'cari'               => $cari,
            'tahunPil'           => $tahunPil,
            'halaman'            => $halaman,
            'totalHalaman'       => $totalHalaman,
            'totalFilter'        => $totalFilter,
            'totalRespondenAsli' => $totalRespondenAsli, // <-- PERBAIKAN: Dikirim ke view!
            'list_laporan'       => $this->Admin_model->ambil_semua_laporan(),
        ];

        $this->load->view('admin/dashboard', $data);
    }

    /** LOGIKA PROSES HAPUS LAPORAN PDF */
    public function hapus_laporan() {
        if ($this->input->method() === 'post' && $this->input->post('action') === 'hapus_pdf') {
            $this->cek_csrf();
            $id = (int) $this->input->post('id');
            
            $laporan = $this->db->get_where('laporan_skm', ['id' => $id])->row_array();
            if ($laporan) {
                $path = './uploads/' . $laporan['file_pdf'];
                if (file_exists($path)) {
                    unlink($path); // Hapus file fisik di storage folder
                }
                $this->db->delete('laporan_skm', ['id' => $id]);
                $this->session->set_flashdata('msg', 'Laporan berkas PDF berhasil dihapus!');
            }
        }
        redirect('dashboard');
    }

    /** Porting dari export.php */
    public function export() {
        $filter = [
            'cari'  => trim($this->input->get('cari') ?? ''),
            'tahun' => trim($this->input->get('tahun') ?? ''),
        ];
        $rows = $this->Admin_model->data_untuk_export($filter);

        $filename = "data_responden_skm_" . date("Ymd_His") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

        fputcsv($output, [
            'ID','Nama','Jenis Kelamin','Usia','No. HP','Pendidikan','Pekerjaan',
            'Kecamatan','Layanan','Q1','Q2','Q3','Q4','Q5','Q6','Q7','Q8','Q9',
            'Saran','Tahun','Waktu Isi'
        ]);

        foreach ($rows as $row) {
            fputcsv($output, [
                $row['id'], amankan_csv($row['nama']), $row['jk'], amankan_csv($row['usia']),
                amankan_csv($row['wa']), amankan_csv($row['pendidikan']), amankan_csv($row['pekerjaan']),
                amankan_csv($row['kecamatan']), amankan_csv($row['layanan']),
                $row['q1'], $row['q2'], $row['q3'], $row['q4'], $row['q5'],
                $row['q6'], $row['q7'], $row['q8'], $row['q9'],
                amankan_csv($row['saran']), $row['tahun'], $row['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}