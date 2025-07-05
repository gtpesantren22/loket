
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
        // $apiUrl = "https://data.ppdwk.com/api/datatables?data=pendaftar&page=1&per_page=500&q=&sortby=created_at&sortbydesc=ASC&status=1";

        // $token = $this->model->getBy('setting', 'kunci', 'token')->row('isi');

        // $headers = [
        //     "Authorization: Bearer $token",
        //     "Content-Type: application/json",
        // ];

        // $ch = curl_init($apiUrl);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_HTTPGET, true); // GET request

        // $response = curl_exec($ch);

        // if (curl_errno($ch)) {
        //     echo "cURL error: " . curl_error($ch);
        // } else {
        //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //     // echo "HTTP Code: $httpCode\n";

        //     // Decode JSON response
        //     $result = json_decode($response, true); // true = associative array

        // }
        // $data['data'] = json_encode($result['data']['data']);
        // Ambil data dari DB
        $santri = $this->psb->query("SELECT * FROM tb_santri WHERE ket = 'baru'")->result_array();

        // Simpan dalam key 'data'
        $data['data'] = $santri;

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
