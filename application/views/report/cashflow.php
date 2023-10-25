<form action="<?= base_url('report/cashflow/'); ?>" method="post" class="row g-3 mb-3">
    <label for="endDate" class="col-sm-auto">Pilih Tanggal</label>
    <div class="col-sm-auto">
        <input type="text" name="endDate" id="endDate" class="form-control datepicker" placeholder="<?= $endDate; ?>">
    </div>
    <div class="col-sm-auto">
        <button type="submit" class="btn btn-success">Proses</button>
    </div>
</form>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr class="bg-primary text-light">
                    <th>SALDO AWAL KAS</th>
                    <th><?= number_format($this->finance_model->cashflowCount('0000-00-00', $startDate)); ?></th>
                </tr>
                <tr>
                    <td class=" bg-secondary text-light"><strong>Arus Kas Masuk</strong></td>
                </tr>
                <?php
                foreach ($arusmasuk as $ms) {;
                    $accname = $this->db->get_where('acc_coa', ['acc_code' => $ms['cred_code']])->row_array();
                ?>

                    <tr>
                        <td><?= $ms['cred_code'] . " - " . $accname['acc_name']; ?></td>
                        <td><?= number_format($this->finance_model->totalDebetCredit($ms['cred_code'], 'Credit', $startDate, $endDate)); ?></td>
                    </tr>
                <?php }; ?>
                <tr>
                <tr>
                    <td class="bg-secondary text-light"><strong>Arus Kas Keluar</strong></td>
                </tr>
                <?php
                foreach ($aruskeluar as $kl) {;
                    $accname = $this->db->get_where('acc_coa', ['acc_code' => $kl['debt_code']])->row_array();
                ?>

                    <tr>
                        <td><?= $kl['debt_code'] . " - " . $accname['acc_name']; ?></td>
                        <td><?= number_format($this->finance_model->totalDebetCredit($kl['debt_code'], 'Debt', $startDate, $endDate)); ?></td>
                    </tr>
                <?php }; ?>
                <tr class="bg-primary text-light">
                    <th>SALDO AKHIR KAS</th>
                    <th><?= number_format($this->finance_model->cashflowCount('0000-00-00',  $endDate)); ?></th>
                </tr>
            </thead>
        </table>
    </div>
</div>