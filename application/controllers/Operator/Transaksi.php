<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('operator/M_transaksi');
        $this->load->model('operator/M_pelanggan');
        $this->load->library('form_validation');
    }



    public function add_tagihan()
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $this->load->view('operator/tagihan/add');
        $this->load->view('templete/footer');
    }

    public function procces_add_tagihan()
    {
        $this->form_validation->set_rules('id_tagihan', 'Kode Tagihan', 'required|trim');
        $this->form_validation->set_rules('nama_tagihan', 'Nama Tagihan', 'required|trim');
        $this->form_validation->set_rules('jumlah_tagihan', 'Jumlah Tagihan', 'required');
        //validasi data
        if ($this->form_validation->run() !== FALSE) {
            $params = [
                'id_tagihan' => $this->input->post('id_tagihan'),
                'name_tagihan' => $this->input->post('nama_tagihan'),
                'jumlah_tagihan' => $this->input->post('jumlah_tagihan')
            ];
            //proses insert
            if ($this->M_transaksi->insert_tagihan($params)) {
                $this->session->set_flashdata('success_tagihan', 'Data Berhasil disimpan');
                redirect('operator/transaksi');
            } else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        }
        //default page
        redirect('pelanggan/transaksi/add_tagihan');
    }

    public function edit_tagihan($id_tagihan)
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data["tagihan"] = $this->M_transaksi->get_tagihan_by_id($id_tagihan);
        $this->load->view('operator/tagihan/edit', $data);
        $this->load->view('templete/footer');
    }

    public function procces_edit_tagihan()
    {
        $this->form_validation->set_rules('id_tagihan', 'Kode Tagihan', 'required|trim');
        $this->form_validation->set_rules('nama_tagihan', 'Nama Tagihan', 'required|trim');
        $this->form_validation->set_rules('jumlah_tagihan', 'Jumlah Tagihan', 'required');
        //validasi data
        if ($this->form_validation->run() !== FALSE) {
            $params = [
                'name_tagihan' => $this->input->post('nama_tagihan'),
                'jumlah_tagihan' => $this->input->post('jumlah_tagihan')
            ];
            $where = ['id_tagihan' => $this->input->post('id_tagihan')];
            //proses insert
            if ($this->M_transaksi->update_tagihan($params, $where)) {
                $this->session->set_flashdata('success_tagihan', 'Data Berhasil disimpan');
                redirect('operator/transaksi');
            } else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        }
        //default page
        redirect('pelanggan/transaksi/add_tagihan');
    }

    // delete tagihan
    public function delete_tagihan($id_tagihan)
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $this->load->view('templete/side_bar');
        $data["tagihan"] = $this->M_transaksi->get_tagihan_by_id($id_tagihan);
        $this->load->view('operator/tagihan/delete', $data);
        $this->load->view('templete/footer');
    }

    //proccesd delete
    public function procces_delete_tagihan()
    {
        $this->form_validation->set_rules('id_tagihan', 'Kode Tagihan', 'required|trim');
        //validasi data
        if ($this->form_validation->run() !== FALSE) {
            $where = ['id_tagihan' => $this->input->post('id_tagihan')];
            //proses insert
            if ($this->M_transaksi->delete_tagihan($where)) {
                $this->session->set_flashdata('success_tagihan', 'Data Berhasil dihapus');
                redirect('operator/transaksi');
            } else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        }
        //default page
        redirect('pelanggan/transaksi/add_tagihan');
    }

    //start transaksi
    public function index()
    {
        if ($this->session->userdata('user') == null) {
            redirect('login');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['tagihan'] = $this->M_transaksi->get_all_tagihan();
        $data['transaksi'] = $this->M_transaksi->get_all_transaksi();
        $data['total_pendapatan'] = $this->M_transaksi->get_total_pendapatan();
        $data['total_meteran'] = $this->M_transaksi->get_total_meteran();

        $this->load->view('operator/transaksi/index', $data);
        $this->load->view('templete/footer');
    }

    public function add_transaksi()
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data['pelanggan'] = $this->M_pelanggan->get_all_pelanggan();
        $data['harga_permeter'] = $this->M_transaksi->get_harga_permeter();
        $data['harga_abunemen'] = $this->M_transaksi->get_harga_abunemen();
        $this->load->view('operator/transaksi/add', $data);
        $this->load->view('templete/footer');
    }

    public function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }

    // public function totsl_semua($end_meter){
    //     $id_pelanggan = $this->input->post('nama_pelanggan', TRUE);

    // }
    //get start meter pelanggan

    public function get_total_meteran($end_metter)
    {
        $id_pelanggan = $this->input->post('nama_pelanggan', TRUE);
        $start_meter = $this->M_transaksi->get_start_meter($id_pelanggan);
        $total_meter = $end_metter - $start_meter['end_meter'];
        return $total_meter;
    }

    public function biaya_pemakaian($total_meter)
    {
        $harga_permeter = $this->M_transaksi->get_harga_permeter();
        $bayar_total_meter = $total_meter * $harga_permeter['jumlah_tagihan'];
        return $bayar_total_meter;
    }

    public function total_bayar($biaya_pemakaian)
    {
        $beban_abunemen = $this->M_transaksi->get_harga_abunemen();
        $total_bayar = $biaya_pemakaian + $beban_abunemen['jumlah_tagihan'];
        return $total_bayar;
    }



    public function  procces_add_transaksi()
    {
        // var_dump($this->M_transaksi->selesksi_pelanggan()['id_pelanggan']);
        // die;
        //  var_dump($this->get_total_meteran($this->input->post('end_meteran', TRUE)),  number_format($this->biaya_pemakaian(),2,',','.'), number_format($this->total_bayar(),2,',','.'));
        //  die;
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('end_meteran', 'Meteran Sekarang', 'required');
        $sudah_transaksi = $this->M_transaksi->selesksi_pelanggan();
        $selesksi = "";
        foreach ($sudah_transaksi as $data) {
            $data_selesksi = $data['id_pelanggan'];
            $selesksi .= $data_selesksi . " ";
        }
        $arr_seleksi = explode(" ", $selesksi);
        // die;var_dump($arr_seleksi);


        $id_pelanggan = $this->input->post('nama_pelanggan', TRUE);
        $start_meter = $this->M_transaksi->get_start_meter($id_pelanggan);
        $end_meteran = $this->input->post('end_meteran', TRUE);
        $jumlah_meteran = $this->get_total_meteran($end_meteran);
        $biaya_pemakaian = $this->biaya_pemakaian($jumlah_meteran);
        $total_bayar1 = $this->total_bayar($biaya_pemakaian);


        if ($this->form_validation->run()) {
            if (in_array($id_pelanggan, $arr_seleksi)) {
                $this->session->set_flashdata('success_transaksi', 'Tagihan pelanggan Pada Bulan Ini Telah Dibuat');
                redirect('operator/transaksi/add_transaksi');
            }
            $params = [
                "id_transaksi" => $this->M_transaksi->get_transaksi_last_id(),
                "id_pelanggan" => $this->input->post('nama_pelanggan', TRUE),
                "start_meter" => $start_meter['end_meter'],
                "end_meter" => $this->input->post('end_meteran'),
                "jumlah_meteran" => $jumlah_meteran,
                "total_bayar" => $total_bayar1,
                "biaya_pemakaian" => $biaya_pemakaian,
                "tanggal_transaksi" =>  date("Y-m-d")
            ];
            if ($this->M_transaksi->insert_transaksi($params)) {
                $params = [
                    "start_meter" => $start_meter['end_meter'],
                    "end_meter" => $this->input->post('end_meteran')
                ];
                $where = ["id_pelanggan" => $this->input->post('nama_pelanggan', TRUE)];

                if ($this->M_transaksi->update_stand_meter($params, $where)) {
                    $this->session->set_flashdata('success_transaksi', 'Data Berhasil di simpan');
                    redirect('operator/transaksi');
                } else {
                    $this->session->set_flashdata('success_transaksi', 'Data Gagal dihapusn U');
                }
            } else {
                $this->session->set_flashdata('success_transaksi', 'Data Gagal dihapus I');
            }
        } else {
            $this->session->set_flashdata('success_transaksi', 'Semua Form Harus diisi');
        }
        redirect('operator/transaksi/add_transaksi');
    }



    public function print($id_transaksi)
    {
        $this->load->view('templete/header');
        $data['biaya_meter'] = $this->M_transaksi->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_transaksi->get_harga_abunemen();
        $data['transaksi'] = $this->M_transaksi->get_data_print($id_transaksi);
        $this->load->view('operator/transaksi/print', $data);
    }

    public function cetak_laporan_bulanan()
    {
        $this->load->view('templete/header');
        $data['transaksi'] = $this->M_transaksi->get_all_transaksi();
        $data['total_pendapatan'] = $this->M_transaksi->get_total_pendapatan();
        $data['total_meteran'] = $this->M_transaksi->get_total_meteran();
        $this->load->view('operator/laporan/laporan_bulanan', $data);
    }

    public function delete_transaksi($id_transaksi)
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $this->session->userdata('user');
        $this->load->view('templete/side_bar', $data);
        $data["transaksi"] = $this->M_transaksi->get_transaksi_by_id($id_transaksi);
        $this->load->view('operator/transaksi/delete', $data);
        $this->load->view('templete/footer');
    }

    public function procces_delete_transaksi()
    {
        $this->form_validation->set_rules('id_transaksi', 'ID Pelanggan', 'required');
        $id_pelanggan = $this->input->post('id_pelanggan', TRUE);
        if ($this->form_validation->run() !== FALSE) {

            $where = ["id_transaksi" => $this->input->post('id_transaksi', TRUE)];
            //  var_dump($id_pelanggan);
            //  die;
            $stand_meter = $this->M_transaksi->get_last_transaksi_pelanggan($id_pelanggan);

            if ($this->M_transaksi->delete_transaksi($where)) {

                if ($stand_meter == null) {
                    $params = [
                        "start_meter" => 0,
                        "end_meter" => 0
                    ];
                } else {

                    $params = [
                        "start_meter" => $stand_meter['start_meter'],
                        "end_meter" => $stand_meter['end_meter']
                    ];
                }

                $where1 = ["id_pelanggan" => $id_pelanggan];
                if ($this->M_transaksi->update_stand_meter($params, $where1)) {
                    $this->session->set_flashdata('success_transaksi', 'Data Berhasil di simpan');
                    redirect('operator/transaksi');
                } else {
                    $this->session->set_flashdata('success_transaksi', 'Data Stand meter gagal diupdate');
                }
            } else {
                $this->session->set_flashdata('success_transaksi', 'Data Stand meter gagal diupdate');
            }
        } else {
            $this->session->set_flashdata('success_transaksi', 'Data Id pelanggan kosong');
        }

        redirect('operator/transaksi');
    }
}
