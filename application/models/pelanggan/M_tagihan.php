<?php

use Prophecy\Promise\ThrowPromise;

defined('BASEPATH') or exit('No direct script access allowed');

class M_tagihan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->db_pelayanan = $this->load->database('pelayanan', TRUE);
    }

    // get transaksi by user_id
    public function get_transakssi_by_user_id($params)
    {
        $sql = "SELECT a.*, b.name_pelanggan FROM transaksi a JOIN pelanggan b ON a.id_pelanggan = b.id_pelanggan WHERE b.user_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get detail print
    public function get_data_print($params)
    {
        $sql = "SELECT a.tanggal_transaksi, a.id_pelanggan ,a.jumlah_meteran,a.total_bayar,a.biaya_pemakaian,a.tanggal_transaksi, b.name_pelanggan, b.rw_pelanggan, b.rt_pelanggan, a.start_meter, a.end_meter, c.waktu_bayar FROM transaksi a JOIN pelanggan b on a.id_pelanggan = b.id_pelanggan join pembayaran c on a.id_transaksi= c.id_transaksi  WHERE a.id_transaksi = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    //get harga per metter
    public function get_harga_permeter()
    {
        $sql = "SELECT  a.jumlah_tagihan FROM tagihan a where a.id_tagihan = 'TG1' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    //get harga abunemen
    public function get_harga_abunemen()
    {
        $sql = "SELECT  a.jumlah_tagihan FROM tagihan a where a.id_tagihan = 'TG2' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    // get transakasi by id
    public function get_transakssi_by_id($transaksi_id)
    {
        $sql = "SELECT a.*, b.* FROM transaksi a JOIN pelanggan b ON a.id_pelanggan=b.id_pelanggan  where a.id_transaksi = ?";
        $query = $this->db->query($sql, $transaksi_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }
    // get transakasi_complete by id
    public function get_transakssi_complete_by_id($transaksi_id)
    {
        $sql = "SELECT a.*, b.*, c.* FROM transaksi a JOIN pelanggan b ON a.id_pelanggan=b.id_pelanggan join pembayaran c on a.id_transaksi=c.id_transaksi  where a.id_transaksi = ?";
        $query = $this->db->query($sql, $transaksi_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    // get id_transaksi di tabel pembayaran 
    public function get_id_transaksi()
    {
        $sql = "SELECT id_transaksi from pembayaran";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // update status pembayaran
    public function update_status_pembayaran($params, $where)
    {
        return $this->db->update('transaksi', $params, $where);
    }

    // insert detail pembayaran
    public function insert_pebayaran($params)
    {
        return $this->db->insert('pembayaran', $params);
    }

    // update pembayaran 
    public function update_pebayaran($params, $where)
    {
        return $this->db->update('pembayaran', $params, $where);
    }
}
