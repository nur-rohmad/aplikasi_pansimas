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
                $this->session->set_flashdata('success', 'Link Ganti Password Telah Dikirim Ke email Anda ');
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
            'smtp_pass' => 'Youtubepremium456',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('qiliasalmu@gmail.com', 'pansimas');
        $this->email->to($this->input->post('emil_forgotpassword'));
        $this->email->subject('reset Password');
        $this->email->message('
                <h2 >KP-SPAM Desa Bintoyo </h2>
                <p> Terima kasih telah melakukan permintaann untuk melakukan reset password. untuk melanjutkan reset password silahkan klik link berikut </p>
                <a href="' . base_url('') . 'login/resetpassword?token=' . urlencode($token) . '"> Reset Password </a>');

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
