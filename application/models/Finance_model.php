<?php defined('BASEPATH') or exit('No direct script access allowed');

class Finance_model extends CI_Model
{
    public function invoice_journal()
    {
        $uname = $this->session->userdata('uname');
        $sql = "SELECT * FROM user WHERE username ='$uname'";
        // $data['tanggal'] = date('Y-m-d');
        $user = $this->db->query($sql)->row_array();
        $user_id = $user['id'];

        $querycode = "SELECT MAX(RIGHT(invoice,7)) AS kd_max FROM account_trace
                    WHERE user_id = '$user_id'";
        $q = $this->db->query($querycode);
        if ($q->num_rows() > 0) {
            $k = $q->row_array();
            $tmp = ((int) $k['kd_max']) + 1;
            return "JR.BK." . date('dmy') . "."  . $user["id"] . "."  . sprintf("%07s", $tmp);
        } else {
            return "JR.BK." . date('dmy') . "."  . $user["id"] . "."  . "0000001";
        }
    }

    public function invoice_receivable($contact_id)
    {
        $uname = $this->session->userdata('uname');
        $sql = "SELECT * FROM user WHERE username ='$uname'";
        // $data['tanggal'] = date('Y-m-d');
        $user = $this->db->query($sql)->row_array();

        $querycode = "SELECT MAX(RIGHT(invoice,7)) AS kd_max FROM receivable_tb
                    WHERE contact_id = '$contact_id' and pay_stats = 0";
        $q = $this->db->query($querycode);
        if ($q->num_rows() > 0) {
            $k = $q->row_array();
            $tmp = ((int) $k['kd_max']) + 1;
            return "RV.BK." . date('dmy') . "."  . $user["id"] . "." . $contact_id . "." . sprintf("%07s", $tmp);
        } else {
            return "RV.BK." . date('dmy') . "."  . $user["id"] . "." . $contact_id . "." . "0000001";
        }
    }

    public function invoice_payable($contact_id)
    {
        $uname = $this->session->userdata('uname');
        $sql = "SELECT * FROM user WHERE username ='$uname'";
        // $data['tanggal'] = date('Y-m-d');
        $user = $this->db->query($sql)->row_array();

        $querycode = "SELECT MAX(RIGHT(invoice,7)) AS kd_max FROM payable_tb
                    WHERE contact_id = '$contact_id' and pay_stats = 0";
        $q = $this->db->query($querycode);
        if ($q->num_rows() > 0) {
            $k = $q->row_array();
            $tmp = ((int) $k['kd_max']) + 1;
            return "PY.BK." . date('dmy') . "."  . $user["id"] . "." . $contact_id . "." . sprintf("%07s", $tmp);
        } else {
            return "PY.BK." . date('dmy') . "."  . $user["id"] . "." . $contact_id . "." . "0000001";
        }
    }

