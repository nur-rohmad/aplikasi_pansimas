<?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('operator/M_pembayaran');
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
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['belum_bayar'] = $this->M_pembayaran->get_transaksi_belum_bayar();
        $data['sudah_bayar'] = $this->M_pembayaran->get_transaksi_telah_bayar();
        $this->load->view('operator/pembayaran/index', $data);
        $this->load->view('templete/footer');
    }

    // get data transaksi 
    public function get_data_pembayaran()
    {
        $id_transaksi = $this->input->post('id_transaksi');
        if (isset($id_transaksi)) {
            # code...
            $data = $this->M_pembayaran->get_transaksi_belum_bayar_by_id($id_transaksi);
            $data_pembayaran = [
                "data" =>    $data,
                "total_bayar" =>  number_format($data['total_bayar'], 0, ',', '.')

            ];
            echo json_encode($data_pembayaran);
        } else {
            # code...
            echo "data ID Transaksi T{idak Boleh Kosong";
        }
    }
    // get det[ail_pembayaran 
    public function get_data_detail_pembayaran()
    {
        $id_transaksi = $this->input->post('id_transaksi');
        if (isset($id_transaksi)) {
            # code...
            $data = $this->M_pembayaran->get_transaksi_telah_bayar_by_id($id_transaksi);
            $role = $this->M_pembayaran->get_role_user($data['pembayaran_by']);
            $tanggal = $data['waktu_bayar'];
            if ($data['status_pembayaran'] == 'waiting' or $data['status_pembayaran'] == 'gagal') {
                # code...
                $data_pembayaran = [
                    "data" =>    $data,
                    "tanggal" =>  format_tanggal_indo_pendek($data['waktu_exspire']),
                    "jam" => format_jam($data['waktu_exspire']),
                    "role_user" => $role['name_role']

                ];
                echo json_encode($data_pembayaran);
            } else {
                # code...
                $data_pembayaran = [
                    "data" =>    $data,
                    "tanggal" =>  format_tanggal_indo_pendek($data['waktu_bayar']),
                    "jam" => format_jam($tanggal),
                    "role_user" => $role['name_role']

                ];
                echo json_encode($data_pembayaran);
            }
        } else {
            # code...
            echo "data ID Transaksi Tidak Boleh Kosong";
        }
    }

    // proccess pembayaran manual lewat admin
    public function proccess_pembayaran_manual()
    {
        $this->form_validation->set_rules('id_transaksi', 'ID Tranasaksi', 'required|trim');
        $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim');
        $this->form_validation->set_rules('name_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('total_bayar', 'Total Bayar', 'required|trim');

        // ambil tanggal sekarang
        $date = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $id_transaksi = $this->input->post('id_transaksi', true);
        // cek ID Transaksi
        $cek_id_tansaksi = $this->M_pembayaran->get_id_transaksi();
        $selesksi = "";
        foreach ($cek_id_tansaksi as $data) {
            $data_selesksi = $data['id_transaksi'];
            $selesksi .= $data_selesksi . " ";
        }
        $arr_id_ransaksi = explode(" ", $selesksi);

        $data_user = $this->session->userdata('user');
        if ($this->form_validation->run() !== false) {
            // cek apakah transaksi sudah pernah dibayarkan
            if (in_array($id_transaksi, $arr_id_ransaksi)) {
                # code...
                $params_pembayaran = [
                    'metode_pembayaran' => "manual",
                    'waktu_bayar' =>   $date->format('Y-m-d H:i:s'),
                    'pembayaran_by' => $data_user['user_name'],
                ];
                // where
                $where = ['id_transaksi' => $id_transaksi];
                $url_simpan = $this->M_pembayaran->update_pembayaran($params_pembayaran, $where);
            } else {
                # code...
                $params_pembayaran = [
                    'id_transaksi' => $id_transaksi,
                    'metode_pembayaran' => "manual",
                    'waktu_bayar' =>   $date->format('Y-m-d H:i:s'),
                    'pembayaran_by' => $data_user['user_name'],
                ];
                $url_simpan = $this->M_pembayaran->add_pembayaran($params_pembayaran);
            }
            if ($url_simpan) {
                # code...
                $params_update_transaksi = [
                    'status_pembayaran' => 'succes'
                ];
                // where
                $where = ['id_transaksi' => $this->input->post('id_transaksi', true)];

                if ($this->M_pembayaran->update_status_transaksi($params_update_transaksi, $where)) {
                    # code...
                    $this->session->set_flashdata('success_bayar', 'Pembayran Dengan No Transaksi ' . $this->input->post('id_transaksi', true) . ' Berhasil ');
                    redirect('operator/pembayaran');
                } else {
                    # code...
                    $this->session->set_flashdata('gagal_bayar', 'Pembayran Dengan No Transaksi ' . $this->input->post('id_transaksi', true) . ' Gagal ');
                }
            } else {
                # code...
                $this->session->set_flashdata('gagal_bayar', 'Pembayran Dengan No Transaksi ' . $this->input->post('id_transaksi', true) . ' Gagal ');
            }
        }
        redirect('operator/pembayaran');
    }
}
