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

    public function labarugi()
    {
        $data['dailyprofit'] = $this->db->query("SELECT date(waktu) as tanggal, sum(sales*cost) as modal, sum(sales*price) as jual FROM product_trace Where status = 1 group by date(waktu) ")->result_array();
        $data['monthlyprofit'] = $this->db->query("SELECT month(waktu) as bulan, year(waktu) as tahun, sum(sales*cost) as modal, sum(sales*price) as jual FROM product_trace Where status = 1 group by month(waktu), year(waktu) ")->result_array();
        $data['yearlyprofit'] = $this->db->query("SELECT year(waktu) as tanggal, sum(sales*cost) as modal, sum(sales*price) as jual FROM product_trace Where status = 1 group by year(waktu) ")->result_array();

        $data['title'] = 'Report / Laba Rugi';
        $this->load->view('include/header', $data);
        $this->load->view('report/labarugi', $data);
        $this->load->view('include/footer');
    }

    public function neraca()
    {
        $data['assets'] = $this->db->get_where('accounts', ['type' => 'Assets'])->result_array();
        $data['liabilities'] = $this->db->get_where('accounts', ['type' => 'Liabilities'])->result_array();
        $data['ekuitas'] = $this->db->get_where('accounts', ['type' => 'Ekuitas'])->result_array();

        $data['title'] = 'Report / Neraca (Balance Sheet)';
        $this->load->view('include/header', $data);
        $this->load->view('report/neraca', $data);
        $this->load->view('include/footer');
    }
}
