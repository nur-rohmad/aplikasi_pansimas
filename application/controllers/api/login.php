<?php

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;
use CodeIgniter\HTTP\Response;

class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index_post()
    {
        // get username dan password
        $user_name = $this->post('username');
        $password = $this->post('password');

        // cek password dan username terisi
        if (!empty($user_name & $password)) {
            $cek_login = $this->get_detail_user($user_name);
            // cek username terdaftar atau tidak
            if ($cek_login) {
                // cek password 
                if (password_verify($password, $cek_login['user_pass'])) {
                    # code...
                    $data = [
                        'user_id' => $cek_login['user_id'],
                        'user_name' => $cek_login['user_name'],
                        'user_photo' => 'http://localhost/pansimas/resource/adminlte31//img/profile/'. $cek_login['user_photo'],
                        'nama_lengkap' => $cek_login['user_alias'],
                        'user_role' => $cek_login['role_id'],
                        'user_role_name' => $cek_login['name_role']
                    ];

                    $output = [
                        'status' => true,
                        'message' => 'login berhasil',
                        'data'    => $data
                    ];

                    return $this->response($output, 200);
                } else {
                    $output = [
                        'status' => false,
                        'message' => 'login gagal, password salah'
                    ];

                    return $this->response($output, 200);
                }
            } else {
                # code...
                $output = [
                    'status' => false,
                    'message' => 'login gagal, username tidak ditemukan'
                ];

                return $this->response($output, 200);
            }
        } else {
            $output = [
                'status' => false,
                'message' => 'login gagal, username dan password tidak boleh kosong'
            ];

            return $this->response($output, 200);
        }
    }


    // cek user name
    public function get_detail_user($params)
    {
        $sql = "SELECT a.* , b.role_id, c.* FROM user_table a JOIN user_role_table b ON a.user_id = b.user_id join role_table c on b.role_id=c.role_id  WHERE a.user_name = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
}
