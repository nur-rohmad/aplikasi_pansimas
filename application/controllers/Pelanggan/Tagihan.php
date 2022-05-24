<?php
defined('BASEPATH') or exit('No direct script access allowed');

//dom pdf 
use Dompdf\Dompdf;
use Dompdf\Options;
use FontLib\Table\Type\post;

class Tagihan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // midtrans
        header("Access-Control-Allow-Origin:*");
        $params = array('server_key' => 'SB-Mid-server-0Rl2wLFxo_6DYeZ3f9vlTAOT', 'production' => false);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
        $this->load->helper('url');
        // cek login
        cek_login();
        //mengontrol hak akses user
        $url = $this->uri->segment(1);
        if ($url == 'pelanggan') {
            # code...
            $role_user = 3;
        } else {
            # code...
            $role_user = 1;
        }
        $data_user = $this->session->userdata('user');
        // var_dump($role_user, $data_user['user_role']);
        if ($data_user['user_role']  != $role_user) {
            # code...
            print_r('akses_ditolak');
            exit;
        }
        //load model
        $this->load->model('pelanggan/M_tagihan');
    }

    public function index()
    {
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $data['user_data'] = $data_user;
        $data['transaksi'] = $this->M_tagihan->get_transakssi_by_user_id($data_user['user_id']);

        $this->load->view('pelanggan/side_bar', $data);
        $this->load->view('pelanggan/tagihan/index.php', $data);
        $this->load->view('templete/footer');
    }

    // bayar
    public function bayar_tagihan($transaksi_id)
    {
        // get sesion
        $data_user = $this->session->userdata('user');
        // cek tagihan per user
        $cek_tagihan = $this->M_tagihan->cek_transasksi([
            'id_transaksi' => $transaksi_id,
            'user_id' => $data_user['user_id'],
        ]);
        if ($cek_tagihan == null) {
            redirect('pelanggan/tagihan');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data['user_data'] = $data_user;
        $data['transaksi'] = $this->M_tagihan->get_transakssi_by_id($transaksi_id);
        $this->load->view('pelanggan/side_bar', $data);
        $this->load->view('pelanggan/tagihan/bayar.php', $data);
        $this->load->view('templete/footer');
    }

    //download nota
    public function download_nota($id_transaksi)
    {
        $this->load->view('templete/header');
        $data['biaya_meter'] = $this->M_tagihan->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_tagihan->get_harga_abunemen();
        $data['transaksi'] = $this->M_tagihan->get_data_print($id_transaksi);
        $this->load->view('operator/transaksi/print', $data);
    }

    //download pdf
    public function download_pdf($id_transaksi)
    {
        // get sesion
        $data_user = $this->session->userdata('user');
        // cek tagihan per user
        $cek_tagihan = $this->M_tagihan->cek_transasksi([
            'id_transaksi' => $id_transaksi,
            'user_id' => $data_user['user_id'],
        ]);
        if ($cek_tagihan == null) {
            redirect('pelanggan/tagihan');
        }
        // instantiate and use the dompdf class

        $dompdf = new Dompdf();
        $data['biaya_meter'] = $this->M_tagihan->get_harga_permeter();
        $data['biaya_abunemen'] = $this->M_tagihan->get_harga_abunemen();
        $data['transaksi'] = $this->M_tagihan->get_data_print($id_transaksi);
        $transaksi = $this->M_tagihan->get_data_print($id_transaksi);
        $view = $this->load->view('pelanggan/tagihan/nota', $data, true);
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper(array('0', '0', '390', '450'), 'potrat');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("Tagihan Bulan" . format_indo($transaksi['tanggal_transaksi']) . " .pdf", array("Attachment" => false));
    }

    public function token()
    {
        $id_transaksi = $this->input->post('id');
        $bulan_tagihan = $this->input->post('bulan_tagihan');
        $total_bayar = $this->input->post('total_bayar');
        $t_bayar = (int)$total_bayar;
        // data pelanggan
        $pelanggan = $this->M_tagihan->get_transakssi_by_id($id_transaksi);
        // var_dump($id_transaksi);
        // die;
        // Required
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => $t_bayar, // no decimal allowed for creditcard
        );

        // Optional
        $item1_details = array(

            // 'id' => 'a2',
            'price' => $t_bayar,
            'quantity' => 1,
            'name' => 'Pembayaran Tagihan ' . $bulan_tagihan
        );

        // // Optional
        // $item2_details = array(
        //     'id' => 'a2',
        //     'price' => 20000,
        //     'quantity' => 2,
        //     'name' => "Orange"
        // );

        // Optional
        $item_details = array($item1_details);

        // Optional
        $billing_address = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Bintoyo, " . "Rt.0" . $pelanggan['rt_pelanggan'] . " " . "Rw. 0" . $pelanggan['rw_pelanggan'],
            // 'city'          => "Jakarta",
            // 'postal_code'   => "16601",
            // 'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );

        // Optional
        $customer_details = array(
            'first_name'    => $pelanggan['name_pelanggan'],
            // 'last_name'     => "Litani",
            'email'         => $pelanggan['email'],
            'phone'         => $pelanggan['no_telp'],
            // 'billing_address'  => $billing_address,
            // 'shipping_address' => $shipping_address
        );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = false;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O", $time),
            'unit' => 'minute',
            'duration'  => 1440
        );

        $enable_payments = array('bank_transfer');
        $transaction_data = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            // 'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);
        error_log($snapToken);
        echo $snapToken;
    }

    public function finish()
    {
        $id_transaksi = $this->input->post('id_tagihan');
        $result = json_decode($this->input->post('result_data'), true);
        // var_dump($result);
        // die;
        if (array_key_exists('permata_va_number', $result)) {
            $va_numbers = "permata";
        } elseif (array_key_exists('va_numbers', $result)) {
            $va_numbers = $result['va_numbers'][0];
        } elseif (array_key_exists('bill_key', $result)) {
            $va_numbers = "mandiri";
        }

        // var_dump($va_numbers);
        // die;

        // get informasi user
        $data_user = $this->session->userdata('user');
        // time transaksi
        $waktu_transaksi = strtotime($result['transaction_time']);
        // waktu expeire diaman waktu transaksi ditambahkan 24 jam
        $waktu_expire = date('Y-m-d H:i:s', strtotime("+ 1440 minute", $waktu_transaksi));

        // cek merode pembayaran 
        if ($va_numbers == "mandiri") {
            # code...
            $bank = 'mandiri';
            $va_mandiri = [
                'bill_key' => $result['bill_key'],
                'biller_code' => $result['biller_code']
            ];
            $va_private = json_encode($va_mandiri);
        } else {
            # code...
            if ($va_numbers == "permata") {
                $bank = 'permata';
                $va_private = $result['permata_va_number'];
            }
        }
        // var_dump($va_numbers);
        // die;
        $cek_id_tansaksi = $this->M_tagihan->get_id_transaksi();
        $selesksi = "";
        foreach ($cek_id_tansaksi as $data) {
            $data_selesksi = $data['id_transaksi'];
            $selesksi .= $data_selesksi . " ";
        }
        $arr_id_ransaksi = explode(" ", $selesksi);



        if (in_array($id_transaksi, $arr_id_ransaksi)) {
            # code...
            $params_pembayaran = [
                'id_order' => $result['order_id'],
                'metode_pembayaran' => $result['payment_type'],
                'waktu_bayar' => $result['transaction_time'],
                'waktu_exspire' => $waktu_expire,
                'link_petunjuk_pembayaran' => $result['pdf_url'],
                'pembayaran_by' => $data_user['user_name'],
            ];
            if ($va_numbers == "permata" || $va_numbers == "mandiri") {
                # code...
                $params_pembayaran['bank'] = $bank;
                $params_pembayaran['va_number'] = $va_private;
            } else {

                $params_pembayaran['bank'] =  $va_numbers['bank'];
                $params_pembayaran['va_number'] = $va_numbers['va_number'];
            }
            $where = ['id_transaksi' => $id_transaksi];
            $url_simpan =  $this->M_tagihan->update_pebayaran($params_pembayaran, $where);
        } else {
            # code...
            $params_pembayaran = [
                'id_transaksi' => $id_transaksi,
                'id_order' => $result['order_id'],
                'metode_pembayaran' => $result['payment_type'],
                'waktu_bayar' => $result['transaction_time'],
                'waktu_exspire' => $waktu_expire,
                'link_petunjuk_pembayaran' => $result['pdf_url'],
                'pembayaran_by' => $data_user['user_name'],
            ];
            if ($va_numbers == null) {
                # code...
                $params_pembayaran['bank'] = $bank;
                $params_pembayaran['va_number'] = $va_private;
            } else {


                $params_pembayaran['bank'] =  $va_numbers['bank'];
                $params_pembayaran['va_number'] = $va_numbers['va_number'];
            }
            $url_simpan = $this->M_tagihan->insert_pebayaran($params_pembayaran);
        }
        if ($url_simpan) {
            # code...
            $params = ['status_pembayaran' => 'waiting'];
            $where = ['id_transaksi' => $id_transaksi];
            if ($this->M_tagihan->update_status_pembayaran($params, $where)) {
                # code...

                $this->session->set_flashdata('success', 'Pembayaran Berhasil, Silahkan segerea Transfer');
                redirect('pelanggan/tagihan');
            }
        } else {
            # code...
            $this->session->set_flashdata('success', 'Pembayaran Gagal');
            redirect('pelanggan/tagihan/bayar_tagihan' . $id_transaksi);
        }

        echo 'RESULT <br><pre>';
        var_dump($result);

        echo '</pre>';
    }

    // get data tagihan
    public function get_detail_tagihan()
    {
        // header('Content-type: application/json');
        $id = $this->input->get('id_tagihan', TRUE);
        $kategori = $this->M_tagihan->get_transakssi_complete_by_id($id);
        // var_dump($kategori);
        // die;
        if ($kategori['bank'] == 'mandiri') {
            # code...
            $kategori_1 = [
                'waktu' => format_indo_full($kategori['waktu_exspire']),
                'data' => $kategori,
                'va_numbers' =>  json_decode($kategori['va_number'], true)
            ];
        } else {
            # code...
            $kategori_1 = [
                'waktu' => format_indo_full($kategori['waktu_exspire']),
                'data' => $kategori
            ];
        }
        echo json_encode($kategori_1);
    }
}
