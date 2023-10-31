<form action="<?= base_url('finance/cashTotal/'); ?>" method="post" class="row g-3 mb-3">
    <label for="endDate" class="col-sm-auto">Pilih Tanggal</label>
    <div class="col-sm-auto">
        <input type="text" name="endDate" id="endDate" class="form-control datepicker" placeholder="<?= $endDate; ?>">
    </div>
    <div class="col-sm-auto">
        <button type="submit" class="btn btn-success">Proses</button>
    </div>
</form>

<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">TOTAL KAS & BANK</h4>
                <table class="table">
                    <?php
                    foreach ($assets as $as) {; ?>
                        <thead>
                            <tr class="table-primary">
                                <th>---</th>
                                <th colspan="3" class="text-primary"><?= $as['nama']; ?></th>
                                <th class="text-primary text-end"><?= number_format($this->finance_model->accountsCount($as['kode'], $as['status'], '0000-00-00', $endDate)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_code = $as['kode'] . '%';
                            $acc_coa = $this->db->query("SELECT * FROM acc_coa WHERE acc_code LIKE '$acc_code'")->result_array();
                            foreach ($acc_coa as $c) {; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td><?= $c['acc_code']; ?></td>
                                    <td><?= $c['acc_name']; ?></td>
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], '0000-00-00', $endDate)); ?></td>
                                </tr>
                            <?php }; ?>
                        <?php }; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>