<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->db_pelayanan = $this->load->database('pelayanan', TRUE);
    }

    //get all transaksi
    public function get_all_transaksi($params)
    {
        $sql = "SELECT a.id_transaksi,a.tanggal_transaksi, a.id_pelanggan ,a.jumlah_meteran,a.total_bayar, b.name_pelanggan, a.start_meter, a.end_meter FROM transaksi a JOIN pelanggan b on a.id_pelanggan = b.id_pelanggan WHERE MONTH(a.tanggal_transaksi) LIKE ? AND YEAR(a.tanggal_transaksi) LIKE ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_total_pendapatan()
    {
        $sql = "SELECT SUM(total_bayar) AS 'total' FROM transaksi";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    // get refences  bulan
    public function get_bulan_transaksi()
    {
        $sql = "SELECT a.tanggal_transaksi FROM transaksi a group by month(a.tanggal_transaksi) ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    // get refences  bulan
    public function get_tahun_transaksi()
    {
        $sql = "SELECT a.tanggal_transaksi FROM transaksi a group by year(a.tanggal_transaksi) ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
}
