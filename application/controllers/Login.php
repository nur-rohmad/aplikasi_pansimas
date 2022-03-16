<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }


    public function index()
    {
        $this->load->view('login/header');
        $this->load->view('login/form_login');
    }



    public function proccess_login()
    {
        $this->form_validation->set_rules('user_name', 'Nama ', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run() !== FALSE) {
            $user_name = $this->input->post('user_name');
            $pass = $this->input->post('pass');
            $user = $this->get_detail_user($user_name);
            if ($user) {
                if (password_verify($pass, $user['user_pass'])) {
                    $data = [
                        'user_id' => $user['user_id'],
                        'user_name' => $user['user_name'],
                        'user_photo' => $user['user_photo'],
                        'nama_lengkap' => $user['user_alias'],
                        'user_role' => $user['role_id'],
                        'user_role_name' => $user['name_role']
                    ];
                    $this->session->set_userdata('user', $data);
                    if ($data['user_role']  == 1) {
                        # code...
                        $this->session->set_flashdata('sukses_login', 'Anda Berhasil Login');
                        redirect('operator/dashboard');
                    } elseif ($data['user_role']  == 2) {
                        # code...
                    } else {
                        # code...
                        redirect('pelanggan/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Password Salah');
                }
            } else {
                $this->session->set_flashdata('gagal', 'User Tidak Ditemukan');
            }
        } else {
            $this->session->set_flashdata('gagal', 'User Name Dan Password Tidak Boleh Kosong');
        }
        redirect('login');
    }


    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->set_flashdata('sukses_logout', 'Anda Berhasil Logout !!');
        redirect('login');
    }

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
