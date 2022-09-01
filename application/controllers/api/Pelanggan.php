<?php

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;
use CodeIgniter\HTTP\Response;

class Pelanggan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('api/M_pelanggan');
        header('Access-Control-Allow-Origin: *');
    }
    public function all_pelanggan_get()
    {
        $get_all_pelanggan = $this->M_pelanggan->get_all_pelanggan();
        if ($get_all_pelanggan) {
            # code...
            foreach ($get_all_pelanggan as $key => $value) {
                # code...
                $data[$key] = $value;
            }
            $output = array(
                'status' => true,
                'message' => 'success',
                'data' => $data
            );
            return $this->response($output, 200);
        }
    }

    // get pelanggan by id
    public function pelanggan_by_id_get()
    {
        // get data id
        $id_pelanggan = $this->input->get('id_pelanggan');
        if (isset($id_pelanggan)) {
            # code...
            $pelanggan_by_id = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
            if ($pelanggan_by_id) {
                # code...
                $output = [
                    'status' => true,
                    'message' => 'success',
                    'data' => $pelanggan_by_id
                ];
                return $this->response($output, 200);
            } else {
                # code...
                $output = [
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan',
                    'data' => []
                ];
                return $this->response($output, 200);
            }
        } else {
            # code...
            $output = [
                'status' => false,
                'message' => 'gagal',
                'data' => 'id pelanggan tidak boleh kosong'
            ];
            return $this->response($output, 200);
        }
    }
}
