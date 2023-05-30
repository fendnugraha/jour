<form action="<?= base_url('report/neraca/'); ?>" method="post" class="row g-3 mb-3">
    <label for="endDate" class="col-sm-auto">Pilih Tanggal</label>
    <div class="col-sm-auto">
        <input type="text" name="endDate" id="endDate" class="form-control datepicker" placeholder="<?= $endDate; ?>">
    </div>
    <div class="col-sm-auto">
        <button type="submit" class="btn btn-success">Proses</button>
    </div>
</form>
<!-- <?= round($this->finance_model->accountGrowthMontly($endDate, '30100-001'), 2) . "%"; ?> -->
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ASSETS</h4>
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
                            $this->finance_model->profitLossCount('0000-00-00', $endDate);
                            $this->finance_model->modalCount($endDate);
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
    <div class="col-sm">
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">LIABILITIES</h4>
                <table class="table">
                    <?php
                    foreach ($liabilities as $lb) {; ?>
                        <thead>
                            <tr class="table-primary">
                                <th>---</th>
                                <th colspan="3" class="text-primary"><?= $lb['nama']; ?></th>
                                <th class="text-primary text-end"><?= number_format($this->finance_model->accountsCount($lb['kode'], $lb['status'], '0000-00-00', $endDate)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_code = $lb['kode'] . '%';
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
        <div class="card text-bg-info">
            <div class="card-body">
                <h4 class="card-title">EKUITAS</h4>
                <table class="table table-warning">
                    <?php
                    foreach ($ekuitas as $eq) {; ?>
                        <thead>
                            <tr class="table-primary">
                                <th>---</th>
                                <th colspan="3" class="text-primary"><?= $eq['nama']; ?></th>
                                <th class="text-primary text-end"><?= number_format($this->finance_model->accountsCount($eq['kode'], $eq['status'], '0000-00-00', $endDate)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_code = $eq['kode'] . '%';
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
        <div class="card mt-2 bg-success text-bg-dark">
            <div class="card-body">
                <span class="badge text-bg-warning">Equity Growth Rate</span>
                <h1 class="text-end fw-bold"><?= round($this->finance_model->accountGrowthMontly($endDate, '30100'), 2) . " %"; ?></h1>
            </div>
        </div>
    </div>
</div>