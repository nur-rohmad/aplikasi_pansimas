<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('operator/M_profil');
        $this->load->library('form_validation');
        $this->load->library('email');
        // cek apakah user sudah login
        if ($this->session->userdata('user') == NULL) {
            # code...
            redirect('login');
        }
    }

    public function index()
    {
        if ($this->session->userdata('user') == null) {
            redirect('login');
        }
        $this->load->view('templete/header');
        $this->load->view('templete/navbar');
        $data_user = $this->session->userdata('user');
        $user = $this->db->get_where('user_table', ['user_id' => $data_user['user_id']])->row_array();
        $data['user_data'] = $data_user;
        $data['user_detail'] = $user;
        // var_dump($data_user['user_role']);
        if ($data_user['user_role'] < 3) {
            $this->load->view('templete/side_bar', $data);
        } else {
            # code...
            $this->load->view('pelanggan/side_bar', $data);
        }
        $this->load->view('profil', $data);
        $this->load->view('templete/footer');
    }

    public function procces_update_profile()
    {
        $this->user_id = $this->input->post('user_id');
        $params =
            [
                "user_alias" => $this->input->post('nama_lengkap'),
                "user_name" => $this->input->post('user_name'),
                "no_telp" => $this->input->post('no_telp'),
                "email" => $this->input->post('email')
            ];

        if (empty($this->input->post('pass'))) {
        } else {
            $pass = $this->input->post('pass');
            $password_hash = password_hash($pass, PASSWORD_DEFAULT);
            $params['user_pass'] = $password_hash;
            $this->_sendEmail($this->input->post('user_name'));
        }

        if (isset($_FILES['foto_profil'])) {
            $config['upload_path']          = './resource/adminlte31/img/profile';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = $this->user_id;
            $config['overwrite']            = true;
            // $config['max_size']             = 1024; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('foto_profil')) {
                $params['user_photo'] = $this->upload->data("file_name");
            } else {
                # code...
                // print_r($this->upload->display_errors());
                // $params['user_photo'] = "avatar.png";
            }
        }

        // if (isset($user_pass) && isset($_FILES['foto_profil'])) {
        //     $pass = $this->input->post('pass');
        //     $password_hash = password_hash($pass, PASSWORD_DEFAULT);
        //     $params['user_pass'] = $password_hash;
        //     $params['user_photo'] = $this->_uploadImage();
        // }
        // var_dump($params);
        // die;
        if ($this->db->update('user_table', $params, ['user_id' => $this->user_id])) {
            $this->session->unset_userdata('user');
            $user =  $this->get_detail_user(['user_id' => $this->user_id]);
            $data_sesion = [
                'user_id' => $user['user_id'],
                'user_name' => $user['user_name'],
                'user_photo' => $user['user_photo'],
                'nama_lengkap' => $user['user_alias'],
                'user_role' => $user['role_id'],
                'user_role_name' => $user['name_role']
            ];
            $this->session->set_userdata('user', $data_sesion);
            $this->session->set_flashdata('success_profil', 'Profile  Berhasil Di Update');
        } else {
            $this->session->set_flashdata('gagal_profil', ' Profile Gagal  Berhasil');
        }
        redirect('profil');
    }

    public function get_detail_user($params)
    {
        $sql = "SELECT a.* , b.role_id, c.* FROM user_table a JOIN user_role_table b ON a.user_id = b.user_id join role_table c on b.role_id=c.role_id  WHERE a.user_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    private function _sendEmail($user_name)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'qiliasalmu@gmail.com',
            'smtp_pass' => 'prqzwckjvffuhkzm',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('qiliasalmu@gmail.com', 'Pamsimas');
        $this->email->to($this->input->post('email', true));
        $this->email->subject('Ubah Password');
        $this->email->message('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width" name="viewport"/>
<!--[if !mso]><!-->
<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<!--<![endif]-->
</head >
<body>
<table
      border="0"
      style="width: 400px; margin: 0 auto; box-shadow: 5px 10px 10px #888888"
      cellpadding="10"
    >
      <tr style="background-color: white">
        <td width="45%" align="center">
          <img
            src="' . base_url('resource/adminlte31/img/pansimas.jpeg') . '"
            alt="logo"
            style="width: 50%; background-color: white"
          />
        </td>
        <td
          align="center"
          style="
            font-weight: bold;
            font-size: 20px;
            color: black;
            font-family: sans-serif;
          "
        >
           Aplikasi Pamsismas Desa Bintoyo
        </td>
      </tr>
      <tr>
        <td colspan="2"><hr style="border-top: 2px solid black" /></td>
      </tr>
      <tr>
        <td colspan="2">
          <p
            style="
              text-indent: 20px;
              text-align: justify;
              font-size: 20px;
              line-height: 40px;
            "
          >
            <span style="font-size: 30px">T</span>elah  Berhasil dilakukan
            pengubahan password untuk username
            <span style="font-weight: bold">' . $user_name . '</span> pada
            <span style="font-weight: bold">' . format_indo_full(date('Y-m-d')) . '</span>
          </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center"> semoga harimu menyenangkan </td>
      </tr>
    </table>
    </body>
</html>');

        if ($this->email->send()) {
            # code...
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
}
