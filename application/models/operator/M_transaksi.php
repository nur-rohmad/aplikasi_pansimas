<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->db_pelayanan = $this->load->database('pelayanan', TRUE);
    }

    public function get_all_tagihan()
    {
        $sql = "SELECT a.id_tagihan,a.name_tagihan, a.jumlah_tagihan FROM tagihan a";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    //get tagihan by id
    public function get_tagihan_by_id($id_tagihan)
    {
        $sql = "SELECT a.id_tagihan,a.name_tagihan, a.jumlah_tagihan FROM tagihan a WHERE a.id_tagihan = ?";
        $query = $this->db->query($sql, $id_tagihan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    //insert tagihan
    public function insert_tagihan($params)
    {
        return $this->db->insert('tagihan', $params);
    }

    // update tagihan
    public function update_tagihan($params, $where)
    {
        return $this->db->update('tagihan', $params, $where);
    }

    //delete tagihan
    public function delete_tagihan($where)
    {
        return $this->db->delete('tagihan', $where);
    }

    //start transaksi

    //get all transaksi
    public function get_all_transaksi()
    {
        $sql = "SELECT a.id_transaksi,a.tanggal_transaksi, a.id_pelanggan ,a.jumlah_meteran,a.total_bayar, b.name_pelanggan, a.start_meter, a.end_meter FROM transaksi a JOIN pelanggan b on a.id_pelanggan = b.id_pelanggan  WHERE MONTH(a.tanggal_transaksi) = MONTH(now())";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get all transaksi
    public function get_data_print($params)
    {
        $sql = "SELECT a.tanggal_transaksi, a.id_pelanggan ,a.jumlah_meteran,a.total_bayar,a.biaya_pemakaian,a.tanggal_transaksi, b.name_pelanggan, b.rw_pelanggan, b.rt_pelanggan, a.start_meter, a.end_meter FROM transaksi a JOIN pelanggan b on a.id_pelanggan = b.id_pelanggan WHERE a.id_transaksi = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    // get start meter pelanggan
    public function get_start_meter($id_pelanggan)
    {
        $sql = "SELECT a.end_meter FROM stand_meter_pelanggan a where a.id_pelanggan = ?";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
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

    //get last tagian 
    function get_transaksi_last_id()
    {
        $sql = "SELECT right(id_transaksi,9)'last_number' FROM transaksi  ORDER BY id_transaksi DESC LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number >= 999999999) {
                return false;
            }
            $zero = 'T';
            for ($i = strlen($number); $i < 9; $i++) {
                $zero .= '0';
            }
            return $zero . $number;
        } else {
            // create new number
            return 'T000000001';
        }
    }


    public function get_total_pendapatan()
    {
        $sql = "SELECT SUM(total_bayar) AS 'total' FROM transaksi WHERE MONTH(tanggal_transaksi) = MONTH(now()) AND YEAR(tanggal_transaksi) = YEAR(now())";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_total_meteran()
    {
        $sql = "SELECT SUM(jumlah_meteran) AS 'total' FROM transaksi WHERE MONTH(tanggal_transaksi) = MONTH(now()) AND YEAR(tanggal_transaksi) = YEAR(now())";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_transaksi_by_id($id_transaksi)
    {
        $sql = "SELECT a.id_transaksi, a.tanggal_transaksi, a.id_pelanggan ,a.jumlah_meteran,a.total_bayar,a.biaya_pemakaian,a.tanggal_transaksi, b.name_pelanggan, b.rw_pelanggan, b.rt_pelanggan, a.start_meter, a.end_meter FROM transaksi a JOIN pelanggan b on a.id_pelanggan = b.id_pelanggan WHERE a.id_transaksi = ?";
        $query = $this->db->query($sql, $id_transaksi);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_total_transaksi_pelanggan($id_pelanggan)
    {
        $sql = "SELECT COUNT(*) AS 'total' FROM transaksi WHERE id_pelanggan = ?";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return array();
        }
    }

    public function get_last_transaksi_pelanggan($id_pelanggan)
    {
        $sql = "SELECT  a.end_meter, a.start_meter, a.jumlah_meteran FROM transaksi a WHERE a.id_pelanggan = ? ORDER BY a.id_transaksi   DESC LIMIT 1";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    public function get_last_transaksi_pelanggans($id_pelanggan)
    {
        $sql = "SELECT  a.end_meter, a.start_meter, a.jumlah_meteran FROM transaksi a WHERE a.id_pelanggan = ? ORDER BY a.id_transaksi   DESC LIMIT 1,1";
        $query = $this->db->query($sql, $id_pelanggan);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //references data pelanggan 
    public function selesksi_pelanggan()
    {
        $sql = "SELECT b.id_pelanggan FROM  transaksi b WHERE MONTH(b.tanggal_transaksi) = MONTH(NOW())";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    // insert transaksi
    public function insert_transaksi($params)
    {
        return $this->db->insert('transaksi', $params);
    }

    //update stand meter pelangan
    public function update_stand_meter($params, $where)
    {
        return $this->db->update('stand_meter_pelanggan', $params, $where);
    }

    //delete transaksi
    public function delete_transaksi($where)
    {
        return $this->db->delete('transaksi', $where);
    }
}
