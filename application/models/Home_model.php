<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    public function invoice_so()
    {
        $uname = $this->session->userdata('uname');
        $sql = "SELECT * FROM user WHERE username ='$uname'";
        // $data['tanggal'] = date('Y-m-d');
        $user = $this->db->query($sql)->row_array();
        $user_id = $user['id'];

        $querycode = "SELECT MAX(RIGHT(invoice,7)) AS kd_max FROM product_trace
                    WHERE user_id = '$user_id' and sales > 0";
        $q = $this->db->query($querycode);
        if ($q->num_rows() > 0) {
            $k = $q->row_array();
            $tmp = ((int) $k['kd_max']) + 1;
            return "CI.BK." . date('dmy') . "."  . $user["id"] . "."  . sprintf("%07s", $tmp);
        } else {
            return "CI.BK." . date('dmy') . "."  . $user["id"] . "."  . "0000001";
        }
    }

    public function invoice_po()
    {
        $uname = $this->session->userdata('uname');
        $sql = "SELECT * FROM user WHERE username ='$uname'";
        // $data['tanggal'] = date('Y-m-d');
        $user = $this->db->query($sql)->row_array();
        $user_id = $user['id'];

        $querycode = "SELECT MAX(RIGHT(invoice,7)) AS kd_max FROM product_trace
                    WHERE user_id = '$user_id' and purchases > 0";
        $q = $this->db->query($querycode);
        if ($q->num_rows() > 0) {
            $k = $q->row_array();
            $tmp = ((int) $k['kd_max']) + 1;
            return "CO.BK." . date('dmy') . "."  . $user["id"] . "."  . sprintf("%07s", $tmp);
        } else {
            return "CO.BK." . date('dmy') . "."  . $user["id"] . "."  . "0000001";
        }
    }

    public function kasAkhir()
    {
        $kasawal = $this->db->get('setting')->row_array();
        $kasawal = $kasawal['kas_awal'];

        $selisihkas = $this->db->query("SELECT sum(masuk-keluar) as selisih FROM cashflow WHERE status = 1")->row_array();

        return $kasawal + $selisihkas['selisih'];
    }
}
