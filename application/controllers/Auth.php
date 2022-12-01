<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $uname = $this->input->post('username');
        $password = $this->input->post('password');
        $waktu = time();

        $user = $this->db->get_where('user', ['username' => $uname, 'status' => 1])->row_array();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sql = "SELECT * FROM user WHERE username ='$uname'";

                $user = $this->db->query($sql)->row_array();
                $setting = $this->db->get_where('setting', ['id' => 1])->row_array();

                $data = [
                    'user_id' => $user['id'],
                    'uname' => $user['username'],
                    'role_id' => $user['role'],
                    'fullname' => $user['fullname'],
                    'brand-name' => $setting['brand_name'],
                    'slogan' => $setting['slogan'],
                    'address' => $setting['address'],
                    'phone' => $setting['phone']
                ];
                $this->session->set_userdata($data);
                $this->db->where('username', $uname)->update('user', ['last_login' => $waktu]);
                redirect('home');
            } else {
                $this->session->set_flashdata('message', '<span class="text-danger">Password is incorrect !</span>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<span class="text-danger">Username or Password is incorrect !</span>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $tanggal = date('Y-m-d');
        $uname = $this->session->userdata('uname');

        $this->session->unset_userdata('uname');
        $this->session->unset_userdata('role_id');
        // $this->session->set_flashdata('message', '<span class="text-success">See ya !</span>');
        redirect('auth');
    }

    public function register()
    {
        $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|required|trim|is_unique[user.username]');
        $this->form_validation->set_rules('fullname', 'Full name', 'alpha_numeric_spaces|required|trim');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]|required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/register');
        } else {
            $this->_register_input();
        }
    }

    private function _register_input()
    {
        $data = [
            'id' => null,
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('fullname'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => $this->input->post('role'),
            'date_reg' => time(),
            'last_login' => 0,
            'status' => 1
        ];

        if ($this->db->insert('user', $data)) {
            redirect('auth/reg_success');
        } else {
            redirect('auth/register');
        }
    }

    public function reg_success()
    {
        $this->load->view('auth/register_success');
        $this->load->view('include/footer');
    }

    public function error404()
    {
        $this->load->view('auth/error404');
    }
}
