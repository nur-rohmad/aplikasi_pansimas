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
    // get pelanggan by id
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
}
