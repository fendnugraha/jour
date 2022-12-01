<?php defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_model extends CI_Model
{
    public function updateCost($p_id)
    {
        $total_cost = $this->db->query("SELECT sum(price*purchases) as cost, sum(purchases-sales) as stok from product_trace WHERE product_id = '$p_id' and status = 1")->row_array();

        return $total_cost['cost'] / $total_cost['stok'];
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
}
