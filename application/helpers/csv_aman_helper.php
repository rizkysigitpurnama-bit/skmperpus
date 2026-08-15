<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('amankan_csv')) {
    /**
     * Mencegah CSV/Formula Injection: kalau isi kolom diawali karakter
     * pemicu formula (=, +, -, @, tab), Excel/Sheets bisa menjalankannya
     * sebagai perintah. Tambahkan apostrof di depan agar dibaca sebagai teks biasa.
     */
    function amankan_csv($value) {
        $value = (string) $value;
        if ($value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $value;
        }
        return $value;
    }
}
