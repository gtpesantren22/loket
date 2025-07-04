<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Welcome extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->cekRole('admin');
		$this->load->model('Modeldata', 'model');
	}

	public function index()
	{
		$mejadata = $this->db->get('meja')->result();
		$harini = date('Y-m-d');
		$datakirim = [];
		foreach ($mejadata as $meja) {
			$hasil = $this->model->getBy3('antrian', 'tanggal', date('Y-m-d'), 'loket', $meja->nomor, 'ket', 'proses')->row();
			$petugas = $this->db->query("SELECT user.nama FROM petugas JOIN user ON petugas.user_id=user.user_id WHERE meja_id = $meja->id ")->row();
			$datakirim[] = [
				'nomor_meja' => $meja->nomor,
				'nama_meja' => $meja->nama,
				'antrian' => $hasil ? $hasil->nomor : '',
				'nama' => $hasil ? $hasil->nama : '',
				'jenis' => $hasil ? $hasil->jenis : '',
				'petugas' => $petugas ? $petugas->nama : 'Tidak ada petugas',
			];
		}
		$data['last'] = $this->db->query("SELECT * FROM antrian WHERE tanggal = '$harini' ORDER BY waktu DESC LIMIT 1 ")->row();
		$data['meja'] = $datakirim;
		$data['data_meja'] = $mejadata;
		$data['data_user'] = $this->db->get('user')->result();
		$data['antrian'] = $this->model->getBy2('antrian', 'ket', 'menunggu', 'tanggal', $harini)->result();
		$data['antrianAll'] = $this->db->query("SELECT * FROM antrian WHERE tanggal = '$harini' ORDER BY nomor DESC LIMIT 10 ")->result();
		$this->load->view('welcome_message', $data);
	}

	public function santri()
	{
		$apiUrl = "https://data.ppdwk.com/api/datatables?data=pendaftar&page=1&per_page=500&q=&sortby=created_at&sortbydesc=ASC&status=1";

		$token = $this->model->getBy('setting', 'kunci', 'token')->row('isi');

		$headers = [
			"Authorization: Bearer $token",
			"Content-Type: application/json",
		];

		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTPGET, true); // GET request

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			echo "cURL error: " . curl_error($ch);
		} else {
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// echo "HTTP Code: $httpCode\n";

			// Decode JSON response
			$result = json_decode($response, true); // true = associative array

		}
		echo json_encode($result);
	}

	public function add()
	{
		$nama = $this->input->post('nama', true);
		$jenis = $this->input->post('jenis', true);
		$harini = date('Y-m-d');
		$urut = $this->db->query("SELECT COUNT(*) as jml FROM antrian WHERE tanggal = '$harini' ")->row();

		$data = [
			'nomor' => $urut->jml + 1,
			'loket' => 0,
			'tanggal' => $harini,
			'waktu' => date('H:i:s'),
			'ket' => 'menunggu',
			'nama' => $nama,
			'jenis' => $jenis,
		];

		$save = $this->model->simpan('antrian', $data);
		if ($save) {
			$this->cetak($jenis . convNol($urut->jml + 1), $nama);
			redirect('welcome');
		} else {
			redirect('welcome');
		}
	}

	public function cetak($no, $nama)
	{
		try {
			$nomor_antrian = $no;
			// Nama printer seperti yang terlihat di Windows
			$connector = new WindowsPrintConnector("POS-58 Printer");

			$printer = new Printer($connector);

			// Mendapatkan tanggal dan waktu saat ini
			$tanggal = date('d M Y');
			$waktu = date('H:i');

			// Menyiapkan teks yang akan dicetak
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->setFont(Printer::FONT_B);
			$printer->setTextSize(2, 2);
			$printer->text("PSB PPDWK 2025/2026\n");
			$printer->setTextSize(1, 1);
			$printer->text("Panitia Penerimaan Santri Baru\n");
			$printer->text("Ponpes Darul Lughah Wal Karomah\n");
			$printer->feed();
			$printer->setTextSize(2, 2);
			$printer->text("No. Antrian\n");
			$printer->feed();
			$printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH | Printer::MODE_DOUBLE_HEIGHT);
			$printer->setTextSize(4, 4);
			// $printer->text("$nomor_antrian\n");
			$printer->text("$nomor_antrian\n");
			$printer->feed();
			$printer->setTextSize(1, 1);
			$printer->text("$nama\n");
			$printer->feed();
			$printer->text("$tanggal $waktu\n");
			$printer->feed();
			$printer->text("Harap menunggu panggilan\n");
			$printer->text("TERIMAKASIH\n");

			// Memotong kertas
			$printer->cut();

			// Menutup koneksi printer
			$printer->close();
		} catch (Exception $e) {
			echo "Tidak dapat mencetak ke printer: " . $e->getMessage() . "\n";
		}
	}

	public function upTugas()
	{
		$meja = $this->input->post('meja', true);
		$user = $this->input->post('user', true);

		$cekUser = $this->model->getBy2('antrian', 'pelayan', $user, 'ket', 'proses')->row();
		$cekMeja = $this->model->getBy2('antrian', 'loket', $meja, 'ket', 'proses')->row();
		if ($cekUser && $cekMeja) {
			$this->session->set_flashdata('error', 'Meja atau operator sedang melayani');
		} else {
			$upNew = $this->model->edit('petugas', ['user_id' => $user], 'meja_id', $meja);
			if ($upOld && $upNew) {
				$this->session->set_flashdata('error', 'Update selesai');
				redirect('welcome');
			} else {
				redirect('welcome');
			}
		}
	}

	public function batal($id)
	{
		$save = $this->model->hapus('antrian', 'id', $id);
		if ($save) {
			$this->session->set_flashdata('ok', 'Data sudah dibatalkan');
			redirect('welcome');
		} else {
			$this->session->set_flashdata('error', 'gagal dibatalkan');
			redirect('welcome');
		}
	}
}
