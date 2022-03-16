<?php

use Prophecy\Promise\ThrowPromise;

defined('BASEPATH') or exit('No direct script access allowed');

class M_pengaduan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // get no pengaduan
    //get last tagian 
    function get_pengaduan_last_id()
    {
        $sql = "SELECT right(id_pengaduan,9)'last_number' FROM pengaduan  ORDER BY id_pengaduan desc LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            
            $number = intval($result['last_number']) + 1;
            if ($number >= 999999999) {
                return false;
            }
            $zero = 'P';
            for ($i = strlen($number); $i < 9; $i++) {
                $zero .= '0';
            }
            return $zero . $number;
        } else {
            // create new number
            return 'T000000001';
        }
    }

    // get all data pengaduan by pelanggan
    public function get_pengaduan_by_user($user_id)
    {
        $sql = "SELECT *, 
                CASE WHEN status_pengaduan = 'terkirim' THEN 'primary'
                     WHEN  status_pengaduan = 'diproses' THEN 'success'
                     WHEN  status_pengaduan = 'ditolak' THEN 'danger'
                     WHEN  status_pengaduan = 'selesai' THEN 'dark'
                END AS 'color_status',
                CASE WHEN read_status_user = 'belum_dilihat' THEN '#F2F2F2'
                    ELSE '#FFFFFF' 
                END AS 'color_bg'
                FROM pengaduan WHERE pengaduan_by = ? ORDER BY read_status_user , tgl_pengaduan desc";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get all data pengaduan
    public function get_all_pengaduan()
    {
        $sql = "SELECT *, 
                CASE WHEN status_pengaduan = 'terkirim' THEN 'primary'
                     WHEN  status_pengaduan = 'diproses' THEN 'success'
                     WHEN  status_pengaduan = 'ditolak' THEN 'danger'
                     WHEN  status_pengaduan = 'selesai' THEN 'dark'
                END AS 'color_status',
                CASE WHEN read_status_admin = 'belum_dilihat' THEN '#F2F2F2'
                    ELSE '#FFFFFF' 
                END AS 'color_bg'
                FROM pengaduan ORDER BY read_status_admin desc, tgl_pengaduan desc";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get total Pengaduan baru
    public function get_total_pengaduan_baru()
    {
        $sql = "SELECT COUNT(id_pengaduan) AS 'total' FROM pengaduan WHERE read_status_admin = 'belum_dilihat'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }

    // get total pengaduan belum dibaca user 
    public function get_total_pengaduan_belum_dibaca($user_id)
    {
        $sql = "SELECT COUNT(id_pengaduan) AS 'total' FROM pengaduan WHERE read_status_user = 'belum_dilihat' AND pengaduan_by = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }

    // get pengaduan by id
    public function pengaduan_by_id($id_pengaduan)
    {
        $sql = "SELECT a.*, b.name_pelanggan FROM pengaduan a
                INNER JOIN pelanggan b ON a.pengaduan_by = b.user_id
                WHERE a.id_pengaduan = ?";
        $query = $this->db->query($sql, $id_pengaduan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    // query dasar

    // insert
    public function insert_pengaduan($params)
    {
        return $this->db->insert('pengaduan', $params);
    }

    // update
    public function update_pengaduan($params, $where)
    {
        return $this->db->update('pengaduan', $params, $where);
    }
}
