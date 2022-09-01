<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require_once('./application/third_party/dompdf-master/autoload.inc.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

//dom pdf 
use Dompdf\Dompdf;
use FontLib\Table\Type\post;

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('operator/M_transaksi');
        $this->load->model('operator/M_pelanggan');
        $this->load->library('form_validation');
        cek_login();
        //mengontrol hak akses user
        check_admin();
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
                $this->session->set_flashdata('success_tagihan', 'Data Tagihan Berhasil disimpan');
                redirect('operator/transaksi');
            } else {
                $this->session->set_flashdata('gagal', 'Data Gagal disimpan');
            }
        }
        //default page
        redirect('operator/transaksi/add_tagihan');
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
        redirect('operat[or/transaksi/edit_tagihan/' . $this->input->post('id_tagihan'));
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

    // function bulan indo
    public function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return  $bulan[(int)$split[1]] . ' ' . $split[0];
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
        $data['total_transaksi'] = $this->M_transaksi->get_total_data();
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
        $data['pelanggan'] = $this->M_transaksi->get_pelanggan_transaksi();
        $this->load->view('operator/transaksi/add', $data);
        $this->load->view('templete/footer');
    }



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
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('end_meteran', 'Meteran Sekarang', 'required');
        if ($this->form_validation->run() !== FALSE) {
            $id_pelanggan = $this->input->post('nama_pelanggan', TRUE);
            $start_meter = $this->M_transaksi->get_start_meter($id_pelanggan);
            $end_meteran = $this->input->post('end_meteran', TRUE);
            $jumlah_meteran = $this->get_total_meteran($end_meteran);
            if ($jumlah_meteran < 0) {
                $this->session->set_flashdata('gagal_transaksi', 'Gagal Nilai Transaksi minus');
                redirect('operator/transaksi/add_transaksi');
            }
            $biaya_pemakaian = $this->biaya_pemakaian($jumlah_meteran);
            $total_bayar1 = $this->total_bayar($biaya_pemakaian);

            $params = [
                "id_transaksi" => $this->M_transaksi->get_transaksi_last_id(),
                "id_pelanggan" => $this->input->post('nama_pelanggan', TRUE),
                "start_meter" => $start_meter['end_meter'],
                "end_meter" => $this->input->post('end_meteran'),
                "status_pembayaran" => "belum_bayar",
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
                    $this->session->set_flashdata('success_transaksi', 'Data Transaksi Berhasil di simpan');
                    redirect('operator/transaksi');
                } else {
                    $this->session->set_flashdata('gagal_transaksi', 'Data Gagal dihapusn U');
                }
            } else {
                $this->session->set_flashdata('gagal_transaksi', 'Data Gagal dihapus I');
            }
        } else {
            $this->session->set_flashdata('gagal_transaksi', 'Data Gagal Disimpan');
            $this->session->set_flashdata('pesan_eror', validation_errors('<li>', '</li>'));
            $this->load->view('templete/header');
            $this->load->view('templete/navbar');
            $data['user_data'] = $this->session->userdata('user');
            $this->load->view('templete/side_bar', $data);
            $data['pelanggan'] = $this->M_transaksi->get_pelanggan_transaksi();
            $this->load->view('operator/transaksi/add', $data);
            $this->load->view('templete/footer');
        }
        // redirect('operator/transaksi/add_transaksi');
    }



    public function print($id_transaksi)
    {
        $this->load->view('templete/header');
        $data['biaya_meter'] = $this->M_transaksi->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_transaksi->get_harga_abunemen();
        $data['transaksi'] = $this->M_transaksi->get_data_print($id_transaksi);
        $this->load->view('operator/transaksi/print', $data);
    }

    // donwload nota
    public function cetak_nota($id_transaksi)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $data['biaya_meter'] = $this->M_transaksi->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_transaksi->get_harga_abunemen();
        $data['transaksi'] = $this->M_transaksi->get_data_print($id_transaksi);
        $transaksi = $this->M_transaksi->get_data_print($id_transaksi);
        $view = $this->load->view('operator/transaksi/nota', $data, true);
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper(array('0', '0', '390', '450'), 'potrat');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("Tagihan Bulan" . format_indo($transaksi['tanggal_transaksi']) . " .pdf", array("Attachment" => false));
    }

    // cetak semua nota
    public function cetak_semua_nota()
    {
        $halaman_awal = $this->input->post('page_awal');
        $halaman_akhir = $this->input->post('page_akhir');
        // cek page awal dan page alhir
        if ((int)$halaman_awal > (int)$halaman_akhir) {
            $this->session->set_flashdata('gagal_delete_transaksi', 'Halaman Akhir Harus Lebih Besar Dari Halaman Awal');
            redirect('operator/transaksi');
        }
        $jumlah_halaman = (int)$halaman_akhir - ((int)$halaman_awal - 1);
        // var_dump($halaman_awal, $jumlah_halaman);
        // die;
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $data['biaya_meter'] = $this->M_transaksi->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_transaksi->get_harga_abunemen();
        $data['transaksi'] = $this->M_transaksi->get_all_print(array((int)$halaman_awal - 1, $jumlah_halaman));
        //  $transaksi = $this->M_transaksi->get_data_print($id_transaksi);
        $view = $this->load->view('operator/transaksi/nota_full', $data, true);
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper(array('0', '0', '390', '450'), 'potrat');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("Tagihan Bulan" . format_indo(date('Y-m-d')) . " .pdf", array("Attachment" => false));
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
            $stand_meter = $this->M_transaksi->get_total_transaksi_pelanggan($id_pelanggan);

            if ((int)$stand_meter <= 1) {
                $stand_meter_pelanggan = $this->M_transaksi->get_last_transaksi_pelanggan($id_pelanggan);
                $params = [
                    "start_meter" => 0,
                    "end_meter" =>  (int)$stand_meter_pelanggan['end_meter'] - (int)$stand_meter_pelanggan['jumlah_meteran']
                ];
            } else {
                $stand_meter_pelanggan = $this->M_transaksi->get_last_transaksi_pelanggans($id_pelanggan);
                $params = [
                    "start_meter" => $stand_meter_pelanggan['start_meter'],
                    "end_meter" => $stand_meter_pelanggan['end_meter']
                ];
            }

            if ($this->M_transaksi->delete_transaksi($where)) {
                $where = ["id_pelanggan" => $id_pelanggan];
                if ($this->M_transaksi->update_stand_meter($params, $where)) {
                    $this->session->set_flashdata('success_delete_transaksi', 'Data Transaksi Berhasil di Hapus');
                    redirect('operator/transaksi');
                } else {
                    $this->session->set_flashdata('gagal_delete_transaksi', 'Data Stand meter gagal diupdate');
                }
            } else {
                $this->session->set_flashdata('gagal_delete_transaksi', 'Data Stand meter gagal diupdate');
            }
        } else {
            $this->session->set_flashdata('gagal_delete_transaksi', 'Data Id pelanggan kosong');
        }

        redirect('operator/transaksi/delete_transaksi/' . $this->input->post('id_transaksi', TRUE));
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
        $bulan = format_indo(date('Y-m-d'));

        //Set Default Teks
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);
        //Style Judul table
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "Data Transaksi KP-SPAM Bintoyo Bulan " . $bulan);

        $spreadsheet->getActiveSheet()
            ->mergeCells("A1:H1");

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
            ->setWidth(10);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(30);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(45);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('E')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('G')
            ->setWidth(20);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('H')
            ->setWidth(20);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Id Pelanggan');
        $sheet->setCellValue('C2', 'Nama');
        $sheet->setCellValue('D2', 'Bulan tagihan');
        $sheet->setCellValue('E2', 'Start meter');
        $sheet->setCellValue('F2', 'End meter');
        $sheet->setCellValue('G2', 'Jumlah Meteran');
        $sheet->setCellValue('H2', 'Total Tagihan');


        // STYLE judul table
        $spreadsheet->getActiveSheet()
            ->getStyle('A2:H2')
            ->applyFromArray($styleJudul);

        $pelanggan = $this->M_transaksi->get_all_transaksi();
        $no = 1;
        $x = 3;
        foreach ($pelanggan as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row['id_pelanggan']);
            $sheet->setCellValue('C' . $x, $row['name_pelanggan']);
            $sheet->setCellValue('D' . $x, format_indo($row['tanggal_transaksi']));
            $sheet->setCellValue('E' . $x, $row['start_meter']);
            $sheet->setCellValue('F' . $x, $row['end_meter']);
            $sheet->setCellValue('G' . $x, $row['jumlah_meteran']);
            $sheet->setCellValue('H' . $x, $row['total_bayar']);
            $x++;
        }
        //sum 
        $last_x = $x - 1;
        $total = 'G3:G' . $last_x;
        $total_bayar = 'H3:H' . $last_x;
        $sheet->setCellValue('A' . $x, "TOTAL");
        $spreadsheet->getActiveSheet()->getStyle('A' . $x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A' . $x . ':F' . $x);

        $sheet->setCellValue('G' . $x, '=SUM(' . $total . ')');
        $sheet->setCellValue('H' . $x, '=SUM(' . $total_bayar . ')');

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_transaksi_KP-SPAM_Bintoyo_bulan_' . $bulan;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //     cetak pdf
    public function cetak_pdf()
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $data['biaya_meter'] = $this->M_transaksi->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_transaksi->get_harga_abunemen();
        $data['transaksi'] = $this->M_transaksi->get_data_print("T000000001");
        $view = $this->load->view('operator/transaksi/print', $data, true);
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper(array('0', '0', '340.157', '396.85'), 'potrat');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("hasil1.pdf", array("Attachment" => 0));
    }

    // get meteran terakir
    public function getMeteranPelanggan()
    {
        $id = $this->input->post('id_pelanggan');
        $data = ["data" => $this->db->query("SELECT * FROM pelanggan a join stand_meter_pelanggan b On a.id_pelanggan=b.id_pelanggan WHERE a.id_pelanggan = '$id'")->row_array()];
        echo json_encode($data);
    }
}
