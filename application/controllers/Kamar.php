<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kamar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Modeldata', 'model');
    }

    public function index()
    {
        $data['komplek'] = $this->db->query("SELECT * FROM kamar GROUP BY komplek ORDER BY komplek ASC")->result();
        $this->load->view('kamar', $data);
    }

    public function daerah()
    {
        $daerah = $this->input->post('daerah', true);
        $data = $this->model->getByGroup('kamar', 'daerah', $daerah, 'komplek')->result();
        echo json_encode($data);
    }
    public function komplek()
    {
        $komplek = $this->input->post('komplek', true);
        $data = $this->model->getBy('kamar', 'komplek', $komplek)->result();
        echo json_encode($data);
    }

    public function listKamar()
    {
        $id = $this->input->post('id', true);
        $data['loker'] = $this->model->getBy('loker', 'id_kamar', $id);
        $data['kamar'] = $this->model->getBy('kamar', 'id', $data['loker']->row('id_kamar'))->row();
        $this->load->view('show_loker', $data);
    }
}
