<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('operator/M_pelanggan');
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
        $data['pelanggan'] = $this->M_pelanggan->get_all_pelanggan();
        $this->load->view('operator/pelanggan/index', $data);
        $this->load->view('templete/footer');
    }

    public function add_pelanggan()
    {
        // var_dump($this->M_pelanggan->get_pelanggan_last_id());
        // die;
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $this->load->view('operator/pelanggan/add_pelanggan');
        $this->load->view('templete/footer');
    }

    public function procces_add()
    {
        $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('rw_pelanggan', 'RW Pelanggan', 'required');
        $this->form_validation->set_rules('rt_pelanggan', 'RT Pelanggan', 'required');
        $this->form_validation->set_rules('end_meter', 'Meteran Awal', 'required');
        $id_pelanggan = $this->input->post('id_pelanggan');
        //validasi data

        if ($this->form_validation->run() !== FALSE) {
            if ($this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row_array()) {
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
            if ($this->M_pelanggan->insert_pelanggan($params)) {
                $params_insert_stand_meter = [
                    "id_pelanggan" => $this->input->post('id_pelanggan'),
                    "end_meter" => $this->input->post('end_meter')
                ];
                if ($this->M_pelanggan->insert_stand_meter($params_insert_stand_meter)) {

                    $this->session->set_flashdata('success', 'Data Berhasil disimpan');
                    redirect('operator/pelanggan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
                }
            } else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda Perlu Mengisi Form Untuk Melanjutkan');
        }
        //default page
        redirect('operator/pelanggan/add_pelanggan');
    }

    public function edit_pelanggan($id_pelanggan)
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
        $this->load->view('operator/pelanggan/edit', $data);
        $this->load->view('templete/footer');
    }

    //proses edit
    public function procces_edit()
    {
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('rw_pelanggan', 'RW Pelanggan', 'required');
        $this->form_validation->set_rules('rt_pelanggan', 'RT Pelanggan', 'required');
        //validasi data
        if ($this->form_validation->run() !== FALSE) {
            $params = [
                'name_pelanggan' => $this->input->post('nama_pelanggan'),
                'rw_pelanggan' => $this->input->post('rw_pelanggan'),
                'rt_pelanggan' => $this->input->post('rt_pelanggan')
            ];
            //where
            $where = ['id_pelanggan' => $this->input->post('id_pelanggan')];
            //proses insert
            if ($this->M_pelanggan->update_pelanggan($params, $where)) {
                $this->session->set_flashdata('success', 'Data Berhasil disimpan');
                redirect('operator/pelanggan');
            } else {
                $this->session->set_flashdata('notifikasi', 'Data Gagal disimpan');
            }
        }
        //default page
        redirect('pelanggan/operator/edit_pelanggan/' . $this->input->post('id_pelanggan'));
    }

    public function delete_pelanggan($id_pelanggan)
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
        $this->load->view('operator/pelanggan/delete', $data);
        $this->load->view('templete/footer');
    }

    //proses delte
    public function procces_delete()
    {
        $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim');
        //validasi data
        if ($this->form_validation->run() !== FALSE) {
            //where
            $where = ['id_pelanggan' => $this->input->post('id_pelanggan')];
            //proses insert
            if ($this->M_pelanggan->delete_pelanggan($where)) {
                if ($this->M_pelanggan->delete_pelanggan_stand_meter($where)) {
                    if ($this->M_pelanggan->delete_pelanggan_transaksi($where)) {
                        $this->session->set_flashdata('success', 'Data Berhasil dihapus');
                        redirect('operator/pelanggan');
                    } else {
                        $this->session->set_flashdata('success', 'Data Gagal dihapus');
                    }
                } else {
                    $this->session->set_flashdata('success', 'Data Gagal dihapus');
                }
            } else {
                $this->session->set_flashdata('success', 'Data Gagal dihapus');
            }
        }
        //default page
        redirect('pelanggan/operator/delete_pelanggan/' . $this->input->post('id_pelanggan'));
    }

    public function cetak_pelanggan()
    {
        $this->load->view('templete/header');
        $data['pelanggan'] = $this->M_pelanggan->get_all_pelanggan();
        $this->load->view('operator/pelanggan/cetak_pelanggan', $data);
    }

    public function export_excel()
    {
        $styleJudul = [
            'font' => [
                'bold' => true,
                'size' => 12
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //Set Default Teks
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);
        //Style Judul table
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "Daftar Pelanggan KP-SPAM Bintoyo");

        $spreadsheet->getActiveSheet()
            ->mergeCells("A1:E1");

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getFont()
            ->setSize(14);

        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // style lebar kolom
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(30);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(50);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(20);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Id Pelanggan');
        $sheet->setCellValue('C2', 'Nama');
        $sheet->setCellValue('D2', 'RW');
        $sheet->setCellValue('E2', 'RT');


        // STYLE judul table
        $spreadsheet->getActiveSheet()
            ->getStyle('A2:E2')
            ->applyFromArray($styleJudul);

        $pelanggan = $this->M_pelanggan->get_all_pelanggan();
        $no = 1;
        $x = 3;
        foreach ($pelanggan as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['id_pelanggan']);
            $sheet->setCellValue('C' . $x, $row['name_pelanggan']);
            $sheet->setCellValue('D' . $x, $row['rw_pelanggan']);
            $sheet->setCellValue('E' . $x, $row['rt_pelanggan']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'daftar_pelanggan_KP_Spam_Bintoyo';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
