<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller.php
 * Controller dasar khusus halaman admin — otomatis cek session login.
 * Semua controller admin (Dashboard, dll) extend Admin_Controller ini,
 * bukan CI_Controller langsung, biar proteksi login tidak perlu ditulis ulang.
 */
class Admin_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('admin_id'))) {
            redirect('admin/login');
        }

        // CSRF token untuk form admin (hapus data, dll)
        if (empty($this->session->userdata('csrf_token'))) {
            $this->session->set_userdata('csrf_token', bin2hex(random_bytes(32)));
        }
    }

    /**
     * Helper validasi CSRF token dari form POST.
     * Panggil di tiap action yang mengubah data (hapus, update, dll).
     */
    protected function cek_csrf() {
        $token = $this->input->post('csrf_token');
        if (!$token || !hash_equals($this->session->userdata('csrf_token'), $token)) {
            show_error('Token keamanan tidak valid. Silakan muat ulang halaman.', 403);
        }
    }
}
