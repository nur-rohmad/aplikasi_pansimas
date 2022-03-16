<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembayaran extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->db_pelayanan = $this->load->database('pelayanan', TRUE);
    }

    public function get_transaksi_belum_bayar()
    {
        $sql = "SELECT a.*, b.* FROM transaksi a join pelanggan b on a.id_pelanggan = b.id_pelanggan where a.status_pembayaran = 'belum_bayar' OR a.status_pembayaran = 'gagal' order by a.tanggal_transaksi desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get transaksi belum bayar by id
    public function get_transaksi_belum_bayar_by_id($id)
    {
        $sql = "SELECT a.*, b.* FROM transaksi a join pelanggan b on a.id_pelanggan = b.id_pelanggan  where a.id_transaksi=?";
        $query = $this->db->query($sql, $id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_transaksi_telah_bayar()
    {
        $sql = "SELECT a.*, b.*, c.* FROM transaksi a JOIN pelanggan b ON a.id_pelanggan=b.id_pelanggan join pembayaran c on a.id_transaksi=c.id_transaksi WHERE a.status_pembayaran = 'succes' OR a.status_pembayaran = 'waiting' order by c.waktu_bayar desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    public function get_transaksi_telah_bayar_by_id($id_transasksi)
    {
        $sql = "SELECT a.*, b.*, c.* FROM transaksi a JOIN pelanggan b ON a.id_pelanggan=b.id_pelanggan join pembayaran c on a.id_transaksi=c.id_transaksi where c.id_transaksi = ?";
        $query = $this->db->query($sql, $id_transasksi);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
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

    // get role user
    public function get_role_user($user_name)
    {
        $sql = "SELECT a.* , b.* ,c.* from user_table a join user_role_table b on a.user_id=b.user_id join role_table c on b.role_id=c.role_id where a.user_name = ?";
        $query = $this->db->query($sql, $user_name);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    // ========================================== query dasar============================

    // add tabel data in pembayaran
    public function add_pembayaran($params)
    {
        return $this->db->insert('pembayaran', $params);
    }

    // update status transaksi
    public function update_status_transaksi($params, $where)
    {
        return $this->db->update('transaksi', $params, $where);
    }
    // update Pembayaran
    public function update_pembayaran($params, $where)
    {
        return $this->db->update('pembayaran', $params, $where);
    }
}
