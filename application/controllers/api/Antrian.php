<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $key = $this->db->query("SELECT * FROM setting WHERE kunci = 'apiKey'")->row();
        $token = $this->input->get_request_header('Authorization');
        if ($token !== 'Bearer ' . $key->isi) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }
        $this->load->model('Modeldata', 'model');
        $this->load->helper('security');
    }

    public function nowQueu()
    {
        $datakirim = [];
        $mejadata = $this->db->get('meja')->result();
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

        echo json_encode(['status' => 'success', 'data' => $datakirim]);
    }
    public function nextQueu()
    {
        $harini = date('Y-m-d');
        $datakirim = $this->model->getBy2('antrian', 'ket', 'menunggu', 'tanggal', $harini)->result();
        echo json_encode(['status' => 'success', 'data' => $datakirim]);
    }
    public function allQueu()
    {
        $harini = date('Y-m-d');
        $datakirim = $this->db->query("SELECT * FROM antrian WHERE tanggal = '$harini' ORDER BY nomor DESC LIMIT 10 ")->result();
        echo json_encode(['status' => 'success', 'data' => $datakirim]);
    }
    public function lastQueu()
    {
        $harini = date('Y-m-d');
        $datakirim = $this->db->query("SELECT * FROM antrian WHERE tanggal = '$harini' ORDER BY waktu DESC LIMIT 1 ")->row();
        echo json_encode(['status' => 'success', 'data' => $datakirim]);
    }
    public function add()
    {
        $harini = date('Y-m-d');
        $input = json_decode(trim(file_get_contents("php://input")), true);

        // Validasi input
        if (!isset($input['nama']) || !isset($input['jenis'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Field "nama" dan "jenis" wajib diisi'
            ]);
            return;
        }
        $nama = xss_clean(trim($input['nama']));
        $jenis = xss_clean(trim($input['jenis']));

        $urut = $this->db->query("SELECT COUNT(*) as jml FROM antrian WHERE tanggal = '$harini' ")->row();
        $nama = $input['nama'];
        $jenis = $input['jenis'];
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
            echo json_encode([
                'status' => 'success',
                'message' => 'Antrian berhasil ditambahkan'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Antrian gagal ditambahkan'
            ]);
        }
    }
}
