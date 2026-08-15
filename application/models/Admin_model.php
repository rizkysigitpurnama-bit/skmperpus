<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function cari_by_username($username) {
        return $this->db
            ->select('id, username, password, nama_lengkap')
            ->where('username', $username)
            ->limit(1)
            ->get('admin_users')
            ->row();
    }

    /**
     * Hitung SELURUH MURNI total responden di database (Untuk Stat Card Utama)
     * Tidak akan terpengaruh filter tahun/pencarian
     */
    public function total_responden_real() {
        return (int) $this->db->count_all('responden');
    }

    /**
     * Data responden dengan filter + paginasi (Untuk Tabel Bawah)
     */
    public function data_responden($filter) {
        if (!empty($filter['cari'])) {
            $this->db->group_start()
                ->like('nama', $filter['cari'])
                ->or_like('kecamatan', $filter['cari'])
                ->or_like('layanan', $filter['cari'])
                ->group_end();
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tahun', (int) $filter['tahun']);
        }

        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit($filter['per_halaman'], $filter['offset'])
            ->get('responden')
            ->result_array();
    }

    /**
     * Hitung total data khusus yang di-FILTER (Untuk Paginasi Tabel Bawah)
     */
    public function hitung_total($filter) {
        if (!empty($filter['cari'])) {
            $this->db->group_start()
                ->like('nama', $filter['cari'])
                ->or_like('kecamatan', $filter['cari'])
                ->or_like('layanan', $filter['cari'])
                ->group_end();
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tahun', (int) $filter['tahun']);
        }
        return (int) $this->db->count_all_results('responden');
    }

    public function hapus_responden($id) {
        return $this->db->where('id', (int) $id)->delete('responden');
    }

    public function daftar_tahun() {
        $rows = $this->db->distinct()->select('tahun')->order_by('tahun', 'DESC')->get('responden')->result_array();
        return array_column($rows, 'tahun');
    }

    public function ikm_keseluruhan() {
        $row = $this->db->select('AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) AS rata')->get('responden')->row();
        return $row && $row->rata !== null ? round((float) $row->rata, 2) : 0;
    }

    public function grafik_per_tahun() {
        return $this->db
            ->select('tahun, AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) AS skor')
            ->group_by('tahun')->order_by('tahun', 'ASC')
            ->get('responden')->result_array();
    }

    public function rata_per_unsur() {
        return $this->db
            ->select('AVG(q1) a1, AVG(q2) a2, AVG(q3) a3, AVG(q4) a4, AVG(q5) a5, AVG(q6) a6, AVG(q7) a7, AVG(q8) a8, AVG(q9) a9')
            ->get('responden')->row_array();
    }

    public function data_untuk_export($filter) {
        if (!empty($filter['cari'])) {
            $this->db->group_start()
                ->like('nama', $filter['cari'])
                ->or_like('kecamatan', $filter['cari'])
                ->or_like('layanan', $filter['cari'])
                ->group_end();
        }
        if (!empty($filter['tahun'])) {
            $this->db->where('tahun', (int) $filter['tahun']);
        }
        return $this->db->order_by('created_at', 'DESC')->get('responden')->result_array();
    }

    public function simpan_laporan($data) {
        return $this->db->insert('laporan_skm', $data);
    }

    public function ambil_semua_laporan() {
        $this->db->order_by('tahun', 'DESC');
        return $this->db->get('laporan_skm')->result_array();
    }
}