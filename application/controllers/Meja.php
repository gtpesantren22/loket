<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meja extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Modeldata', 'model');
	}

	public function index()
	{
		$data['nama'] = $this->session->userdata('nama');
		$data['user_id'] = $this->session->userdata('user_id');
		$harini = date('Y-m-d');
		$user_id = $this->session->userdata('user_id');
		$data['tugas'] = $this->db->query("SELECT * FROM petugas JOIN user ON petugas.user_id=user.user_id JOIN meja ON petugas.meja_id=meja.id WHERE petugas.user_id = '$user_id' ")->row();
		$data['proses'] = $this->model->getBy2('antrian', 'loket', $data['tugas']->nomor, 'ket', 'proses')->row();
		$data['menunggu'] = $this->model->getBy2('antrian', 'tanggal', $harini, 'ket', 'menunggu')->num_rows();
		$nomormeja = $data['tugas']->nomor;
		$data['antrianAll'] = $this->db->query("SELECT * FROM antrian WHERE tanggal = '$harini' AND loket = $nomormeja ORDER BY nomor DESC LIMIT 10 ")->result();

		$this->load->view('loket', $data);
	}

	public function ambil()
	{
		$harini = date('Y-m-d');
		$meja = $this->input->post('meja', true);
		$pelayan = $this->input->post('pelayan', true);

		$cekAntrian = $this->model->getBy2('antrian', 'tanggal', $harini, 'ket', 'menunggu')->num_rows();
		if ($cekAntrian < 1) {
			$this->session->set_flashdata('error', 'Tidak ada antrian');
			redirect('meja');
		}
		$cekProses = $this->model->getBy3('antrian', 'tanggal', $harini, 'ket', 'proses', 'loket', $meja)->num_rows();
		if ($cekProses > 0) {
			$this->session->set_flashdata('error', 'Ada antrian belum diselesaikan');
			redirect('meja');
		}

		$antrian = $this->db->query("SELECT * FROM antrian WHERE tanggal = '$harini' AND ket = 'menunggu' ORDER BY nomor ASC LIMIT 1 ")->row();
		$data = [
			'ket' => 'proses',
			'loket' => $meja,
			'pelayan' => $pelayan,
		];
		$save = $this->model->edit('antrian', $data, 'id', $antrian->id);
		if ($save) {
			redirect('meja');
		} else {
			$this->session->set_flashdata('error', 'Ambil antrian gagal');
			redirect('meja');
		}
	}

	public function selesai($id)
	{
		$data = [
			'ket' => 'selesai',
		];
		$save = $this->model->edit('antrian', $data, 'id', $id);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data sudah diperbarui');
			redirect('meja');
		} else {
			$this->session->set_flashdata('error', 'gagal dislesaikan');
			redirect('meja');
		}
	}
	public function batal($id)
	{
		$data = [
			'ket' => 'menunggu',
			'loket' => 0,
			'pelayan' => ''
		];
		$save = $this->model->edit('antrian', $data, 'id', $id);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data sudah diperbarui');
			redirect('meja');
		} else {
			$this->session->set_flashdata('error', 'gagal dislesaikan');
			redirect('meja');
		}
	}
}
