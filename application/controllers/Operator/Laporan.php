<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Mpdf\Mpdf;

class Laporan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    //load model
    $this->load->model('operator/M_laporan');
    $this->load->library('form_validation');
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
    // $data['bulan_transaksi'] = $this->M_laporan->get_bulan_transaksi();
    // $data['tahun_transaksi'] = $this->M_laporan->get_tahun_transaksi();


    $search = $this->session->userdata('transaksi_search');
    if (isset($search)) {
      $data['search'] = $this->session->userdata('transaksi_search');
    } else {
      $data['search'] = [
        'bulan' => null,
        'tahun' => null
      ];
    }
    $transaksi_bulan = empty($search['bulan']) ?   "%"  :  $search['bulan'];
    $transaksi_tahun = empty($search['tahun']) ? '%'  :  '%' . $search['tahun'] . '%';

    $data['bulan'] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    $data['transaksi'] = $this->M_laporan->get_all_transaksi(array($transaksi_bulan, $transaksi_tahun));
    // var_dump($data['transaksi']);
    // die;
    $this->load->view('operator/laporan/index', $data);
    $this->load->view('templete/footer');
  }

  public function search_process()
  {
    if ($this->input->post('save') == "Reset") {
      $this->session->unset_userdata('transaksi_search');
    } else {
      $params = array(
        "bulan" => $this->input->post("bulan_transaksi"),
        "tahun" => $this->input->post("tahun_transaksi")
      );
      $this->session->set_userdata("transaksi_search", $params);
    }
    // redirect
    redirect("operator/laporan");
  }
}
