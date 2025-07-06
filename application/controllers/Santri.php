
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Modeldata', 'model');
        $this->psb = $this->load->database('psb', TRUE);
    }

    public function index()
    {
        $santriData = [];
        $santri = $this->psb->query("SELECT * FROM tb_santri WHERE ket = 'baru'")->result();
        foreach ($santri as $sn) {
            $mangkat = $this->model->getBy('berangkat', 'id_santri', $sn->id_santri)->row();
            $santriData[] = [
                'id_santri' => $sn->id_santri,
                'nama' => $sn->nama,
                'lembaga' => $sn->lembaga,
                'ket' => $sn->ket,
                'desa' => $sn->desa,
                'kec' => $sn->kec,
                'nis' => $sn->nis,
                'berangkat' => $mangkat ? 1 : 0,
            ];
        }
        // Simpan dalam key 'data'
        $data['data'] = $santriData;

        // Load view dan kirim array $data
        $this->load->view('santri', $data);
    }
    public function formulir($nis)
    {
        $data['data'] = $this->psb->query("SELECT * FROM tb_santri WHERE nis = $nis")->row();
        $data['user'] = $this->session->userdata('nama');
        $this->load->view('formulir2', $data);
    }
    public function ikrar($nis)
    {
        $data['data'] = $this->psb->query("SELECT * FROM tb_santri WHERE nis = $nis")->row();
        $data['user'] = $this->session->userdata('nama');
        $this->load->view('ikrar', $data);
    }
}
