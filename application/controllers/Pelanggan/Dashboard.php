<?php

use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
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

    public function meteran_bulan_ini($user_id)
    {
        $sql = "SELECT a.jumlah_meteran FROM transaksi a join pelanggan b on a.id_pelanggan=b.id_pelanggan WHERE b.user_id = ? and MONTH(a.tanggal_transaksi)=MONTH(now()) AND YEAR(a.tanggal_transaksi) = YEAR(now())";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get total pendapatan per bulan
    public function tagihan_bulan_ini($user_id)
    {
        $sql = "SELECT a.total_bayar AS 'total' FROM transaksi a join pelanggan b on a.id_pelanggan=b.id_pelanggan WHERE b.user_id = ? and MONTH(a.tanggal_transaksi)= MONTH(now()) AND YEAR(a.tanggal_transaksi) = YEAR(now())";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }


    public function labelChart($user_id)
    {
        $sql = "SELECT a.jumlah_meteran, SUM(a.total_bayar) AS 'jumlah',a.tanggal_transaksi  FROM  transaksi a join pelanggan b on a.id_pelanggan=b.id_pelanggan WHERE b.user_id = ?   GROUP BY MONTH(a.tanggal_transaksi),YEAR(a.tanggal_transaksi)  ORDER BY YEAR(a.tanggal_transaksi) ,MONTH(a.tanggal_transaksi)  LIMIT 12";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get user profile
    public function get_profile($user_id)
    {
        $sql = "SELECT a.* , b.* from user_table a join pelanggan b on a.user_id = b.user_id where a.user_id = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get malam atau siang
    public function get_waktu()
    {
        //ubah timezone menjadi jakarta
        date_default_timezone_set("Asia/Jakarta");

        //ambil jam dan menit
        $jam = date('H:i');

        //atur salam menggunakan IF
        if ($jam > '00:00' && $jam < '18.00') {
            # code...
            $waktu = 'siang';
        } else {
            # code...
            $waktu = 'malam';
        }


        return $waktu;
    }

    public function index()
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $data['user_data'] = $data_user;
        $data['total_meteran'] = $this->meteran_bulan_ini($data_user['user_id']);
        $data['total_pendaptan'] = $this->tagihan_bulan_ini($data_user['user_id']);
        $data['data_cart'] = $this->labelChart($data_user['user_id']);
        $data['profile'] = $this->get_profile($data_user['user_id']);
        $data['waktu'] = $this->get_waktu();
        $this->load->view('pelanggan/side_bar', $data);
        $this->load->view('pelanggan/dashboard/index', $data);
        $this->load->view('templete/footer');
    }
}
