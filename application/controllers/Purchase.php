<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('purchase_model');
    }

    public function index()
    {
        $this->db->select('a.*, b.nama as supplier, c.nama as product, d.username');
        $this->db->join('contact b', 'b.id = a.contact_id', 'left');
        $this->db->join('inventory c', 'c.id = a.product_id', 'left');
        $this->db->join('user d', 'd.id = a.user_id', 'left');
        $data['product_trace'] = $this->db->get_where('product_trace a', ['purchases >' => 0])->result_array();

        $data['total_po'] = $this->db->query("SELECT sum(purchases*price) as total FROM product_trace WHERE status = 1")->row_array();
        $data['total_inv'] = $this->db->query('SELECT sum(beli*stok) as total_inv FROM inventory')->row_array();

        $data['title'] = 'Pembelian';
        $this->load->view('include/header', $data);
        $this->load->view('purchase/index', $data);
        $this->load->view('include/footer');
    }

    public function addPurchase()
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
            $data['title'] = 'Pembelian - Add Purchase';
            $this->load->view('include/header', $data);
            $this->load->view('purchase/purchase', $data);
            $this->load->view('include/footer');
        } else {
            $invoice = $this->purchase_model->invoice_po();
            $jumlah = $this->input->post('p_qty') * $this->input->post('p_price');

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice,
                'contact_id' => $this->input->post('p_sup'),
                'product_id' => $this->input->post('p_id'),
                'purchases' => $this->input->post('p_qty'),
                'sales' => 0,
                'price' => $this->input->post('p_price'),
                'status' => 1,
                'date_created' => time(),
                'user_id' => $user_id
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice,
                'masuk' => 0,
                'keluar' => $jumlah,
                'status' => 1,
                'deskripsi' => "Pembelian stok barang",
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
                $update_cost = $this->purchase_model->updateCost($this->input->post('p_id'));

                $this->db->update('inventory', ['stok' => $update_stok, 'beli' => $update_cost, 'date_modified' => time()], ['id' => $this->input->post('p_id')]);

                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Pembelian barang berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('purchase/addPurchase');
        }
    }

    public function edit_purchase($po_id)
    {
        $data['product'] = $this->db->get('inventory')->result_array();
        $data['purchase'] = $this->db->get_where('product_trace', ['id' => $po_id])->row_array();
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

            $data['title'] = 'Pembelian - Edit Purchase';
            $this->load->view('include/header', $data);
            $this->load->view('purchase/edit_purchase', $data);
            $this->load->view('include/footer');
        } else {

            $data = [
                'waktu' => $this->input->post('p_date'),
                'contact_id' => $this->input->post('p_sup'),
                'product_id' => $this->input->post('p_id'),
                'price' => $this->input->post('p_price'),
                'purchases' => $this->input->post('p_qty'),
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
                $update_cost = $this->purchase_model->updateCost($this->input->post('p_id'));

                $this->db->update('inventory', ['stok' => $update_stok, 'beli' => $update_cost, 'date_modified' => time()], ['id' => $this->input->post('p_id')]);

                $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Pembelian barang berhasil diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('purchase/edit_purchase/' . $po_id);
        }
    }
}
