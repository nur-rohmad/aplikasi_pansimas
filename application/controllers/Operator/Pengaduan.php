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
        check_admin();
    }

    public function index()
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $data['user_data'] = $data_user;
        $data['data_pengaduan'] = $this->M_pengaduan->get_all_pengaduan();
        $this->load->view('templete/side_bar', $data);
        $this->load->view('operator/pengaduan/index', $data);
        $this->load->view('templete/footer');
    }

    public function lihat_pengaduan($id_pengaduan)
    {
        $params = [
            'read_status_admin' => 'sudah_dilihat',
        ];
        $where = ['id_pengaduan' => $id_pengaduan];

        if ($this->M_pengaduan->update_pengaduan($params, $where)) {
            # code...
            $this->load->view('templete/header');
            $this->load->view('templete/navbar');
            $data_user = $this->session->userdata('user');
            $data['user_data'] = $data_user;
            $data['rs_pengaduan'] = $this->M_pengaduan->pengaduan_by_id($id_pengaduan);
            $this->load->view('templete/side_bar', $data);
            $this->load->view('operator/pengaduan/detail', $data);
            $this->load->view('templete/footer');
        }
    }

    // proses respone pengaduan
    public function prosess_respone_pengaduan()
    {
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        $this->form_validation->set_rules('no_pengaduan', 'No Pengaduan', 'required');
        $this->form_validation->set_rules('respone_pengaduan', 'Respone Pengaduan', 'required');
        $this->form_validation->set_rules('status_pengaduan', 'Status Pengaduan', 'required');

        // cek validation
        if ($this->form_validation->run() !== FALSE) {
            # code...
            $params = [
                'respone_pengaduan' => $this->input->post('respone_pengaduan', TRUE),
                'status_pengaduan' => $this->input->post('status_pengaduan', TRUE),
                'read_status_user' => 'belum_dilihat',
            ];
            $where = ['id_pengaduan' => $this->input->post('no_pengaduan', TRUE)];
            if ($this->M_pengaduan->update_pengaduan($params, $where)) {
                # code...
                $this->session->set_flashdata('success_pengaduan', 'Respone Pengaduan Berhasil Dikirim');
                redirect('operator/pengaduan');
            } else {
                # code...
                $this->session->set_flashdata('gagal_pengaduan', 'Respone Pengaduan Gagal Dikirim');
            }
        } else {
            $this->session->set_flashdata('gagal_pengaduan', 'Respone Pengaduan Gagal Dikirim');
            $this->session->set_flashdata('pesan_eror', validation_errors('<li>', '</li>'));
        }
        // default redirect
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $data['user_data'] = $data_user;
        $data['rs_pengaduan'] = $this->M_pengaduan->pengaduan_by_id($this->input->post('no_pengaduan', TRUE));
        $this->load->view('templete/side_bar', $data);
        $this->load->view('operator/pengaduan/detail', $data);
        $this->load->view('templete/footer');
    }
}
