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
        $this->load->model('finance_model');
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

    public function cashTotal()
    {
        if ($this->input->post('endDate') == "") {
            $data['endDate'] = date('Y-m-d');
        } else {
            $data['endDate'] = $this->input->post('endDate');
        }

        $data['startDate'] = date('Y-m-d', strtotime("Last day of last month", strtotime($data['endDate'])));

        $this->db->like('kode', '10100', 'after');
        $this->db->or_like('kode', '10200', 'after');
        $data['assets'] = $this->db->get('accounts')->result_array();

        $data['title'] = 'Finance / Cash & Bank';
        $this->load->view('include/header', $data);
        $this->load->view('finance/cashtotal', $data);
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

    public function jurnal()
    {
        if ($this->input->post('startDate') == "" || $this->input->post('endDate') == "") {
            $data['startDate'] = date('Y-m-d');
            $data['endDate'] = date('Y-m-d');
        } else {
            $data['startDate'] = $this->input->post('startDate');
            $data['endDate'] = $this->input->post('endDate');
        }

        $this->db->select('a.*, b.username, c.acc_name as debt_name, d.acc_name as cred_name, e.warehouse_name');
        $this->db->join('user b', 'b.id = a.user_id', 'left');
        $this->db->join('acc_coa c', 'c.acc_code = a.debt_code', 'left');
        $this->db->join('acc_coa d', 'd.acc_code = a.cred_code', 'left');
        $this->db->join('warehouse e', 'e.id = a.wh_id', 'left');
        $this->db->where("date(waktu) BETWEEN '" . $data['startDate'] . "' AND '" . $data['endDate'] . "'");
        $this->db->order_by('id', 'DESC');
        $data['account_trace'] = $this->db->get('account_trace a')->result_array();

        // $data['total_po'] = $this->db->query("SELECT sum(purchases*price) as total FROM product_trace WHERE status = 1")->row_array();
        // $data['total_inv'] = $this->db->query('SELECT sum(beli*stok) as total_inv FROM inventory')->row_array();

        $data['title'] = 'Dashboard / Jurnal Umum';
        $this->load->view('include/header', $data);
        $this->load->view('finance/jurnal', $data);
        $this->load->view('include/footer');
    }

    public function addJournal()
    {
        $user_id = $this->session->userdata('user_id');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required|differs[acc_debet]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|max_length[320]|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Add Journal';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addjournal', $data);
            $this->load->view('include/footer');
        } else {
            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $this->finance_model->invoice_journal(),
                'description' => $this->input->post('description'),
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => $this->input->post('acc_credit'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'user_id' => $user_id,
                'wh_id' => $this->session->userdata('wh_id')
            ];

            $this->db->insert('account_trace', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Journal telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('finance/addJournal');
        }
    }

    public function editJournal($j_id)
    {
        $user_id = $this->session->userdata('user_id');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();
        $data['journal'] = $this->db->get_where('account_trace', ['id' => $j_id, 'rvpy' => null])->row_array();
        $data['status'] = $this->db->get('status')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required|differs[acc_debet]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|max_length[320]|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Edit Journal / Journal ID ' . $j_id;
            $this->load->view('include/header', $data);
            $this->load->view('finance/editjournal', $data);
            $this->load->view('include/footer');
        } else {
            $data = [
                'waktu' => $this->input->post('p_date'),
                'description' => $this->input->post('description'),
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => $this->input->post('acc_credit'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => $this->input->post('status'),
                'user_id' => $user_id
            ];

            $this->db->update('account_trace', $data, ['id' => $j_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Journal telah berhasil diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('finance/editJournal/' . $j_id);
        }
    }

    public function jr_detail($jr_id)
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->select('a.*, b.username, c.acc_name as debt_name, d.acc_name as cred_name');
        $this->db->join('user b', 'b.id = a.user_id', 'left');
        $this->db->join('acc_coa c', 'c.acc_code = a.debt_code', 'left');
        $this->db->join('acc_coa d', 'd.acc_code = a.cred_code', 'left');
        // $this->db->where("date(waktu) BETWEEN '" . $data['startDate'] . "' AND '" . $data['endDate'] . "'");
        // $this->db->order_by('id', 'DESC');
        $data['account_trace'] = $this->db->get_where('account_trace a', ['a.id' => $jr_id])->row_array();

        $data['title'] = 'Dashboard / Jurnal Umum / Jurnal Detail';
        $this->load->view('include/header', $data);
        $this->load->view('finance/jr_detail', $data);
        $this->load->view('include/footer');
    }

    // Receivable AREA

    public function receivable()
    {
        $this->db->select('a.*, sum(a.bill_amount-a.pay_amount) as bill_total, b.nama as ct_name');
        $this->db->join('contact b', 'b.id = a.contact_id', 'left');
        $data['receivable'] = $this->db->group_by('contact_id')->get('receivable_tb a')->result_array();

        $data['dt_receivable'] = $this->db->query("SELECT SUM(bill_amount) as bill, SUM(pay_amount) as got_paid, SUM(bill_amount-pay_amount) as remaining FROM receivable_tb WHERE pay_stats < 3")->row_array();

        $data['title'] = 'Dashboard / Jurnal Umum / Piutang';
        $this->load->view('include/header', $data);
        $this->load->view('finance/receivable', $data);
        $this->load->view('include/footer');
    }

    public function addReceivable()
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->like('acc_code', '10400-', 'after');
        $data['acc_rv'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $this->db->like('acc_code', '10', 'after');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();
        $data['contact'] = $this->db->get('contact')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required|differs[acc_debet]');
        $this->form_validation->set_rules('contact', 'Kontak', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Piutang / Tambah Piutang';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addReceivable', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->finance_model->invoice_receivable($this->input->post('contact'));
            $contact_name = $this->db->get_where('contact', ['id' => $this->input->post('contact')])->row_array();

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $this->input->post('contact'),
                'description' => $this->input->post('description') . '. ' . $contact_name['nama'],
                'bill_amount' => $this->input->post('jumlah'),
                'pay_amount' => 0,
                'pay_stats' => 0,
                'pay_nth' => 0,
                'rv_type' => $this->input->post('acc_debet')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => $this->input->post('description') . '. ' . $contact_name['nama'],
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => $this->input->post('acc_credit'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Receivable',
                'pay_stats' => 0,
                'pay_nth' => 0,
                'user_id' => $user_id,
                'wh_id' => $this->session->userdata('wh_id')
            ];

            $this->db->trans_begin();
            $this->db->insert('receivable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Piutang baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/addReceivable');
        }
    }

    public function addReceivableSt()
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->like('acc_code', '10400-', 'after');
        $data['acc_rv'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $data['contact'] = $this->db->get('contact')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('contact', 'Kontak', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Piutang / Tambah Piutang Awal';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addReceivableSt', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->finance_model->invoice_receivable($this->input->post('contact'));
            $contact_name = $this->db->get_where('contact', ['id' => $this->input->post('contact')])->row_array();

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $this->input->post('contact'),
                'description' => 'Saldo Awal Piutang . ' . $this->input->post('description') . '. ' . $contact_name['nama'],
                'bill_amount' => $this->input->post('jumlah'),
                'pay_amount' => 0,
                'pay_stats' => 0,
                'pay_nth' => 0,
                'rv_type' => $this->input->post('acc_debet')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => 'Saldo Awal Piutang . ' . $this->input->post('description') . '. ' . $contact_name['nama'],
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => '30100-001',
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Receivable',
                'pay_stats' => 0,
                'pay_nth' => 0,
                'user_id' => $user_id,
                'wh_id' => $this->session->userdata('wh_id')
            ];

            $this->db->trans_begin();
            $this->db->insert('receivable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Piutang baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/addReceivableSt');
        }
    }

    public function addRcvDeposit()
    {
        $user_id = $this->session->userdata('user_id');
        $wh_id = $this->session->userdata('wh_id');

        $this->db->like('acc_code', '10400-', 'after');
        $data['acc_rv'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $this->db->like('acc_code', '10', 'after');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();
        $data['contact'] = $this->db->get('contact')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required|differs[acc_debet]');
        $this->form_validation->set_rules('contact', 'Kontak', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Piutang / Tambah Piutang Saldo';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addRcvDeposit', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->finance_model->invoice_receivable($this->input->post('contact'));
            $contact_name = $this->db->get_where('contact', ['id' => $this->input->post('contact')])->row_array();

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $this->input->post('contact'),
                'description' => $this->input->post('description') . '. ' . $contact_name['nama'],
                'bill_amount' => $this->input->post('jumlah'),
                'pay_amount' => 0,
                'pay_stats' => 0,
                'pay_nth' => 0,
                'rv_type' => $this->input->post('acc_credit')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => $this->input->post('description') . '. ' . $contact_name['nama'],
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => $this->input->post('acc_credit'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Receivable',
                'pay_stats' => 0,
                'pay_nth' => 0,
                'user_id' => $user_id,
                'wh_id' => $wh_id
            ];

            $this->db->trans_begin();
            $this->db->insert('receivable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Piutang baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/addRcvDeposit');
        }
    }

    public function deleteRcv($id)
    {
        $dtRcv = $this->db->get_where('receivable_tb', ['id' => $id])->row_array();
        $invoice = $dtRcv['invoice'];
        $pay_nth = $dtRcv['pay_nth'];
        $cust_id = $dtRcv['contact_id'];

        $paycheck = $this->db->query("SELECT sum(pay_amount) as paid FROM receivable_tb WHERE invoice  = '$invoice'")->row_array();
        $paycheck = $paycheck['paid'];

        if ($pay_nth == 0) {
            if ($paycheck > 0) {
                redirect('finance/rv_detail/' . $cust_id);
            } else {
                $this->db->trans_begin();
                $this->db->delete('receivable_tb', ['id' => $id]);
                $this->db->delete('account_trace', ['invoice' => $invoice]);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    redirect('finance/rv_detail/' . $cust_id);
                }
            }
        } else {
            $this->db->trans_begin();
            $this->db->delete('receivable_tb', ['id' => $id]);
            $this->db->query("DELETE FROM account_trace WHERE invoice = '$invoice' AND pay_nth = $pay_nth");
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                redirect('finance/rv_detail/' . $cust_id);
            }
        }
    }

    public function addReceivableSales()
    {
        $user_id = $this->session->userdata('user_id');
        $wh_id = $this->session->userdata('wh_id');

        $this->db->like('acc_code', '10400-', 'after');
        $data['acc_rv'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $this->db->like('acc_code', '10', 'after');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();
        $data['contact'] = $this->db->get('contact')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        // $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required|differs[acc_debet]');
        $this->form_validation->set_rules('contact', 'Kontak', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Piutang / Tambah Penjualan Kredit';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addReceivableSales', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->finance_model->invoice_receivable($this->input->post('contact'));
            $contact_name = $this->db->get_where('contact', ['id' => $this->input->post('contact')])->row_array();

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $this->input->post('contact'),
                'description' => $this->input->post('description'),
                'bill_amount' => $this->input->post('jumlah'),
                'pay_amount' => 0,
                'pay_stats' => 0,
                'pay_nth' => 0,
                'rv_type' => '10600-001'
            ];

            $data2 = [
                [
                    'id' => null,
                    'waktu' => $this->input->post('p_date'),
                    'invoice' => $invoice_no,
                    'description' => $this->input->post('description'),
                    'debt_code' => $this->input->post('acc_debet'),
                    'cred_code' => '40100-001',
                    'jumlah' => $this->input->post('jumlah'),
                    'status' => 1,
                    'rvpy' => 'Receivable',
                    'pay_stats' => 0,
                    'pay_nth' => 0,
                    'user_id' => $user_id,
                    'wh_id' => $wh_id
                ],
                [
                    'id' => null,
                    'waktu' => $this->input->post('p_date'),
                    'invoice' => $invoice_no,
                    'description' => $this->input->post('description'),
                    'debt_code' => '50100-001',
                    'cred_code' => '10600-001',
                    'jumlah' => $this->input->post('HPP'),
                    'status' => 1,
                    'rvpy' => 'Receivable',
                    'pay_stats' => 0,
                    'pay_nth' => 0,
                    'user_id' => $user_id,
                    'wh_id' => $wh_id
                ]

            ];

            $this->db->trans_begin();
            $this->db->insert('receivable_tb', $data);
            $this->db->insert_batch('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Piutang baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/addReceivableSales');
        }
    }

    public function rv_detail($contact_id)
    {
        $user_id = $this->session->userdata('user_id');
        $wh_id = $this->session->userdata('wh_id');
        
        $contact = $this->db->get_where('contact', ['id' => $contact_id])->row_array();

        $data['contact_id'] = $contact_id;

        $this->db->select('a.*, b.acc_name');
        $this->db->join('acc_coa b', 'b.acc_code = a.rv_type', 'left');
        $this->db->order_by('waktu', 'DESC');
        $data['rv_detail'] = $this->db->get_where('receivable_tb a', ['contact_id' => $contact_id])->result_array();

        $data['rv_remain'] = $this->db->query("SELECT invoice, waktu, sum(bill_amount-pay_amount) as remaining FROM receivable_tb WHERE contact_id = $contact_id GROUP BY invoice HAVING remaining <> 0 ")->result_array();

        $this->db->like('acc_code', '10100-', 'after');
        $this->db->or_like('acc_code', '10200-', 'after');
        $this->db->or_like('acc_code', '20100-002', 'after');
        $this->db->or_like('acc_code', '30100-001', 'after');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $data['rv_stats'] = $this->db->select('sum(bill_amount) as billing, sum(pay_amount) as payments, sum(bill_amount-pay_amount) as rv_remain')->get_where('receivable_tb', ['contact_id' => $contact_id])->row_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('invoice', 'Invoice', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Piutang / Piutang Detail';
            $this->load->view('include/header', $data);
            $this->load->view('finance/rv_detail', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->input->post('invoice');
            $rcv = $this->db->get_where('account_trace', ['invoice' => $invoice_no, 'pay_nth' => 0])->row_array();
            $dtrcv = $this->db->get_where('receivable_tb', ['invoice' => $invoice_no, 'pay_nth' => 0])->row_array();
            if ($rcv['debt_code'] == null) {
                $rv_account = $dtrcv['rv_type'];
            } else {
                $rv_account = $rcv['debt_code'];
            }
            $pay_nth = $this->db->query("SELECT MAX(pay_nth) as pay_max FROM receivable_tb WHERE invoice = '$invoice_no' and pay_stats < 3")->row_array();
            $pay_nth = $pay_nth['pay_max'] + 1;

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $contact_id,
                'description' => $this->input->post('description') . ".Pembayaran dari " . $contact['nama'] . " / " . $contact['keterangan'],
                'bill_amount' => 0,
                'pay_amount' => $this->input->post('jumlah'),
                'pay_stats' => 1,
                'pay_nth' => $pay_nth,
                'rv_type' => $this->input->post('acc_debet')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => $this->input->post('description') . ".Pembayaran dari " . $contact['nama'] . " / " . $contact['keterangan'],
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => $rv_account,
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Receivable',
                'pay_stats' => 1,
                'pay_nth' => $pay_nth,
                'user_id' => $user_id,
                'wh_id' => $wh_id
            ];

            $this->db->trans_begin();
            $this->db->insert('receivable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Pembayaran Piutang telah berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/rv_detail/' . $contact_id);
        }
    }


    // Payable Area

    public function payable()
    {
        $this->db->select('a.*, sum(a.bill_amount-a.pay_amount) as bill_total, b.nama as ct_name');
        $this->db->join('contact b', 'b.id = a.contact_id', 'left');
        $data['payable'] = $this->db->group_by('contact_id')->get('payable_tb a')->result_array();

        $data['dt_payable'] = $this->db->query("SELECT SUM(bill_amount) as bill, SUM(pay_amount) as got_paid, SUM(bill_amount-pay_amount) as remaining FROM payable_tb WHERE pay_stats < 3")->row_array();

        $data['title'] = 'Dashboard / Jurnal Umum / Hutang';
        $this->load->view('include/header', $data);
        $this->load->view('finance/payable', $data);
        $this->load->view('include/footer');
    }

    public function addPayable()
    {
        $user_id = $this->session->userdata('user_id');
        $wh_id = $this->session->userdata('wh_id');

        $this->db->like('acc_code', '20', 'after');
        $data['acc_rv'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $this->db->like('acc_code', '10', 'after');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();
        $data['contact'] = $this->db->get('contact')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required|differs[acc_debet]');
        $this->form_validation->set_rules('contact', 'Kontak', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Hutang / Tambah Hutang';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addPayable', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->finance_model->invoice_payable($this->input->post('contact'));
            $contact_name = $this->db->get_where('contact', ['id' => $this->input->post('contact')])->row_array();

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $this->input->post('contact'),
                'description' => $this->input->post('description') . '. ' . $contact_name['nama'],
                'bill_amount' => $this->input->post('jumlah'),
                'pay_amount' => 0,
                'pay_stats' => 0,
                'pay_nth' => 0,
                'rv_type' => $this->input->post('acc_debet')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => $this->input->post('description') . '. ' . $contact_name['nama'],
                'debt_code' => $this->input->post('acc_credit'),
                'cred_code' => $this->input->post('acc_debet'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Payable',
                'pay_stats' => 0,
                'pay_nth' => 0,
                'user_id' => $user_id,
                'wh_id' => $wh_id
            ];

            $this->db->trans_begin();
            $this->db->insert('payable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Hutang baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/addpayable');
        }
    }

    public function addPayableSt()
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->like('acc_code', '20', 'after');
        $data['acc_rv'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $data['contact'] = $this->db->get('contact')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_credit', 'Akun Credit', 'required');
        $this->form_validation->set_rules('contact', 'Kontak', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Hutang / Tambah Hutang Awal';
            $this->load->view('include/header', $data);
            $this->load->view('finance/addPayableSt', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->finance_model->invoice_receivable($this->input->post('contact'));
            $contact_name = $this->db->get_where('contact', ['id' => $this->input->post('contact')])->row_array();

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $this->input->post('contact'),
                'description' => 'Saldo Awal Hutang . ' . $this->input->post('description') . '. ' . $contact_name['nama'],
                'bill_amount' => $this->input->post('jumlah'),
                'pay_amount' => 0,
                'pay_stats' => 0,
                'pay_nth' => 0,
                'rv_type' => $this->input->post('acc_credit')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => 'Saldo Awal Hutang . ' . $this->input->post('description') . '. ' . $contact_name['nama'],
                'debt_code' => '30100-001',
                'cred_code' => $this->input->post('acc_credit'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Payable',
                'pay_stats' => 0,
                'pay_nth' => 0,
                'user_id' => $user_id,
                'wh_id' => $this->session->userdata('wh_id')
            ];

            $this->db->trans_begin();
            $this->db->insert('payable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Hutang baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/addPayableSt');
        }
    }

    public function py_detail($contact_id)
    {
        $user_id = $this->session->userdata('user_id');
        $wh_id = $this->session->userdata('wh_id');

        $contact = $this->db->get_where('contact', ['id' => $contact_id])->row_array();

        $data['contact_id'] = $contact_id;
        $this->db->select('a.*, b.acc_name');
        $this->db->join('acc_coa b', 'b.acc_code = a.rv_type', 'left');
        $this->db->order_by('waktu', 'DESC');
        $data['rv_detail'] = $this->db->get_where('payable_tb a', ['contact_id' => $contact_id])->result_array();

        $data['rv_remain'] = $this->db->query("SELECT invoice, waktu, sum(bill_amount-pay_amount) as remaining FROM payable_tb WHERE contact_id = $contact_id GROUP BY invoice  HAVING remaining <> 0 ")->result_array();

        $this->db->like('acc_code', '10', 'after');
        $this->db->or_like('acc_code', '20100-002', 'after');
        $this->db->or_like('acc_code', '30100-001', 'after');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $data['rv_stats'] = $this->db->select('sum(bill_amount) as billing, sum(pay_amount) as payments, sum(bill_amount-pay_amount) as rv_remain')->get_where('payable_tb', ['contact_id' => $contact_id])->row_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('invoice', 'Invoice', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|alpha_numeric_spaces|max_length[320]');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Hutang / Hutang Detail';
            $this->load->view('include/header', $data);
            $this->load->view('finance/py_detail', $data);
            $this->load->view('include/footer');
        } else {
            $invoice_no = $this->input->post('invoice');
            $rcv = $this->db->get_where('account_trace', ['invoice' => $invoice_no, 'pay_nth' => 0])->row_array();
            $rv_account = $rcv['cred_code'];
            $pay_nth = $this->db->query("SELECT MAX(pay_nth) as pay_max FROM payable_tb WHERE invoice = '$invoice_no' and pay_stats < 3")->row_array();
            $pay_nth = $pay_nth['pay_max'] + 1;

            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'contact_id' => $contact_id,
                'description' => $this->input->post('description') . ".Pembayaran ke " . $contact['nama'] . " / " . $contact['keterangan'],
                'bill_amount' => 0,
                'pay_amount' => $this->input->post('jumlah'),
                'pay_stats' => 1,
                'pay_nth' => $pay_nth,
                'rv_type' => $this->input->post('acc_debet')
            ];

            $data2 = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $invoice_no,
                'description' => $this->input->post('description') . ".Pembayaran ke " . $contact['nama'] . " / " . $contact['keterangan'],
                'debt_code' => $rv_account,
                'cred_code' => $this->input->post('acc_debet'),
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'rvpy' => 'Payable',
                'pay_stats' => 1,
                'pay_nth' => $pay_nth,
                'user_id' => $user_id,
                'wh_id' => $wh_id
            ];

            $this->db->trans_begin();
            $this->db->insert('payable_tb', $data);
            $this->db->insert('account_trace', $data2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Pembayaran Hutang telah berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            }
            redirect('finance/py_detail/' . $contact_id);
        }
    }

    public function deletePay($id)
    {
        $dtRcv = $this->db->get_where('payable_tb', ['id' => $id])->row_array();
        $invoice = $dtRcv['invoice'];
        $pay_nth = $dtRcv['pay_nth'];
        $cust_id = $dtRcv['contact_id'];

        $paycheck = $this->db->query("SELECT sum(pay_amount) as paid FROM payable_tb WHERE invoice  = '$invoice'")->row_array();
        $paycheck = $paycheck['paid'];

        if ($pay_nth == 0) {
            if ($paycheck > 0) {
                redirect('finance/py_detail/' . $cust_id);
            } else {
                $this->db->trans_begin();
                $this->db->delete('payable_tb', ['id' => $id]);
                $this->db->delete('account_trace', ['invoice' => $invoice]);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    redirect('finance/py_detail/' . $cust_id);
                }
            }
        } else {
            $this->db->trans_begin();
            $this->db->delete('payable_tb', ['id' => $id]);
            $this->db->query("DELETE FROM account_trace WHERE invoice = '$invoice' AND pay_nth = $pay_nth");
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                redirect('finance/py_detail/' . $cust_id);
            }
        }
    }

    //Isi Deposit
    public function addDeposit()
    {
        $user_id = $this->session->userdata('user_id');
        $data['accounts'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $this->form_validation->set_rules('p_date', 'Tanggal', 'required');
        $this->form_validation->set_rules('acc_debet', 'Akun Debet', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|max_length[320]|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Dashboard / Jurnal Umum / Add Deposit';
            $this->load->view('include/header', $data);
            $this->load->view('finance/adddeposit', $data);
            $this->load->view('include/footer');
        } else {
            $data = [
                'id' => null,
                'waktu' => $this->input->post('p_date'),
                'invoice' => $this->finance_model->invoice_journal(),
                'description' => 'Isi Saldo Deposit (' . $this->input->post('description') . ')',
                'debt_code' => $this->input->post('acc_debet'),
                'cred_code' => '20100-002',
                'jumlah' => $this->input->post('jumlah'),
                'status' => 1,
                'user_id' => $user_id,
                'wh_id' => $this->session->userdata('wh_id')
            ];

            $this->db->insert('account_trace', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Journal telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('finance/addDeposit');
        }
    }
}
