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
        // cek apakah user sudah login
        cek_login();
        check_admin();
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

    //step akun
    public function step_akun($user_id = "")
    {
        // var_dump($this->db->get_where('user_table', array('user_id' => $user_id))->row_array());
        // die;
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['result'] = $this->db->get_where('user_table', array('user_id' => $user_id))->row_array();
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        if ($this->db->get_where('pelanggan', ['user_id' => $user_id])->row_array()) {
            $data['status_pelanggan'] = 1;
        } else {
            # code...
            $data['status_pelanggan'] = 0;
        }
        // var_dump($data['status_pelanggan']);
        // die;
        $this->load->view('operator/pelanggan/step_akun', $data);
        $this->load->view('templete/footer');
    }

    //procees steep akun
    public function procces_step_akun()
    {
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        $this->form_validation->set_message('is_unique', 'User Name Sudah DiGunakan Coba Menggunakan User Name Yang Lain');
        $this->form_validation->set_rules('user_name', 'User Name', 'required|trim');
        $this->form_validation->set_rules('user_alias', 'User Alias', 'required|trim');
        // get user id
        $user_id = $this->input->post('user_id', true);
        if (empty($user_id)) {
            $this->form_validation->set_rules('user_name', 'User Name', 'required|trim|is_unique[user_table.user_name]');
        }

        if ($this->form_validation->run() !== FALSE) {

            // get new user id
            $new_user_id = $this->M_pelanggan->get_user_last_id();
            // get passwaord
            $user_pass = $this->input->post('user_pass');
            $password = password_hash($user_pass, PASSWORD_DEFAULT);
            // cek apakah user name sudah digunakan 

            $params = [
                'user_name' => $this->input->post('user_name'),
                'user_alias' => $this->input->post('user_alias'),
                'user_photo' => 'default.png',
                'email' => $this->input->post('email'),
                'no_telp' => $this->input->post('no_telp')
            ];
            if (isset($user_pass)) {
                $params['user_pass'] = $password;
            }
            if ($user_id != null) {
                # code...
                $where = ['user_id' => $user_id];
                $query = $this->M_pelanggan->update_user($params, $where);
            } else {
                $params['user_id'] = $new_user_id;
                $query = $this->M_pelanggan->insert_user($params);
            }

            // var_dump($params);
            // die;
            if ($query) {
                # code...
                if (empty($user_id)) {
                    # code...
                    $params_user_role = [
                        'user_id' => $new_user_id,
                        'role_id' => '3'
                    ];
                    if ($this->M_pelanggan->insert_user_role($params_user_role)) {
                        # code...
                        $this->session->set_flashdata('success', 'Akun Berhasil Dibuat');
                        redirect('operator/pelanggan/step_pelanggan/' . (int)$new_user_id);
                    } else {
                        # code...
                        $this->session->set_flashdata('gagal', 'Data Gagal disimpan 1');
                    }
                } else {
                    $this->session->set_flashdata('success', 'Akun Berhasil Diedit');
                    redirect('operator/pelanggan/step_pelanggan/' . (int)$user_id);
                }
            } else {
                # code...
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan 2');
            }
        } else {
            # code...
            $this->session->set_flashdata('gagal', 'Gagal Menyimpan Data ');
            $this->session->set_flashdata('pesan_eror', validation_errors('<li>', '</li>'));

            $this->load->view('templete/header');
            $this->load->view('templete/navbar');
            $data['result'] = $this->db->get_where('user_table', array('user_id' => $user_id))->row_array();
            $data['user_data'] = $this->session->userdata('user');
            $this->load->view('templete/side_bar', $data);
            if ($this->db->get_where('pelanggan', ['user_id' => $user_id])->row_array()) {
                $data['status_pelanggan'] = 1;
            } else {
                # code...
                $data['status_pelanggan'] = 0;
            }
            $this->load->view('operator/pelanggan/step_akun', $data);
            $this->load->view('templete/footer');
        }
    }

    public function step_pelanggan($user_id)
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['user_detail'] = $this->M_pelanggan->get_detail_pelanggan($user_id);
        $data['user_id'] = $user_id;
        if ($this->db->get_where('pelanggan', ['user_id' => $user_id])->row_array()) {
            $data['status_pelanggan'] = '1';
        } else {
            # code...
            $data['status_pelanggan'] = '0';
        }
        $this->load->view('operator/pelanggan/step_pelanggan', $data);
        $this->load->view('templete/footer');
    }

    public function procces_add()
    {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $user_id = $this->input->post('user_id', true);
        // cek pelanggan baru atau tidak]
        $cek_pelanggan_baru = $this->db->get_where('pelanggan', ['user_id' => $user_id])->row_array();
        // cusstom message 
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        if ($cek_pelanggan_baru) {
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
            $this->form_validation->set_rules('rw_pelanggan', 'RW Pelanggan', 'required');
            $this->form_validation->set_rules('rt_pelanggan', 'RT Pelanggan', 'required');
        } else {
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
            $this->form_validation->set_rules('id_pelanggan', 'ID Pelanggan', 'required|trim');
            $this->form_validation->set_rules('end_meter', 'Meteran Awal', 'required');
        }
        //validasi data
        if ($this->form_validation->run() !== FALSE) {
            if ($cek_pelanggan_baru == false) {
                if ($this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row_array()) {
                    $this->session->set_flashdata('gagal', 'ID Pelanggan telah digunakan');
                    redirect('operator/pelanggan/step_pelanggan/' . $user_id);
                }
            }
            $params = [
                'name_pelanggan' => $this->input->post('nama_pelanggan'),
                'rw_pelanggan' => $this->input->post('rw_pelanggan'),
                'rt_pelanggan' => $this->input->post('rt_pelanggan'),
                'user_id' => $this->input->post('user_id')
            ];

            if ($cek_pelanggan_baru) {
                # code...
                $where = ['id_pelanggan' => $id_pelanggan];
                $query =  $this->M_pelanggan->update_pelanggan($params, $where);
            } else {
                # code...
                $params['id_pelanggan'] = $id_pelanggan;
                $query = $this->M_pelanggan->insert_pelanggan($params);
            }
            //proses insert
            if ($query) {
                if ($cek_pelanggan_baru == false) {
                    # code...
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
                    # code...
                    $this->session->set_flashdata('success', 'Data Berhasil disimpan');
                    redirect('operator/pelanggan');
                }
            } else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda Perlu Mengisi Form Untuk Melanjutkan');
            $this->session->set_flashdata('pesan_eror', validation_errors('<li>', '</li>'));
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['user_detail'] = $this->M_pelanggan->get_detail_pelanggan($user_id);
        $data['user_id'] = $user_id;
        if ($this->db->get_where('pelanggan', ['user_id' => $user_id])->row_array()) {
            $data['status_pelanggan'] = '1';
        } else {
            # code...
            $data['status_pelanggan'] = '0';
        }
        $this->load->view('operator/pelanggan/step_pelanggan', $data);
        $this->load->view('templete/footer');
        // //default page
        // redirect('operator/pelanggan/step_pelanggan/' . $this->input->post('user_id'));
    }

    public function edit_pelanggan($id_pelanggan)
    {
        // cek id pelanggan apakah ada
        if (!$this->M_pelanggan->get__pelanggan_by_id($id_pelanggan)) {
            $this->session->set_flashdata('gagal', 'Data Yang Anda Minta Tidak diemukan');
            redirect('operator/pelanggan');
        }
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
        // cek id pelanggan apakah ada
        if (!$this->M_pelanggan->get__pelanggan_by_id($id_pelanggan)) {
            $this->session->set_flashdata('gagal', 'Data Yang Anda Minta Tidak diemukan');
            redirect('operator/pelanggan');
        }
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
        $id_pelanggan = $this->input->post('id_pelanggan');
        $user_id = $this->M_pelanggan->get_user_detail($id_pelanggan);
        if ($this->form_validation->run() !== FALSE) {
            //where
            $where = ['id_pelanggan' => $id_pelanggan];
            $where_user_id = ['user_id' => $user_id['user_id']];
            //proses insert
            $this->db->delete('transaksi', $where);
            $this->db->delete('pengaduan', ['pengaduan_by' => $user_id['user_id']]);
            if ($this->M_pelanggan->delete_pelanggan_stand_meter($where)) {
                if ($this->M_pelanggan->delete_pelanggan($where)) {
                    if ($this->M_pelanggan->delete_user_pelanggan($where_user_id)) {
                        if ($this->M_pelanggan->delete_user_transaksi($where)) {
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
            } else {
                $this->session->set_flashdata('success', 'Data Gagal dihapus');
            }
        }
        //default page
        redirect('pelanggan/operator/delete_pelanggan/' . $this->input->post('id_pelanggan'));
    }

    // detail pelanggan
    public function detail($id_pelanggan)
    {
        // cek id pelanggan apakah ada
        if (!$this->M_pelanggan->get__pelanggan_by_id($id_pelanggan)) {
            $this->session->set_flashdata('gagal', 'Data Yang Anda Minta Tidak diemukan');
            redirect('operator/pelanggan');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
        $data['riwayat'] = $this->M_pelanggan->riwayat_tagihan_pelanggan($id_pelanggan);
        $data['data_chart'] = $this->M_pelanggan->labelChart($id_pelanggan);
        $this->load->view('operator/pelanggan/detail_pelanggan', $data);
        $this->load->view('templete/footer');
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

    // generete qrcode
    public function kodeqrpelanggan($id_pelanggan)
    {
        $kode_qr = './resource/adminlte31/img/qrcodePelanggan/qrcode-' . $id_pelanggan . '.png';
        if (file_exists($kode_qr)) {
            $this->load->view('templete/header');
            $this->load->view('templete/navbar');
            $data['user_data'] = $this->session->userdata('user');
            $this->load->view('templete/side_bar', $data);
            $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
            $this->load->view('operator/pelanggan/kartu_pelanggan', $data);
            $this->load->view('templete/footer');
        } else {
            // load library
            $this->load->library('ciqrcode');
            // Peth untuk menyimpan qrcode
            $path = './resource/adminlte31/img/qrcodePelanggan/';
            $params['data'] =  $id_pelanggan;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = $path . 'qrcode-' . $id_pelanggan . '.png';
            $this->ciqrcode->generate($params);
            $this->load->view('templete/header');
            $this->load->view('templete/navbar');
            $data['user_data'] = $this->session->userdata('user');
            $this->load->view('templete/side_bar', $data);
            $data['pelanggan'] = $this->M_pelanggan->get__pelanggan_by_id($id_pelanggan);
            $this->load->view('operator/pelanggan/kartu_pelanggan', $data);
            $this->load->view('templete/footer');
        }
        // die;
    }
}
