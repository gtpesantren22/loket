<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            // Kalau belum login, redirect ke halaman login
            redirect('auth');
        }
    }

    protected function cekRole($role = 'user')
    {
        if ($this->session->userdata('role') != $role) {
            show_error("Akses ditolak. Halaman ini hanya untuk $role.", 403, "403 Forbidden");
        }
    }
}
