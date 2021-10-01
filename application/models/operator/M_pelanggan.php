<?php
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
        $sql = "SELECT a.id_pelanggan, a.name_pelanggan, a.rt_pelanggan, a.rw_pelanggan FROM pelanggan a";
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

    // get last id
    function get_pelanggan_last_id()
    {
        $sql = "SELECT right(id_pelanggan,2)'last_number' FROM pelanggan  ORDER BY id_pelanggan DESC LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 999) {
                return false;
            }
            $zero = 'P';
            for ($i = strlen($number); $i < 3; $i++) {
                $zero .= '0';
            }
            return $zero . $number;
        } else {
            // create new number
            return 'P001';
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
}
