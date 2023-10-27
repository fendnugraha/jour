<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('finance_model');
    }

    public function index()
    {
        $data['title'] = 'Report';
        $this->load->view('include/header', $data);
        $this->load->view('report/index', $data);
        $this->load->view('include/footer');
    }

    public function profitLossProduct()
    {
        $data['dailyprofit'] = $this->db->query("SELECT date(waktu) as tanggal, sum(sales*cost) as modal, sum(sales*price) as jual FROM product_trace Where status = 1 group by date(waktu) ")->result_array();
        $data['monthlyprofit'] = $this->db->query("SELECT month(waktu) as bulan, year(waktu) as tahun, sum(sales*cost) as modal, sum(sales*price) as jual FROM product_trace Where status = 1 group by month(waktu), year(waktu) ")->result_array();
        $data['yearlyprofit'] = $this->db->query("SELECT year(waktu) as tanggal, sum(sales*cost) as modal, sum(sales*price) as jual FROM product_trace Where status = 1 group by year(waktu) ")->result_array();

        $data['title'] = 'Report / Laba Rugi';
        $this->load->view('include/header', $data);
        $this->load->view('report/labarugi', $data);
        $this->load->view('include/footer');
    }

    public function profitLossStatement()
    {
        if ($this->input->post('startDate') == "" || $this->input->post('endDate') == "") {
            $data['startDate'] = date('Y-m-d');
            $data['endDate'] = date('Y-m-d');
        } else {
            $data['startDate'] = $this->input->post('startDate');
            $data['endDate'] = $this->input->post('endDate');
        }

        $data['pendapatan'] = $this->db->get_where('accounts', ['type' => 'Pendapatan'])->result_array();
        $data['hpp'] = $this->db->get_where('accounts', ['type' => 'Harga Pokok Produksi'])->result_array();
        $data['biaya'] = $this->db->get_where('accounts', ['type' => 'Biaya'])->result_array();

        $data['title'] = 'Report / Profit Loss Statement';
        $this->load->view('include/header', $data);
        $this->load->view('report/profitloss', $data);
        $this->load->view('include/footer');
    }

    public function neraca()
    {
        if ($this->input->post('endDate') == "") {
            $data['endDate'] = date('Y-m-d');
        } else {
            $data['endDate'] = $this->input->post('endDate');
        }

        $data['startDate'] = date('Y-m-d', strtotime("Last day of last month", strtotime($data['endDate'])));

        $data['assets'] = $this->db->get_where('accounts', ['type' => 'Assets'])->result_array();
        $data['liabilities'] = $this->db->get_where('accounts', ['type' => 'Liabilities'])->result_array();
        $data['ekuitas'] = $this->db->get_where('accounts', ['type' => 'Ekuitas'])->result_array();

        $data['title'] = 'Report / Neraca (Balance Sheet)';
        $this->load->view('include/header', $data);
        $this->load->view('report/neraca', $data);
        $this->load->view('include/footer');
    }

    public function generalLedger()
    {
        // $kode_akun = $this->input->post('kode_akun');

        if ($this->input->post('startDate') == "" || $this->input->post('endDate') == "") {
            $kode_akun = '10100-001';
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        } else {
            $kode_akun = $this->input->post('kode_akun');
            $startDate = $this->input->post('startDate');
            $endDate = $this->input->post('endDate');
        }
        $acc_coa = $this->db->get_where('acc_coa', ['acc_code' => $kode_akun])->row_array();

        $data['dateAwal'] = date("Y-m-d", strtotime("-1 day", strtotime($startDate)));
        $dateAwal = date("Y-m-d", strtotime("-1 day", strtotime($startDate)));
        $data['saldo'] = $this->finance_model->endBalance($kode_akun, $acc_coa['status'], '0000-00-00', $dateAwal);
        $data['endBalance'] = $this->finance_model->endBalance($kode_akun, $acc_coa['status'], '0000-00-00', $endDate);
        $data['debt_total'] = $this->finance_model->totalDebetCredit($kode_akun, "Debt", $startDate, $endDate);
        $data['cred_total'] = $this->finance_model->totalDebetCredit($kode_akun, "Credit", $startDate, $endDate);


        $data['kode_akun'] = $kode_akun;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

        $data['coa'] = $this->db->order_by('acc_code', 'ASC')->get('acc_coa')->result_array();

        $data['accTrace'] = $this->db->query("SELECT a.*, b.acc_name as debtname, c.acc_name as credname, d.username
        FROM account_trace a
        LEFT JOIN acc_coa b ON b.acc_code = a.debt_code
        LEFT JOIN acc_coa c ON c.acc_code = a.cred_code
        LEFT JOIN user d ON d.id = a.user_id
        WHERE date(waktu) BETWEEN '$startDate' AND '$endDate' AND debt_code = '$kode_akun' and a.status = 1
        OR date(waktu) BETWEEN '$startDate' AND '$endDate' AND cred_code = '$kode_akun' and a.status = 1
        ORDER BY a.waktu")->result_array();

        $data['title'] = 'Report / Buku Besar (General Ledger)';
        $this->load->view('include/header', $data);
        $this->load->view('report/generalledger', $data);
        $this->load->view('include/footer');
    }

    public function cashflow()
    {
        if ($this->input->post('startDate') == "" || $this->input->post('endDate') == "") {
            $data['startDate'] = date('Y-m-d');
            $data['endDate'] = date('Y-m-d');
        } else {
            $data['startDate'] = $this->input->post('startDate');
            $data['endDate'] = $this->input->post('endDate');
        }

        $data['startDateInput'] = date('Y-m-d', strtotime("Yesterday", strtotime($data['startDate'])));

        $data['arusmasuk'] = $this->db->query("SELECT DISTINCT cred_code FROM account_trace WHERE cred_code NOT LIKE '10100%' AND cred_code NOT LIKE '10200%' AND debt_code LIKE '10100%' OR debt_code LIKE '10200%' AND status =1")->result_array();
        $data['aruskeluar'] = $this->db->query("SELECT DISTINCT debt_code FROM account_trace WHERE debt_code NOT LIKE '10100%' AND debt_code NOT LIKE '10200%' AND status =1")->result_array();
        $data['liabilities'] = $this->db->get_where('accounts', ['type' => 'Liabilities'])->result_array();
        $data['ekuitas'] = $this->db->get_where('accounts', ['type' => 'Ekuitas'])->result_array();

        $data['title'] = 'Report / Arus Kas (Cashflow)';
        $this->load->view('include/header', $data);
        $this->load->view('report/cashflow', $data);
        $this->load->view('include/footer');
    }
}
