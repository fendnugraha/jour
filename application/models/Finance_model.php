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
}
