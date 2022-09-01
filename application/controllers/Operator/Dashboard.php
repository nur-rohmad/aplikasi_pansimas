<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Mpdf\Mpdf;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek apakah user sudah login
        cek_login();
        //mengontrol hak akses user
        check_admin();
    }

    public function labelChart()
    {
        $sql = "SELECT a.jumlah_meteran, SUM(a.total_bayar) AS 'jumlah',a.tanggal_transaksi  FROM  transaksi a  GROUP BY MONTH(a.tanggal_transaksi),YEAR(a.tanggal_transaksi)  ORDER BY YEAR(a.tanggal_transaksi) ,MONTH(a.tanggal_transaksi)  LIMIT 12";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // label chart berdasarkan tahun
    public function labelChart_tahun($params)
    {
        $sql = "SELECT a.jumlah_meteran, SUM(a.total_bayar) AS 'jumlah',a.tanggal_transaksi  FROM  transaksi a  WHERE YEAR(a.tanggal_transaksi) = ? GROUP BY MONTH(a.tanggal_transaksi),YEAR(a.tanggal_transaksi)  ORDER BY YEAR(a.tanggal_transaksi) ,MONTH(a.tanggal_transaksi)  LIMIT 12";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get total pelanggan
    public function total_pelanggan()
    {
        $sql = "SELECT COUNT(*) AS 'total' FROM pelanggan";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }

    public function get_tahun_transaksi()
    {
        # code...
        $sql = "SELECT YEAR(tanggal_transaksi) as 'tahun' from transaksi group by YEAR(tanggal_transaksi)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get total pendapatan per bulan
    public function total_pendapatan()
    {
        $sql = "SELECT SUM(a.total_bayar) AS 'total' FROM transaksi a WHERE MONTH(a.tanggal_transaksi)= MONTH(now()) AND YEAR(a.tanggal_transaksi) = YEAR(now())";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }

    public function total_meteran()
    {
        $sql = "SELECT SUM(a.jumlah_meteran) AS 'total' FROM transaksi a WHERE MONTH(a.tanggal_transaksi)= MONTH(now()) AND YEAR(a.tanggal_transaksi) = YEAR(now())";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }

    // chart lingkaran

    // get data pelanggan per rw
    public function get_total_pelanggan_per_rw()
    {
        $sql = "SELECT COUNT(a.id_pelanggan) AS 'total', a.rw_pelanggan FROM pelanggan a GROUP BY a.rw_pelanggan";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
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

    // get user profile
    public function get_profile($user_id)
    {
        $sql = "SELECT a.*  from user_table a  where a.user_id = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    public function index()
    {
        // var_dump($this->get_total_pelanggan_per_rw());
        // die;
        if ($this->session->userdata('user') == null) {
            redirect('login');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $data['user_data'] = $data_user;
        $this->load->view('templete/side_bar', $data);
        $data['data_cart'] = $this->labelChart();
        $data['total_pelanggan'] = $this->total_pelanggan();
        $data['total_pendaptan'] = $this->total_pendapatan();
        $data['total_meteran'] = $this->total_meteran();
        $data['profile'] = $this->get_profile($data_user['user_id']);
        $data['waktu'] = $this->get_waktu();
        $data['tahun'] = $this->get_tahun_transaksi();
        $data['data_cahart_donut'] = $this->get_total_pelanggan_per_rw();
        $this->load->view('operator/dashboard', $data);
        $this->load->view('templete/footer');
    }


    // get data pendapatan by tahun
    public function get_pendapatan_tahunan($tahun)
    {
        // $tahun = $this->input->get('tahun');

        # code...
        $result = [];
        $data = $this->labelChart_tahun($tahun);
        foreach ($data as $key => $value) {
            # code...
            $result['label'][$key] = format_indo($value['tanggal_transaksi']);
            $result['jumlah'][$key] = $value['jumlah'];
        }

        $data_outut = [
            'data' => $result
        ];
        // $result = [
        //     'label' => format_indo($data['tanggal_transaksi']),
        //     'jumlah' => $data['jumlah']
        // ];
        echo json_encode($data_outut);
    }
}
