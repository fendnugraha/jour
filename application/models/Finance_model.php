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

    public function endBalance($kode_akun, $type_akun, $tanggal)
    {
        $saldoAwal = $this->db->get_where('acc_coa', ['acc_code' => $kode_akun])->row_array();
        $saldoAwal = $saldoAwal['st_balance'];

        $total_debet = $this->db->query("SELECT sum(jumlah) as t_debet FROM account_trace WHERE debt_code = '$kode_akun' and date(waktu) between '0000-00-00' and '$tanggal'")->row_array();

        $total_credit = $this->db->query("SELECT sum(jumlah) as t_credit FROM account_trace WHERE cred_code = '$kode_akun' and date(waktu) between '0000-00-00' and '$tanggal'")->row_array();

        if ($type_akun == "D") {
            $endBalance = $saldoAwal + $total_debet['t_debet'] - $total_credit['t_credit'];
        } else {
            $endBalance = $saldoAwal - $total_debet['t_debet'] + $total_credit['t_credit'];
        }

        return $endBalance;
    }
}