    public function endBalance($kode_akun, $type_akun, $startDate, $endDate)
    {
        $saldoAwal = $this->db->get_where('acc_coa', ['acc_code' => $kode_akun])->row_array();
        $saldoAwal = $saldoAwal['st_balance'];

        $total_debet = $this->db->query("SELECT sum(jumlah) as t_debet FROM account_trace WHERE debt_code = '$kode_akun' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        $total_credit = $this->db->query("SELECT sum(jumlah) as t_credit FROM account_trace WHERE cred_code = '$kode_akun' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        if ($type_akun == "D") {
            $endBalance = $saldoAwal + $total_debet['t_debet'] - $total_credit['t_credit'];
        } else {
            $endBalance = $saldoAwal - $total_debet['t_debet'] + $total_credit['t_credit'];
        }

        return $endBalance;
    }

    public function accountsCount($kode_akun, $type_akun, $startDate, $endDate)
    {
        $saldoAwal = $this->db->query("SELECT SUM(st_balance) as stb FROM acc_coa WHERE acc_code LIKE '$kode_akun%'")->row_array();
        $saldoAwal = $saldoAwal['stb'];

        $total_debet = $this->db->query("SELECT sum(jumlah) as t_debet FROM account_trace WHERE debt_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        $total_credit = $this->db->query("SELECT sum(jumlah) as t_credit FROM account_trace WHERE cred_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        if ($type_akun == "D") {
            $accountsCount = $saldoAwal + $total_debet['t_debet'] - $total_credit['t_credit'];
        } else {
            $accountsCount = $saldoAwal - $total_debet['t_debet'] + $total_credit['t_credit'];
        }

        return $accountsCount;
    }

    public function profitLossCount($startDate, $endDate)
    {
        $pendapatan = $this->db->query("SELECT SUM(jumlah) as inc FROM account_trace WHERE cred_code like '40%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();
        $hpp = $this->db->query("SELECT SUM(jumlah) as hpp FROM account_trace WHERE debt_code like '50%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();
        $biaya = $this->db->query("SELECT SUM(jumlah) as cost FROM account_trace WHERE debt_code like '60%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        $profitCount = $pendapatan['inc'] - $hpp['hpp'] - $biaya['cost'];
        $this->db->update('acc_coa', ['st_balance' => $profitCount], ['acc_code' => '30100-002']);

        return $profitCount;
    }

    public function modalCount($endDate)
    {
        $asset_awal = $this->db->query("SELECT SUM(st_balance) as asset_awal FROM acc_coa WHERE type = 'Assets'")->row_array();
        $asset_plus = $this->db->query("SELECT SUM(jumlah) as asset_plus FROM account_trace WHERE debt_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        $asset_minus = $this->db->query("SELECT SUM(jumlah) as asset_minus FROM account_trace WHERE cred_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_asset = $asset_awal['asset_awal'] + $asset_plus['asset_plus'] - $asset_minus['asset_minus'];

        $liabilities_awal = $this->db->query("SELECT SUM(st_balance) as liabilities_awal FROM acc_coa WHERE type = 'liabilities'")->row_array();
        $liabilities_plus = $this->db->query("SELECT SUM(jumlah) as liabilities_plus FROM account_trace WHERE debt_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        $liabilities_minus = $this->db->query("SELECT SUM(jumlah) as liabilities_minus FROM account_trace WHERE cred_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_liabilities = $liabilities_awal['liabilities_awal'] - $liabilities_plus['liabilities_plus'] + $liabilities_minus['liabilities_minus'];


        $equity_awal = $this->db->query("SELECT SUM(st_balance) as equity_awal FROM acc_coa WHERE type = 'Ekuitas' and acc_name <> 'Modal (Ekuitas)'")->row_array();
        $equity_plus = $this->db->query("SELECT SUM(jumlah) as equity_plus FROM account_trace WHERE debt_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        $equity_minus = $this->db->query("SELECT SUM(jumlah) as equity_minus FROM account_trace WHERE cred_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_equity = $equity_awal['equity_awal'] - $equity_plus['equity_plus'] + $equity_minus['equity_minus'];

        $modalCount = $total_asset - $total_liabilities - $total_equity;
        $this->db->update('acc_coa', ['st_balance' => $modalCount], ['acc_code' => '30100-001']);

        return $modalCount;
    }

    public function totalDebetCredit($kode_akun, $type, $startDate, $endDate)
    {
        if ($type == "Debt") {
            $debtCreditCount = $this->db->query("SELECT SUM(jumlah) as dc_total FROM account_trace 
        WHERE debt_code = '$kode_akun' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1")->row_array();
        } elseif ($type == "Credit") {
            $debtCreditCount = $this->db->query("SELECT SUM(jumlah) as dc_total FROM account_trace 
        WHERE cred_code = '$kode_akun' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1")->row_array();
        }

        $debtCreditCount = $debtCreditCount['dc_total'];
        return $debtCreditCount;
    }

    public function accountGrowthMontly($endDate, $kode_akun)
    {
        $dataacc = $this->db->get_where('accounts', ['kode' => $kode_akun])->row_array();
        $startDate = date('Y-m-d', strtotime("Last day of last month", strtotime($endDate)));

        // $startBalance = $this->accountsCount($kode_akun, $dataacc['status'], '0000-00-00', $startDate);
        // $endBalance = $this->accountsCount($kode_akun, $dataacc['status'], '0000-00-00', $endDate);

        $startBalance = $this->modalCount($startDate);
        $endBalance = $this->modalCount($endDate);

        if ($startBalance == 0) {
            $result = 0;
        } else {
            $result = (($endBalance - $startBalance) / $startBalance) * 100;
        }

        return $result;
    }
}
