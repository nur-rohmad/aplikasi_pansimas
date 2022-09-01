<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('email');
    }


    public function index()
    {

        // $this->load->view('coba_email');
        $this->load->view('login/header');
        $this->load->view('login/form_login');
    }



    public function proccess_login()
    {
        $this->form_validation->set_rules('user_name', 'Nama ', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        if ($this->form_validation->run() !== FALSE) {
            $user_name = $this->input->post('user_name');
            $pass = $this->input->post('pass');
            $user = $this->get_detail_user($user_name);
            if ($user) {
                if (password_verify($pass, $user['user_pass'])) {
                    $data = [
                        'user_id' => $user['user_id'],
                        'user_name' => $user['user_name'],
                        'user_photo' => $user['user_photo'],
                        'nama_lengkap' => $user['user_alias'],
                        'user_role' => $user['role_id'],
                        'user_role_name' => $user['name_role']
                    ];
                    $this->session->set_userdata('user', $data);
                    if ($data['user_role']  == 1) {
                        # code...
                        $this->session->set_flashdata('sukses_login', 'Anda Berhasil Login');
                        redirect('operator/dashboard');
                    } elseif ($data['user_role']  == 2) {
                        # code...
                    } else {
                        # code...
                        redirect('pelanggan/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Password Salah');
                }
            } else {
                $this->session->set_flashdata('gagal', 'User Tidak Ditemukan');
            }
        } else {
            $this->session->set_flashdata('gagal', 'User Name Dan Password Tidak Boleh Kosong');
        }
        redirect('login');
    }


    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->set_flashdata('sukses_logout', 'Anda Berhasil Logout !!');
        redirect('login');
    }

    public function get_detail_user($params)
    {
        $sql = "SELECT a.* , b.role_id, c.* FROM user_table a JOIN user_role_table b ON a.user_id = b.user_id join role_table c on b.role_id=c.role_id  WHERE a.user_name = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // forgot pasword
    public function forgotpassword()
    {

        $this->form_validation->set_rules('emil_forgotpassword', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/header');
            $this->load->view('login/forgot_password');
        } else {
            $email = $this->input->post('emil_forgotpassword', true);

            $cek_email = $this->db->get_where('user_table', ['email' => $email])->row_array();

            if ($cek_email) {
                # code...
                $token = base64_encode(random_bytes(32));
                $param_user_token = [
                    'email' => $email,
                    'token' => $token,
                    'created' => time()
                ];
                $this->db->insert('user_token', $param_user_token);
                $this->_sendEmail($token);
                $this->session->set_flashdata('success', 'Link Ganti Password Telah Dikirim Ke email Anda Bila tidak menerima email cek difolder spam');
                redirect('login/forgotpassword');
            } else {
                $this->session->set_flashdata('gagal_resetpassword', 'email tidak terdaftar');
                $this->load->view('login/header');
                $this->load->view('login/forgot_password');
            }
        }
    }

    // send email

    private function _sendEmail($token)
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

        $this->email->from('qiliasalmu@gmail.com', 'Pamsismas');
        $this->email->to($this->input->post('emil_forgotpassword'));
        $this->email->subject('Reset Password');
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
          Reset Password Aplikasi Pamsismas Desa Bintoyo
        </td>
      </tr>
      <tr>
        <td colspan="2"><hr style="border-top: 2px solid black" /></td>
      </tr>
      <tr style="background-color: #f5f6fa">
        <td colspan="2">
          <p
            style="
              text-indent: 20px;
              text-align: justify;
              font-size: 20px;
              line-height: 40px;
            "
          >
            <span style="font-size: 30px">T</span>erimakasih telah melakukan
            permintaan mengatur ulang password. mengatur ulang password akan
            dapat dilakukan setelah anda menekan tombol dibawah ini. berikut
            adalah tombol untuk mengatur ulang password anda :
          </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <br />
          <a
            href="' . base_url('') . 'login/resetpassword?token=' . urlencode($token) . '"
            style="
              text-decoration: none;
              padding: 10px;
              background-color: #008cba;
              color: white;
              border-radius: 10px;
              margin: 10px 0px;
              font-size: 20px;
            "
            >Reset Password</a
          >
          <br />
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <p style="font-size: 20px; line-height: 30px">
            Jika tombol diatas mati anda dapat menyalin link berikut : <br />
            <a href="#"
              >' . base_url('') . 'login/resetpassword?token=' . urlencode($token) . '</a
            >
          </p>
        </td>
      </tr>
    </table>
    </body>
</html>
        ');

        if ($this->email->send()) {
            # code...
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function resetpassword()
    {
        $token  =  $this->input->get('token');

        $cek_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

        if ($cek_token) {
            # code...
            $email = $cek_token['email'];
            // var_dump($email);
            // die;
            $this->session->set_userdata('reset_password', $email);
            $this->changepassword();
        } else {
            # code...
            var_dump('gagal ');
            die;
        }
    }

    public function changepassword()
    {
        if (!$this->session->userdata('reset_password')) {
            # code...
            redirect('login');
        }

        $this->form_validation->set_rules('password1', "Password", "required|min_length[3]|matches[password2]");
        $this->form_validation->set_rules('password2', "Password Repeart", "required|min_length[3]|matches[password1]");

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/header');
            $this->load->view('login/change_password');
        } else {
            $email = $this->session->userdata('reset_password');
            $pasword = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            // params update user password 
            $params = [
                'user_pass' => $pasword
            ];
            $where = ['email' => $email];

            // query update user password
            $this->db->update('user_table', $params, $where);
            // destroy sesion untuk reset password 
            $this->session->unset_userdata('reset_password');
            // menghapus data user token untuk reset password
            $this->db->delete('user_token', ['email' => $email]);

            // kirim notifikasi berhasil gabti password 
            $this->session->set_flashdata('success', 'Password Berhasil di Ganti ');
            redirect('login');
        }
    }
}
