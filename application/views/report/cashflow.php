<?php
$cfpercent = round(($this->finance_model->cashflowCount('0000-00-00', $endDate) - $this->finance_model->cashflowCount('0000-00-00', $startDateInput)) / $this->finance_model->cashflowCount('0000-00-00', $startDateInput) * 100, 2);

if ($cfpercent > 0) {
    $updown = '<i class="fa-solid fa-up-long text-success"></i>';
} else {
    $updown = '<i class="fa-solid fa-down-long text-danger"></i>';
}
?>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>Kenaikan Penurunan Kas</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-briefcase"></i> <b><?= $updown . " " . number_format($this->finance_model->cashflowCount('0000-00-00', $endDate) - $this->finance_model->cashflowCount('0000-00-00', $startDateInput)); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-warning text-bg-light">
            <div class="card-body">

                <p>Persentase Kenaikan Penurunan Kas</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-chart-line"></i> <b><?= $updown . " " . $cfpercent; ?> %</b></h2>

            </div>
        </div>
    </div>
</div>

<form action="<?= base_url('report/cashflow/'); ?>" method="post" class="row g-3 mb-3">
    <div class="col-auto">
        <label for="startDate">Dari</label>
    </div>
    <div class="col-auto">
        <input type="text" name="startDate" id="startDate" class="form-control form-control-sm datepicker" value="<?= $startDate; ?>">
    </div>
    <div class="col-auto">
        <label for="endDate">Sampai</label>
    </div>
    <div class="col-auto">
        <input type="text" name="endDate" id="endDate" class="form-control form-control-sm datepicker" value="<?= $endDate; ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
    </div>
</form>
<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <td class=" bg-secondary text-light" colspan="3"><strong>Arus Kas Dari Aktivitas Operasional</strong></td>
            </tr>
            <!-- <?php
                    foreach ($arusmasuk as $ms) {;
                        $accname = $this->db->get_where('acc_coa', ['acc_code' => $ms['cred_code']])->row_array();
                    ?>

                <tr>
                    <td><?= $ms['cred_code'] . " - " . $accname['acc_name']; ?></td>
                    <td><i class="fa-solid fa-rupiah-sign"></i></td>
                    <td><?= number_format($this->finance_model->totalDebetCredit($ms['cred_code'], 'Credit', $startDate, $endDate)); ?></td>
                </tr>
            <?php }; ?> -->

            <tr>
                <td>Penerimaan dari Customer</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('40100%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Pembelanjaan Stok Barang</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('10600%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Piutang Usaha</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('10400%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Piutang Lainnya</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('10500%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Hutang Usaha</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('20%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td class="bg-secondary text-light" colspan="3"><strong>Pengeluaran & Biaya Operasional</strong></td>
            </tr>
            <!-- <?php
                    foreach ($aruskeluar as $kl) {;
                        $accname = $this->db->get_where('acc_coa', ['acc_code' => $kl['debt_code']])->row_array();
                    ?>

                <tr>
                    <td><?= $kl['debt_code'] . " - " . $accname['acc_name']; ?></td>
                    <td><i class="fa-solid fa-rupiah-sign"></i></td>
                    <td><?= number_format($this->finance_model->totalDebetCredit($kl['debt_code'], 'Debt', $startDate, $endDate)); ?></td>
                </tr>
            <?php }; ?> -->
            <tr>
                <td>Beban Gaji Langsung</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('60101%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Beban Bahan Pendukung Usaha</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('60105%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Beban Pemeliharaan Dan Perbaikan Aset Tetap</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('60109%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Beban Lain-Lain</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('60110%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td>Beban Lain-Lain Corporate</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('60113%', $startDate, $endDate)); ?></td>
            </tr>
            <tr>
                <td class="bg-secondary text-light" colspan="3"><strong>Arus Kas Dari Aktivitas Pendanaan</strong></td>
            </tr>
            <tr>
                <td>Modal (Equity)</td>
                <td><i class="fa-solid fa-rupiah-sign"></i></td>
                <td><?= number_format($this->finance_model->totalDebetCreditCashflowCount('30100%', $startDate, $endDate)); ?></td>
            </tr>

            <tr class="table-primary text-light">
                <th>SALDO AWAL KAS</th>
                <th><i class="fa-solid fa-rupiah-sign"></i></th>
                <th><?= number_format($this->finance_model->cashflowCount('0000-00-00', $startDateInput)); ?></th>
            </tr>
            <tr class="table-warning text-dark">
                <th>SALDO AKHIR KAS</th>
                <th><i class="fa-solid fa-rupiah-sign"></i></th>
                <th><?= number_format($this->finance_model->cashflowCount('0000-00-00', $endDate)); ?></th>
            </tr>
        </table>
    </div>
</div>