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
            $user = $this->db->get_where('user_table', ['user_name' => $user_name])->row_array();
            if ($user) {
                if ($pass == $user['user_pass']) {
                    $data = [
                        'user_name' => $user['user_name'],
                        'user_photo' => $user['user_photo']
                    ];
                    $this->session->set_userdata('user', $data);
                    redirect('operator/dashboard');
                } else {
                    $this->session->set_flashdata('gagal', 'Password Salah');
                }
            } else {
                $this->session->set_flashdata('gagal', 'User Belum Terdaftar');
            }
        } else {
            $this->session->set_flashdata('gagal', 'User Name Dan Password Tidak Boleh Kosong');
        }
        redirect('login');
    }


    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
