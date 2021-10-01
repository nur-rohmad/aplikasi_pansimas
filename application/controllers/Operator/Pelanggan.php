<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        //load model
        $this->load->model('operator/M_pelanggan');
        $this->load->library('form_validation');

    }
    public function index(){
        if($this->session->userdata('user') == null){
            redirect('login');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get_all_pelanggan();
        $this->load->view('operator/pelanggan/index', $data);
        $this->load->view('templete/footer');
    }

    public function add_pelanggan(){
        // var_dump($this->M_pelanggan->get_pelanggan_last_id());
        // die;
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $this->load->view('operator/pelanggan/add_pelanggan');
        $this->load->view('templete/footer');
    }

    public function procces_add(){
        $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('rw_pelanggan', 'RW Pelanggan', 'required');
        $this->form_validation->set_rules('rt_pelanggan', 'RT Pelanggan', 'required');
        $this->form_validation->set_rules('end_meter', 'Meteran Awal', 'required');
       $id_pelanggan = $this->input->post('id_pelanggan');
        //validasi data
        
        if($this->form_validation->run() !== FALSE) {
            if($this->db->get_where('pelanggan',['id_pelanggan' => $id_pelanggan])->row_array()){
                $this->session->set_flashdata('gagal', 'ID Pelanggan telah digunakan');
                redirect('operator/pelanggan/add_pelanggan');
            }
            $params = [
                'id_pelanggan' => $id_pelanggan,
                'name_pelanggan' => $this->input->post('nama_pelanggan'),
                'rw_pelanggan' => $this->input->post('rw_pelanggan'),
                'rt_pelanggan' => $this->input->post('rt_pelanggan')
            ];
            //proses insert
            if($this->M_pelanggan->insert_pelanggan($params)){
                $params_insert_stand_meter = [
                    "id_pelanggan" => $this->input->post('id_pelanggan'),
                    "end_meter" => $this->input->post('end_meter')
                ];
            if($this->M_pelanggan->insert_stand_meter($params_insert_stand_meter)){

                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
                redirect('operator/pelanggan');
            }else{
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
            }else{
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        }else{
            $this->session->set_flashdata('gagal', 'Anda Perlu Mengisi Form Untuk Melanjutkan');
        }
        //default page
        redirect('operator/pelanggan/add_pelanggan');
    }

    public function edit_pelanggan($id_pelanggan){
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
        $this->load->view('operator/pelanggan/edit', $data);
        $this->load->view('templete/footer');
    }

    //proses edit
    public function procces_edit(){
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('rw_pelanggan', 'RW Pelanggan', 'required');
        $this->form_validation->set_rules('rt_pelanggan', 'RT Pelanggan', 'required');
        //validasi data
        if($this->form_validation->run() !== FALSE) {
            $params = [
                'name_pelanggan' => $this->input->post('nama_pelanggan'),
                'rw_pelanggan' => $this->input->post('rw_pelanggan'),
                'rt_pelanggan' => $this->input->post('rt_pelanggan')
            ];
            //where
            $where = ['id_pelanggan' => $this->input->post('id_pelanggan')];
            //proses insert
            if($this->M_pelanggan->update_pelanggan($params, $where)){
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
                redirect('operator/pelanggan');
            }else{
                $this->session->set_flashdata('notifikasi', 'Data Gagal disimpan');
            }
        }
        //default page
        redirect('pelanggan/operator/edit_pelanggan/' . $this->input->post('id_pelanggan'));
    }

    public function delete_pelanggan($id_pelanggan){
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
        $this->load->view('operator/pelanggan/delete', $data);
        $this->load->view('templete/footer');
    }

     //proses delte
     public function procces_delete(){
        $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim');
         //validasi data
         if($this->form_validation->run() !== FALSE) {
            //where
            $where = ['id_pelanggan' => $this->input->post('id_pelanggan')];
            //proses insert
            if($this->M_pelanggan->delete_pelanggan($where)){
                $this->session->set_flashdata('success', 'Data Berhasil dihapus');
                redirect('operator/pelanggan');
            }else{
                $this->session->set_flashdata('success', 'Data Gagal dihapus');
            }
        }
        //default page
        redirect('pelanggan/operator/delete_pelanggan/' . $this->input->post('id_pelanggan'));

     }

     public function cetak_pelanggan(){
        $this->load->view('templete/header');
        $data['pelanggan'] = $this->M_pelanggan->get_all_pelanggan();
        $this->load->view('operator/pelanggan/cetak_pelanggan', $data);
    
     }

}