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
}
