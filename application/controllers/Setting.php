<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Setting';
        $this->load->view('include/header', $data);
        $this->load->view('setting/index', $data);
        $this->load->view('include/footer');
    }

    public function general()
    {
        $data['general'] = $this->db->get_where('setting', ['id' => 1])->row_array();

        $this->form_validation->set_rules('brand-name', 'Brand Name', 'Required|max_length[15]');
        $this->form_validation->set_rules('slogan', 'Slogan', 'max_length[60]|alpha_numeric_spaces');
        $this->form_validation->set_rules('address', 'Alamat', 'Required|max_length[160]');
        $this->form_validation->set_rules('phone', 'Nomor Telepon', 'Required|max_length[15]|numeric');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Setting / General';
            $this->load->view('include/header', $data);
            $this->load->view('setting/general', $data);
            $this->load->view('include/footer');
        } else {
            $data = [
                'brand_name' => $this->input->post('brand-name'),
                'slogan' => $this->input->post('slogan'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'kas_awal' => $this->input->post('kas_awal')
            ];

            $this->db->update('setting', $data, ['id' => 1]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Setting updated, please relogin to take effect !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect('setting/general');
        }
    }

    public function contact()
    {
        $data['contact'] = $this->db->get('contact')->result_array();

        $data['title'] = 'Setting / Contact Management';
        $this->load->view('include/header', $data);
        $this->load->view('setting/addcontact', $data);
        $this->load->view('include/footer');
    }

    public function addContact()
    {
        $this->form_validation->set_rules('ct_name', 'Nama Kontak', 'required|alpha_numeric_spaces|trim|max_length[60]');
        $this->form_validation->set_rules('ct_desc', 'Deskripsi', 'alpha_numeric_spaces|trim|max_length[160]');

        $data = [
            'id' => null,
            'nama' => $this->input->post('ct_name'),
            'type' => $this->input->post('ct_type'),
            'keterangan' => $this->input->post('ct_desc')
        ];

        if ($this->form_validation->run() == false) {
            redirect('setting/contact');
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Gagal menambah kontak, silahkan hubungi administrator.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        } else {
            $this->db->insert('contact', $data);
            redirect('setting/contact');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Contact berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
    }

    public function usermng()
    {
        $data['usermng'] = $this->db->get('user')->result_array();

        $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|required|trim|is_unique[user.username]');
        $this->form_validation->set_rules('fullname', 'Full name', 'alpha_numeric_spaces|required|trim');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]|required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Setting - User Management';
            $this->load->view('include/header', $data);
            $this->load->view('setting/adduser', $data);
            $this->load->view('include/footer');
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
            redirect('setting/usermng');
        } else {
            redirect('setting/usermng');
        }
    }

    public function edit_user($id)
    {
        $data['usermng'] = $this->db->get_where('user', ['id' => $id])->row_array();
        $data['user_role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('fullname', 'Full name', 'alpha_numeric_spaces|required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Setting - User Management';
            $this->load->view('include/header', $data);
            $this->load->view('setting/edit_user', $data);
            $this->load->view('include/footer');
        } else {
            $data = [
                'fullname' => $this->input->post('fullname'),
                'role' => $this->input->post('role')
            ];
            $this->db->update('user', $data, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> User telah diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('setting/edit_user/' . $id);
        }
    }

    public function resetpassword($id)
    {
        $data['dtuser'] = $this->db->get_where('user', ['id' => $id])->row_array();

        $this->form_validation->set_rules('password', 'Password', 'min_length[6]|required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Setting / User Management / ' . $data['dtuser']['username'] . ' / Reset Password';
            $this->load->view('include/header', $data);
            $this->load->view('setting/resetpassword', $data);
            $this->load->view('include/footer');
        } else {
            $this->db->update('user', ['password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),], ['id' => $id]);
            redirect('setting/edit_user/' . $id);
        }
    }

    public function accounts()
    {
        $data['title'] = 'Setting / Chart of Accounts';
        $this->load->view('include/header', $data);
        $this->load->view('setting/accounts', $data);
        $this->load->view('include/footer');
    }
}
