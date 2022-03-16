<?php
defined('BASEPATH') or exit('No direct script access allowed');

function cek_login()
{
    $ci = &get_instance();
    if ($ci->session->userdata('user') == NULL) {
        # code...
        redirect('login');
    }
}

function check_admin()
{
    $ci = &get_instance();
    $user_data = $ci->session->userdata('user');
    if ($user_data['user_role'] != 1) {
        redirect('pelanggan/dashboard');
    }
}

function cek_pengaduan()
{
    $ci = &get_instance();
    $user_data = $ci->session->userdata('user');
    $ci->load->model('M_pengaduan');
    if ($user_data['user_role'] == 1) {
        # code...
        $pengaaduan = $ci->M_pengaduan->get_total_pengaduan_baru();
        return $pengaaduan;
    } else {
        # code...
        $pengaaduan = $ci->M_pengaduan->get_total_pengaduan_belum_dibaca($user_data['user_id']);
        return $pengaaduan;
    }
}
