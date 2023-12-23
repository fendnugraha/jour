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
        $hariini = date('Y-m-d');

        $querycode = "SELECT MAX(RIGHT(invoice,7)) AS kd_max FROM account_trace
                    WHERE user_id = '$user_id' and date(waktu) = '$hariini'";
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

        $total_debet = $this->db->query(
            "SELECT (select sum(jumlah) FROM account_trace WHERE debt_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as t_debet,
            (select sum(jumlah) FROM account_trace WHERE cred_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as t_credit"
        )->row_array();

        if ($type_akun == "D") {
            $endBalance = $saldoAwal + $total_debet['t_debet'] - $total_debet['t_credit'];
        } else {
            $endBalance = $saldoAwal - $total_debet['t_debet'] + $total_debet['t_credit'];
        }

        return $endBalance;
    }

    public function accountsCount($kode_akun, $type_akun, $startDate, $endDate)
    {
        $saldoAwal = $this->db->query("SELECT SUM(st_balance) as stb FROM acc_coa WHERE acc_code LIKE '$kode_akun%'")->row_array();
        $saldoAwal = $saldoAwal['stb'];

        $total_debet = $this->db->query(
            "SELECT (select sum(jumlah) FROM account_trace WHERE debt_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as t_debet,
            (select sum(jumlah) FROM account_trace WHERE cred_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as t_credit"
        )->row_array();

        // $total_credit = $this->db->query("SELECT sum(jumlah) as t_credit FROM account_trace WHERE cred_code LIKE '$kode_akun%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        if ($type_akun == "D") {
            $accountsCount = $saldoAwal + $total_debet['t_debet'] - $total_debet['t_credit'];
        } else {
            $accountsCount = $saldoAwal - $total_debet['t_debet'] + $total_debet['t_credit'];
        }

        return $accountsCount;
    }

    public function profitLossCount($startDate, $endDate)
    {
        $acc_trace = $this->db->query("SELECT
        (SELECT SUM(jumlah) FROM account_trace WHERE cred_code like '40%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as inc,
        (SELECT SUM(jumlah) FROM account_trace WHERE debt_code like '50%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as hpp,
        (SELECT SUM(jumlah) FROM account_trace WHERE debt_code like '60%' and date(waktu) between '$startDate' and '$endDate' and status = 1) as cost
        ")->row_array();
        // $hpp = $this->db->query("SELECT SUM(jumlah) as hpp FROM account_trace WHERE debt_code like '50%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();
        // $biaya = $this->db->query("SELECT SUM(jumlah) as cost FROM account_trace WHERE debt_code like '60%' and date(waktu) between '$startDate' and '$endDate' and status = 1")->row_array();

        $profitCount = $acc_trace['inc'] - $acc_trace['hpp'] - $acc_trace['cost'];
        $this->db->update('acc_coa', ['st_balance' => $profitCount], ['acc_code' => '30100-002']);

        return $profitCount;
    }

    public function modalCount($endDate)
    {
        $saldo_awal = $this->db->query("SELECT
        (SELECT SUM(st_balance) FROM acc_coa WHERE type = 'Assets') as asset_awal,
        (SELECT SUM(st_balance) FROM acc_coa WHERE type = 'liabilities') as liabilities_awal,
        (SELECT SUM(st_balance) FROM acc_coa WHERE type = 'Ekuitas' and acc_name <> 'Modal (Ekuitas)') as equity_awal")->row_array();

        $acc_trace = $this->db->query(
            "SELECT
        (SELECT SUM(jumlah) FROM account_trace WHERE debt_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as asset_plus, 
        (SELECT SUM(jumlah) FROM account_trace WHERE cred_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as asset_minus,
        (SELECT SUM(jumlah) FROM account_trace WHERE debt_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as liabilities_plus,
        (SELECT SUM(jumlah) FROM account_trace WHERE cred_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as liabilities_minus,
        (SELECT SUM(jumlah) FROM account_trace WHERE debt_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as equity_plus,
        (SELECT SUM(jumlah) FROM account_trace WHERE cred_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as equity_minus

    "
        )->row_array();

        // $asset_awal = $this->db->query("SELECT SUM(st_balance) as asset_awal FROM acc_coa WHERE type = 'Assets'")->row_array();
        // $asset_plus = $this->db->query("SELECT SUM(jumlah) as asset_plus FROM account_trace WHERE debt_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        // $asset_minus = $this->db->query("SELECT SUM(jumlah) as asset_minus FROM account_trace WHERE cred_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_asset = $saldo_awal['asset_awal'] + $acc_trace['asset_plus'] - $acc_trace['asset_minus'];

        // $liabilities_awal = $this->db->query("SELECT SUM(st_balance) as liabilities_awal FROM acc_coa WHERE type = 'liabilities'")->row_array();
        // $liabilities_plus = $this->db->query("SELECT SUM(jumlah) as liabilities_plus FROM account_trace WHERE debt_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        // $liabilities_minus = $this->db->query("SELECT SUM(jumlah) as liabilities_minus FROM account_trace WHERE cred_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_liabilities = $saldo_awal['liabilities_awal'] - $acc_trace['liabilities_plus'] + $acc_trace['liabilities_minus'];


        // $equity_awal = $this->db->query("SELECT SUM(st_balance) as equity_awal FROM acc_coa WHERE type = 'Ekuitas' and acc_name <> 'Modal (Ekuitas)'")->row_array();
        // $equity_plus = $this->db->query("SELECT SUM(jumlah) as equity_plus FROM account_trace WHERE debt_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        // $equity_minus = $this->db->query("SELECT SUM(jumlah) as equity_minus FROM account_trace WHERE cred_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_equity = $saldo_awal['equity_awal'] - $acc_trace['equity_plus'] + $acc_trace['equity_minus'];

        $modalCount = $total_asset - $total_liabilities - $total_equity;
        $this->db->update('acc_coa', ['st_balance' => $modalCount], ['acc_code' => '30100-001']);

        return $modalCount;
    }

    public function modalCountNo($endDate)
    {
        $saldo_awal = $this->db->query("SELECT
        (SELECT SUM(st_balance) FROM acc_coa WHERE type = 'Assets') as asset_awal,
        (SELECT SUM(st_balance) FROM acc_coa WHERE type = 'liabilities') as liabilities_awal")->row_array();
        // $liabilities_awal = $this->db->query("SELECT SUM(st_balance) as liabilities_awal FROM acc_coa WHERE type = 'liabilities'")->row_array();

        $acc_trace = $this->db->query(
            "SELECT
            (SELECT SUM(jumlah) FROM account_trace WHERE debt_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as asset_plus, 
            (SELECT SUM(jumlah) FROM account_trace WHERE cred_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as asset_minus,
            (SELECT SUM(jumlah) FROM account_trace WHERE debt_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as liabilities_plus,
            (SELECT SUM(jumlah) FROM account_trace WHERE cred_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1) as liabilities_minus
            "
        )->row_array();
        // $asset_minus = $this->db->query("SELECT SUM(jumlah) as asset_minus FROM account_trace WHERE cred_code LIKE '1%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();


        // $liabilities_plus = $this->db->query("SELECT SUM(jumlah) as liabilities_plus FROM account_trace WHERE debt_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        // $liabilities_minus = $this->db->query("SELECT SUM(jumlah) as liabilities_minus FROM account_trace WHERE cred_code LIKE '2%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        $total_asset = $saldo_awal['asset_awal'] + $acc_trace['asset_plus'] - $acc_trace['asset_minus'];
        $total_liabilities = $saldo_awal['liabilities_awal'] - $acc_trace['liabilities_plus'] + $acc_trace['liabilities_minus'];


        // $equity_awal = $this->db->query("SELECT SUM(st_balance) as equity_awal FROM acc_coa WHERE type = 'Ekuitas' and acc_name <> 'Modal (Ekuitas)'")->row_array();
        // $equity_plus = $this->db->query("SELECT SUM(jumlah) as equity_plus FROM account_trace WHERE debt_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();
        // $equity_minus = $this->db->query("SELECT SUM(jumlah) as equity_minus FROM account_trace WHERE cred_code LIKE '30100%' and date(waktu) between '0000-00-00' and '$endDate' and status = 1 ")->row_array();

        // $total_equity = $equity_plus['equity_plus'] + $equity_minus['equity_minus'];
        // $total_equity = $equity_awal['equity_awal'] - $equity_plus['equity_plus'] + $equity_minus['equity_minus'];

        $modalCount = $total_asset - $total_liabilities;

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

    public function accountGrowthMontly($endDate)
    {
        $startDate = date('Y-m-d', strtotime("Last day of last month", strtotime($endDate)));
        $endDate = date('Y-m-d', strtotime($endDate));

        // $startDatePL = date('Y-m-d', strtotime("First day of last month", strtotime($endDate)));
        // $endDatePL = date('Y-m-d', strtotime("Last day of last month", strtotime($endDate)));

        // $startDatePLend = date('Y-m-d', strtotime("First day of the month", strtotime($endDate)));
        // $endDatePLend = date('Y-m-d', strtotime("Last day of the month", strtotime($endDate)));

        // $startBalance = $this->accountsCount($kode_akun, $dataacc['status'], '0000-00-00', $startDate);
        // $endBalance = $this->accountsCount($kode_akun, $dataacc['status'], '0000-00-00', $endDate);

        $startBalance = $this->modalCountNo($startDate);
        $endBalance = $this->modalCountNo($endDate);
        // $startBalance = $this->accountsCount('30100', 'K', '0000-00-00', $startDate);
        // $endBalance = $this->modalCountNo($endDate);

        // if ($startBalance == 0) {
        //     $result = 0;
        // } else {
        //     $result = ($endBalance);
        // }
        if ($startBalance == 0) {
            $result = 0;
        } else {
            if (($endBalance - $startBalance) / $startBalance * 100 > 0) {
                $status = '<i class="fa-solid fa-circle-up"></i>';
            } else {
                $status = '<i class="fa-solid fa-circle-down text-danger"></i>';
            }
            $result = $status . " " . round(($endBalance - $startBalance) / $startBalance * 100, 2);
        }

        return $result;
    }

    public function cashflowCount($startDate, $endDate)
    {
        $saldoAwal = $this->db->query("SELECT SUM(st_balance) as stb FROM acc_coa WHERE acc_code LIKE '10100%' OR acc_code LIKE '10200%' ")->row_array();
        $saldoAwal = $saldoAwal['stb'];

        $acc_trace = $this->db->query("SELECT
         (SELECT SUM(jumlah) FROM account_trace 
        WHERE debt_code LIKE '10100%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 OR debt_code LIKE '10200%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1) as debtCount,
        (SELECT SUM(jumlah) FROM account_trace 
        WHERE cred_code LIKE '10100%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 OR cred_code LIKE '10200%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1) as credCount
        ")->row_array();

        // $creditCount = $this->db->query("SELECT SUM(jumlah) as dc_total FROM account_trace 
        // WHERE cred_code LIKE '10100%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 OR cred_code LIKE '10200%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1")->row_array();

        $result = $saldoAwal + $acc_trace['debtCount'] - $acc_trace['credCount'];

        return $result;
    }

    public function totalDebetCreditCashflowCount($kode_akun, $startDate, $endDate)
    {
        $total = $this->db->query("SELECT
        (SELECT sum(jumlah) FROM account_trace WHERE 
        debt_code LIKE '10100%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 AND cred_code LIKE '$kode_akun'
        OR
        debt_code LIKE '10200%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 AND cred_code LIKE '$kode_akun') as msk,
        (SELECT sum(jumlah) FROM account_trace WHERE 
        cred_code LIKE '10100%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 AND debt_code LIKE '$kode_akun'
        OR
        cred_code LIKE '10200%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 AND debt_code LIKE '$kode_akun') as klr
        ")->row_array();;

        // $aruskaskeluar = $this->db->query("SELECT sum(jumlah) as klr FROM account_trace WHERE 
        // cred_code LIKE '10100%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 AND debt_code LIKE '$kode_akun'
        // OR
        // cred_code LIKE '10200%' AND date(waktu) BETWEEN '$startDate' AND '$endDate' AND status =1 AND debt_code LIKE '$kode_akun'")->row_array();;

        $result = $total['msk'] - $total['klr'];

        return $result;
    }
}
