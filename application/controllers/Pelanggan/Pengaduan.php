<?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('M_pengaduan');
        // $this->load->model('operator/M_pembayaran');
        $this->load->library('form_validation');
        // cek apakah user sudah login
        cek_login();
        //mengontrol hak akses user
        $url = $this->uri->segment(1);
        if ($url == 'pelanggan') {
            # code...
            $role_user = 3;
        } else {
            # code...
            $role_user = 1;
        }
        $data_user = $this->session->userdata('user');
        // var_dump($role_user, $data_user['user_role']);
        if ($data_user['user_role']  != $role_user) {
            # code...

            $this->load->view('errors');
            // print_r('akses_ditolak');
            // // exit;
        }
    }

    public function index()
    {

        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $data['user_data'] = $data_user;
        $data['data_pengaduan'] = $this->M_pengaduan->get_pengaduan_by_user($data_user['user_id']);
        // $data['no_pengaduan'] = $this->M_pengaduan->get_pengaduan_last_id();
        $no_pengaduan = date("ymd") . rand(0000,10000);
        $data['no_pengaduan'] = $no_pengaduan;
        // var_dump($no_pengaduan);
        // die;
        $this->load->view('pelanggan/side_bar', $data);
        $this->load->view('pelanggan/pengaduan/index', $data);
        $this->load->view('templete/footer');
    }

    // proccess add pengaduan
    public function procces_pengaduan()
    {
        // form validation
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        $this->form_validation->set_rules('no_pengaduan', 'No Pengaduan', 'required');
        $this->form_validation->set_rules('jenis_pengaduan', 'Jenis Pengaduan', 'required');
        $this->form_validation->set_rules('isi_pengaduan', 'Isi Pengaduan', 'required');

        // get user informasi
        $data_user = $this->session->userdata('user');
        // cek vidasi
        if ($this->form_validation->run() !== FALSE) {
            # code...
            $params = [
                'id_pengaduan' => $this->input->post('no_pengaduan', TRUE),
                'jenis_pengaduan' => $this->input->post('jenis_pengaduan', TRUE),
                'isi_pengaduan' => $this->input->post('isi_pengaduan', TRUE),
                'tgl_pengaduan' => date('Y-m-d'),
                'pengaduan_by' =>  $data_user['user_id'],
                'status_pengaduan' =>  'terkirim',
                'read_status_admin' =>  'belum_dilihat',
                'read_status_user' =>  'sudah_dilihat'
            ];
            // var_dump($params);
            // die;
            if ($this->M_pengaduan->insert_pengaduan($params)) {
                $this->session->set_flashdata('success_pengaduan', 'Data Berhasil disimpan');
                redirect('pelanggan/pengaduan');
            } else {
                # code...
                $this->session->set_flashdata('success_pengaduan', 'Data Gagal disimpan');
            }
        } else {
            # code...
            $this->session->set_flashdata('error_pengaduan', 'Data Gagal Disimpan ');
            $this->session->set_flashdata('pesan_eror', validation_errors('<li>', '</li>'));
            // var_dump(validation_errors());
            // die;
        }
        redirect('pelanggan/pengaduan');
    }

    public function lihat_pengaduan($id_pengaduan)
    {
        $params = [
            'read_status_user' => 'sudah_dilihat'
        ];
        $where = ['id_pengaduan' => $id_pengaduan];

        if ($this->M_pengaduan->update_pengaduan($params, $where)) {
            # code...
            $this->load->view('templete/header');
            $this->load->view('templete/navbar');
            $data_user = $this->session->userdata('user');
            $data['user_data'] = $data_user;
            $data['rs_pengaduan'] = $this->M_pengaduan->pengaduan_by_id($id_pengaduan);
            $this->load->view('pelanggan/side_bar', $data);
            $this->load->view('pelanggan/pengaduan/detail', $data);
            $this->load->view('templete/footer');
        }
    }
}
