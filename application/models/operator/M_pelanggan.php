<?php

use Prophecy\Promise\ThrowPromise;

defined('BASEPATH') or exit('No direct script access allowed');

class M_pelanggan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->db_pelayanan = $this->load->database('pelayanan', TRUE);
    }

    //get data pelanggan
    public function get_all_pelanggan()
    {
        $sql = "SELECT a.id_pelanggan, a.name_pelanggan, a.rt_pelanggan, a.rw_pelanggan, b.* FROM pelanggan a join user_table b on a.user_id=b.user_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    //get pelanggan by id
    public function get__pelanggan_by_id($id_pelanggan)
    {
        $sql = "SELECT a.id_pelanggan, a.name_pelanggan, a.rt_pelanggan, a.rw_pelanggan FROM pelanggan a WHERE a.id_pelanggan = ?";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_al_id_pelanggan()
    {
        $sql = "SELECT id_pelanggan FROM pelanggan";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result['id_pelanggan'];
        } else {
            return array();
        }
    }
    //get data user
    public function get_user_detail($user_id)
    {
        $sql = "SELECT * FROM pelanggan WHERE id_pelanggan = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get detail pelanggan
    public function get_detail_pelanggan($user_id)
    {
        $sql = "SELECT * FROM pelanggan WHERE user_id = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get las user id
    public function get_last_user()
    {
        $sql = "SELECT max(user_id) as 'max' from user_table";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            $number = (int)$result['max'] + 1;
            return sprintf("%s", $number);
        } else {
            return array();
        }
    }
    // get last id
    function get_user_last_id()
    {
        $sql = "SELECT right(user_id,2)'last_number' FROM user_table  ORDER BY user_id DESC LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 999) {
                return false;
            }
            $zero = '0';
            for ($i = strlen($number); $i < 3; $i++) {
                $zero .= '0';
            }
            return $zero . $number;
        } else {
            // create new number
            return '0001';
        }
    }

    // get riwayat tagihan pelanggan
    public function riwayat_tagihan_pelanggan($id_pelanggan)
    {
        $sql = "SELECT * FROM transaksi WHERE id_pelanggan = ?";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // label grafik pelanggan
    public function labelChart($id_pelanggan)
    {
        $sql = "SELECT a.jumlah_meteran, SUM(a.total_bayar) AS 'jumlah',a.tanggal_transaksi  FROM  transaksi a join pelanggan b on a.id_pelanggan=b.id_pelanggan WHERE a.id_pelanggan = ?   GROUP BY MONTH(a.tanggal_transaksi),YEAR(a.tanggal_transaksi)  ORDER BY YEAR(a.tanggal_transaksi) ,MONTH(a.tanggal_transaksi)  LIMIT 12";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function insert_stand_meter($params)
    {
        return $this->db->insert('stand_meter_pelanggan', $params);
    }

    //insert pelanggan
    public function insert_pelanggan($params)
    {
        return $this->db->insert('pelanggan', $params);
    }

    // update pelanggan
    public function update_pelanggan($params, $where)
    {
        return $this->db->update('pelanggan', $params, $where);
    }

    // delete pelanggan
    public function delete_pelanggan($where)
    {
        $query = "DELETE FROM pelanggan WHERE id_pelanggan = ?";
        return $this->db->query($query, $where);
    }
    //delete pelanggan dari stand_meter
    public function delete_pelanggan_stand_meter($where)
    {
        $query = "DELETE FROM stand_meter_pelanggan WHERE id_pelanggan = ?";
        return $this->db->query($query, $where);
    }
    //delete pelanggan dari transaksi
    public function delete_user_pelanggan($where)
    {
        $query = "DELETE FROM user_table WHERE user_id = ?";
        return $this->db->query($query, $where);
    }
    // delet[e transaksi
    public function delete_user_transaksi($where)
    {
        $query = "DELETE FROM transaksi WHERE id_pelanggan = ?";
        return $this->db->query($query, $where);
    }

    //input user 
    public function insert_user($params)
    {
        return $this->db->insert('user_table', $params);
    }
    // update user
    public function update_user($params, $where)
    {
        return $this->db->update('user_table', $params, $where);
    }

    //insert role user
    public function insert_user_role($params)
    {
        return $this->db->insert('user_role_table', $params);
    }
}
