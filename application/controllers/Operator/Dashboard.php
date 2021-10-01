<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Mpdf\Mpdf;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function labelChart()
    {
        $sql = "SELECT a.jumlah_meteran, SUM(a.jumlah_meteran) AS 'jumlah',a.tanggal_transaksi  FROM  transaksi a  GROUP BY MONTH(a.tanggal_transaksi),YEAR(a.tanggal_transaksi)  ORDER BY YEAR(a.tanggal_transaksi) DESC,MONTH(a.tanggal_transaksi)  LIMIT 12";
        $query = $this->db->query($sql);
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



    public function index()
    {
        if ($this->session->userdata('user') == null) {
            redirect('login');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['data_cart'] = $this->labelChart();
        $data['total_pelanggan'] = $this->total_pelanggan();
        $data['total_pendaptan'] = $this->total_pendapatan();
        $data['total_meteran'] = $this->total_meteran();
        $this->load->view('operator/dashboard', $data);
        $this->load->view('templete/footer');
    }
}
