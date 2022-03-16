<?php
class Hak_akses
{
    public function index()
    {
        $url = $this->uri->segment(1);
        if ($url == 'pelanggan') {
            # code...
            $role_user = 3;
        } else {
            # code...
            $role_user = 1;
        }
        $data_user = $this->session->userdata('user');
        if ($data_user['role_id']  !== $role_user) {
            # code...
            print_r('akses_ditolam');
        }
    }
}
