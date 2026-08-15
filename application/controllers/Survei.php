<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat kedua model yang dibutuhkan halaman user
        $this->load->model('Survei_model');
        $this->load->model('Admin_model'); 
        $this->load->helper('form');
        $this->load->helper('url');
    }

    /** Halaman form survei publik (form.php) */
    public function index() {
        // 1. Ambil data laporan SKM dari database lewat Admin_model
        $data['laporan_skm'] = $this->Admin_model->ambil_semua_laporan();
        
        // 2. Kirim datanya ke file view form.php
        $this->load->view('survei/form', $data);
    }

    /**
     * Terima submit survei (dipanggil via fetch/AJAX dari main.js).
     */
    public function submit() {
        header('Content-Type: application/json; charset=utf-8');

        if ($this->input->method() !== 'post') {
            http_response_code(405);
            echo json_encode(["status" => "error", "message" => "Method tidak diizinkan."]);
            return;
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Format data tidak valid."]);
            return;
        }

        // ================== HONEYPOT ANTI-BOT ==================
        if (!empty($data['website'])) {
            http_response_code(200);
            echo json_encode(["status" => "success"]);
            return;
        }

        // ================== RATE LIMIT PER SESSION ==================
        $batasDetik = 60;
        $terakhir = $this->session->userdata('last_submit');
        if ($terakhir && (time() - $terakhir) < $batasDetik) {
            http_response_code(429);
            echo json_encode(["status" => "error", "message" => "Anda baru saja mengisi survei. Coba lagi beberapa saat."]);
            return;
        }

        // ================== VALIDASI FIELD WAJIB ==================
        $fieldWajib = ['nama', 'jk', 'usia', 'wa', 'pendidikan', 'pekerjaan', 'kecamatan', 'layanan'];
        foreach ($fieldWajib as $f) {
            if (!isset($data[$f]) || trim((string) $data[$f]) === '') {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Kolom $f wajib diisi."]);
                return;
            }
        }
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($data["q$i"]) || !is_numeric($data["q$i"])) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Jawaban q$i tidak valid."]);
                return;
            }
        }
        if (!isset($data['tahun']) || !is_numeric($data['tahun'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Tahun tidak valid."]);
            return;
        }

        // Skor jawaban HANYA boleh salah satu dari 4 pilihan emoji
        $pilihanValid = [25, 50, 75, 100];
        $skorBersih = [];
        for ($i = 1; $i <= 9; $i++) {
            $v = (int) $data["q$i"];
            $skorBersih["q$i"] = in_array($v, $pilihanValid, true) ? $v : 25;
        }

        $simpanData = [
            'nama'       => strip_tags(trim($data['nama'])),
            'jk'         => strip_tags(trim($data['jk'])),
            'usia'       => strip_tags(trim($data['usia'])),
            'wa'         => strip_tags(trim($data['wa'])),
            'pendidikan' => strip_tags(trim($data['pendidikan'])),
            'pekerjaan'  => strip_tags(trim($data['pekerjaan'])),
            'kecamatan'  => strip_tags(trim($data['kecamatan'])),
            'layanan'    => strip_tags(trim($data['layanan'])),
            'saran'      => isset($data['saran']) ? strip_tags(trim($data['saran'])) : '',
            'tahun'      => (int) $data['tahun'],
        ] + $skorBersih;

        $hasil = $this->Survei_model->simpan($simpanData);
        if ($hasil === true) {
            $this->session->set_userdata('last_submit', time());
            echo json_encode(["status" => "success"]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menyimpan data.",
                "debug" => (ENVIRONMENT !== 'production') ? $hasil : null,
            ]);
        }
    }

    /** JSON rekap IKM untuk halaman publik */
    public function rekap() {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "skorLive"    => $this->Survei_model->skor_live(),
            "dataHistori" => $this->Survei_model->skor_per_tahun(),
        ]);
    }

    /** Halaman terima kasih setelah submit */
    public function terimakasih() {
        $nama = $this->input->get('nama') ?? '';
        $this->load->view('survei/terimakasih', ['nama' => htmlspecialchars($nama, ENT_QUOTES, 'UTF-8')]);
    }
}