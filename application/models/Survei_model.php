<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Simpan satu jawaban survei. Query Builder CI otomatis pakai
     * prepared statement di belakang layar — aman dari SQL Injection.
     *
     * Return TRUE kalau sukses, atau string pesan error kalau gagal
     * (db_debug dimatikan sementara supaya error tidak menghentikan
     * eksekusi dengan halaman HTML mentah — itu yang bikin fetch() di
     * frontend gagal parse JSON dan cuma nampilin "Terjadi kesalahan koneksi").
     */
    public function simpan($data) {
        $this->db->db_debug = FALSE;
        $sukses = $this->db->insert('responden', $data);

        if (!$sukses) {
            $err = $this->db->error(); // ['code' => ..., 'message' => ...]
            log_message('error', 'Insert responden gagal: ' . $err['message']);
            return $err['message'];
        }
        return true;
    }

    /**
     * Skor IKM live (rata-rata keseluruhan) — porting dari rekap.php
     */
    public function skor_live() {
        $row = $this->db
            ->select('AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) AS rata')
            ->get('responden')
            ->row();
        return $row && $row->rata !== null ? round((float) $row->rata, 2) : 0;
    }

    /**
     * Skor IKM per tahun — porting dari rekap.php
     */
    public function skor_per_tahun() {
        $rows = $this->db
            ->select('tahun, AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) AS skor')
            ->group_by('tahun')
            ->order_by('tahun', 'ASC')
            ->get('responden')
            ->result();

        $hasil = [];
        foreach ($rows as $r) {
            $hasil[] = ['tahun' => (int) $r->tahun, 'skor' => round((float) $r->skor, 2)];
        }
        return $hasil;
    }
}
