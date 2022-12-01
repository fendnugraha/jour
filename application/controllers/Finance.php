<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('home_model');
    }

    public function index()
    {
        $data['product'] = $this->db->query('SELECT *, inventory.id as inv_id FROM inventory JOIN product_cat ON product_cat.id = inventory.cat_id')->result_array();

        $data['total_inv'] = $this->db->query('SELECT sum(beli*stok) as total_inv FROM inventory')->row_array();
        $data['total_so'] = $this->db->query("SELECT sum(sales*price) as total FROM product_trace WHERE status = 1")->row_array();
        $data['laba'] = $this->db->query("SELECT sum((price*sales)-(cost*sales)) as laba FROM product_trace WHERE status = 1;")->row_array();

        $data['cashflow'] = $this->db->query("SELECT a.*, b.username FROM cashflow a LEFT JOIN user b ON b.id = a.user_id")->result_array();
        $data['kasakhir'] = $this->home_model->kasAkhir();

        $data['title'] = 'Dashboard';
        $this->load->view('include/header', $data);
        $this->load->view('home/dashboard', $data);
        $this->load->view('include/footer');
    }

    public function cashin()
    {
        $user_id = $this->session->userdata('user_id');
        $invoice = $this->home_model->invoice_so();

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|alpha_numeric_spaces|min_length[5]|trim');

        if ($this->form_validation->run() == false) {
            redirect('home');
        } else {

            $data = [
                'id' => null,
                'waktu' => $this->input->post('tanggal'),
                'invoice' => $invoice,
                'masuk' => $this->input->post('jumlah'),
                'keluar' => 0,
                'status' => 1,
                'deskripsi' => $this->input->post('deskripsi'),
                'date_modified' => time(),
                'user_id' => $user_id
            ];

            $this->db->insert('cashflow', $data);
            redirect('home');
        }
    }

    public function cashout()
    {
        $user_id = $this->session->userdata('user_id');
        $invoice = $this->home_model->invoice_po();

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|alpha_numeric_spaces|min_length[5]|trim');

        if ($this->form_validation->run() == false) {
            redirect('home');
        } else {

            $data = [
                'id' => null,
                'waktu' => $this->input->post('tanggal'),
                'invoice' => $invoice,
                'masuk' => 0,
                'keluar' => $this->input->post('jumlah'),
                'status' => 1,
                'deskripsi' => $this->input->post('deskripsi'),
                'date_modified' => time(),
                'user_id' => $user_id
            ];

            $this->db->insert('cashflow', $data);
            redirect('home');
        }
    }

    public function edit_cashflow($id)
    {
        $data['cashflow'] = $this->db->get_where('cashflow', ['id' => $id])->row_array();
        $data['status'] = $this->db->get('status')->result_array();

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('masuk', 'Jumlah', 'required|numeric|trim');
        $this->form_validation->set_rules('keluar', 'Jumlah', 'required|numeric|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|alpha_numeric_spaces|min_length[5]|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard/Edit Kas/' . $data['cashflow']['invoice'];
            $this->load->view('include/header', $data);
            $this->load->view('home/editkas', $data);
            $this->load->view('include/footer');
        } else {
            $data = [
                'masuk' => $this->input->post('masuk'),
                'keluar' => $this->input->post('keluar'),
                'deskripsi' => $this->input->post('deskripsi'),
                'status' => $this->input->post('status'),
                'date_modified' => time(),
                'user_id' => $this->session->userdata('user_id')
            ];

            $this->db->update('cashflow', $data, ['id' => $id]);
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Cashflow telah berhasil diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('home/edit_cashflow/' . $id);
        }
    }
}
