<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-0Rl2wLFxo_6DYeZ3f9vlTAOT', 'production' => false);
        $this->load->library('veritrans');
        $this->veritrans->config($params);
        $this->load->helper('url');
    }

    public function index()
    {
        echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result, "true");


        // waktu bayar
        $waktu_bayar = $result['transaction_time'];
        // get order id
        $order_id = $result['order_id'];
        // get transaksi id
        $trasaksi_id = $this->db->get_where('pembayaran', array('id_order' => $order_id))->row_array();
        // var_dump($trasaksi_id);
        // die;


        // jika status pembayaran berhasil  
        if ($result['transaction_status'] == 'settlement') {
            // update status pembayaran pada tabel transaksi
            $params = [
                'status_pembayaran' => 'succes',
                'waktu_bayar' => $waktu_bayar
            ];
            $where = ['id_transaksi' => $trasaksi_id['id_transaksi']];
            return  $this->db->update('transaksi', $params, $where);
        } elseif ($result['transaction_status'] == 'expire') {
            # code...
            $params = [
                'status_pembayaran' => 'gagal',
                'waktu_bayar' => $waktu_bayar
            ];
            $where = ['id_transaksi' => $trasaksi_id['id_transaksi']];
            return  $this->db->update('transaksi', $params, $where);
        }

        // error_log(print_r($result, TRUE));
    }
}
