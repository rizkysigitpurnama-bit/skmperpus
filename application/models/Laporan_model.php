<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function get_all_laporan() {
        // Mengurutkan berdasarkan tahun terbaru
        $this->db->order_by('tahun', 'DESC');
        return $this->db->get('laporan_skm')->result_array();
    }

    public function insert_laporan($data) {
        return $this->db->insert('laporan_skm', $data);
    }
    
    public function delete_laporan($id) {
        return $this->db->delete('laporan_skm', array('id' => $id));
    }
}