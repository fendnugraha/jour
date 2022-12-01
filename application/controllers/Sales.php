<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('sales_model');
    }

    public function index()
    {
        $this->db->select('a.*, b.nama as supplier, c.nama as product, d.username');
        $this->db->join('contact b', 'b.id = a.contact_id', 'left');
        $this->db->join('inventory c', 'c.id = a.product_id', 'left');
        $this->db->join('user d', 'd.id = a.user_id', 'left');
        $data['product_trace'] = $this->db->get_where('product_trace a', ['sales >' => 0])->result_array();

        $data['total_so'] = $this->db->query("SELECT sum(sales*price) as total FROM product_trace WHERE status = 1")->row_array();
        $data['laba'] = $this->db->query("SELECT sum((price*sales)-(cost*sales)) as laba FROM product_trace WHERE status = 1;")->row_array();

        $data['title'] = 'Penjualan';
        $this->load->view('include/header', $data);
        $this->load->view('sales/index', $data);
        $this->load->view('include/footer');
    }

    public function addSales()
    {
        $data['product'] = $this->db->get('inventory')->result_array();
        $data['contact'] = $this->db->get('contact')->result_array();
        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('p_sup', 'Supplier', 'required');
        $this->form_validation->set_rules('p_id', 'Product', 'required');
        $this->form_validation->set_rules('p_qty', 'Jumlah', 'required|numeric|trim');
        $this->form_validation->set_rules('p_price', 'Harga', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Penjualan - Add Sales';
            $this->load->view('include/header', $data);
            $this->load->view('sales/sales', $data);
            $this->load->view('include/footer');
        } else {
            $cost = $this->db->get_where('inventory', ['id' => $this->input->post('p_id')])->row_array();
            $invoice = $this->sales_model->invoice_so();
            $jumlah = $this->input->post('p_qty') * $this->input->post('p_price');

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice,
                'contact_id' => $this->input->post('p_sup'),
                'product_id' => $this->input->post('p_id'),
                'purchases' => 0,
                'sales' => $this->input->post('p_qty'),
                'price' => $this->input->post('p_price'),
                'cost' => $cost['beli'],
                'status' => 1,
                'date_created' => time(),
                'user_id' => $user_id,
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice,
                'masuk' => $jumlah,
                'keluar' => 0,
                'status' => 1,
                'deskripsi' => "Penjualan barang",
                'date_modified' => time(),
                'user_id' => $user_id
            ];

            $this->db->trans_begin();

            $this->db->insert('product_trace', $data);
            $this->db->insert('cashflow', $data2);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $p_id = $this->input->post('p_id');
                $sisa_stok = $this->db->query("SELECT sum(purchases-sales) as stok FROM product_trace WHERE product_id = '$p_id' and status = 1")->row_array();
                $update_stok = $sisa_stok['stok'];

                $this->db->update('inventory', ['stok' => $update_stok, 'date_modified' => time()], ['id' => $this->input->post('p_id')]);

                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Penjualan barang berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('sales/addSales');
        }
    }

    public function edit_sales($po_id)
    {
        $data['product'] = $this->db->get('inventory')->result_array();
        $data['sales'] = $this->db->get_where('product_trace', ['id' => $po_id])->row_array();
        $data['contact'] = $this->db->get('contact')->result_array();
        $data['status'] = $this->db->get('status')->result_array();
        $user_id = $this->session->userdata('user_id');
        $po_id = $this->input->post('po_id');

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('p_sup', 'Supplier', 'required');
        $this->form_validation->set_rules('p_id', 'Product', 'required');
        $this->form_validation->set_rules('p_qty', 'Jumlah', 'required|numeric|trim');
        $this->form_validation->set_rules('p_price', 'Harga', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Penjualan - Edit Sales';
            $this->load->view('include/header', $data);
            $this->load->view('sales/edit_sales', $data);
            $this->load->view('include/footer');
        } else {

            $data = [
                'waktu' => $this->input->post('p_date'),
                'contact_id' => $this->input->post('p_sup'),
                'product_id' => $this->input->post('p_id'),
                'price' => $this->input->post('p_price'),
                'sales' => $this->input->post('p_qty'),
                'status' => $this->input->post('p_status'),
                'user_id' => $user_id,
                'date_created' => time()
            ];

            $this->db->trans_begin();

            $this->db->update('product_trace', $data, ['id' => $po_id]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $p_id = $this->input->post('p_id');
                $sisa_stok = $this->db->query("SELECT sum(purchases-sales) as stok FROM product_trace WHERE product_id = '$p_id' and status = 1")->row_array();
                $update_stok = $sisa_stok['stok'];

                $this->db->update('inventory', ['stok' => $update_stok, 'date_modified' => time()], ['id' => $this->input->post('p_id')]);

                $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Penjualan barang berhasil diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('sales/edit_sales/' . $po_id);
        }
    }
}
