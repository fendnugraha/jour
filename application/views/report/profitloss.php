<div class="card mb-3 text-bg-success">
    <div class="card-body d-flex justify-content-between">
        <h3 class="fw-bold">Net Profit</h3>
        <h3 class="fw-bold"><i class="fa-solid fa-sack-dollar text-warning"></i> <?= number_format($this->finance_model->profitLossCount($startDate, $endDate)); ?></h3>
    </div>
</div>
<form action="<?= base_url('report/profitLossStatement/'); ?>" class="row mb-2" method="post">
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
<div class="row">
    <div class="col-sm">
        <h4 class="fw-bold">Pendapatan (Income)</h4>
        <div class="card mb-3">
            <div class="card-body">
                <table class="table">
                    <?php
                    foreach ($pendapatan as $inc) {; ?>
                        <thead>
                            <tr class="table-primary">
                                <th>---</th>
                                <th colspan="3" class="text-primary"><?= $inc['nama']; ?></th>
                                <th class="text-primary text-end"><?= number_format($this->finance_model->accountsCount($inc['kode'], $inc['status'], $startDate, $endDate)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_code = $inc['kode'] . '%';
                            $acc_coa = $this->db->query("SELECT * FROM acc_coa WHERE acc_code LIKE '$acc_code'")->result_array();
                            foreach ($acc_coa as $c) {; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td><?= $c['acc_code']; ?></td>
                                    <td><?= $c['acc_name']; ?></td>
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], $startDate, $endDate)); ?></td>
                                </tr>
                            <?php }; ?>
                        <?php }; ?>
                        </tbody>
                </table>
            </div>
        </div>

        <h4 class="fw-bold">Harga Pokok Produksi</h4>
        <div class="card mb-3">
            <div class="card-body">
                <table class="table">
                    <?php
                    foreach ($hpp as $h) {; ?>
                        <thead>
                            <tr class="table-primary">
                                <th>---</th>
                                <th colspan="3" class="text-primary"><?= $h['nama']; ?></th>
                                <th class="text-primary text-end"><?= number_format($this->finance_model->accountsCount($h['kode'], $h['status'], $startDate, $endDate)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_code = $h['kode'] . '%';
                            $acc_coa = $this->db->query("SELECT * FROM acc_coa WHERE acc_code LIKE '$acc_code'")->result_array();
                            foreach ($acc_coa as $c) {; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td><?= $c['acc_code']; ?></td>
                                    <td><?= $c['acc_name']; ?></td>
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], $startDate, $endDate)); ?></td>
                                </tr>
                            <?php }; ?>
                        <?php }; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <h4 class="fw-bold">Biaya - Biaya (Expense)</h4>
        <div class="card mb-3">
            <div class="card-body">
                <table class="table">
                    <?php
                    foreach ($biaya as $ex) {; ?>
                        <thead>
                            <tr class="table-primary" <?php if ($this->finance_model->accountsCount($ex['kode'], $ex['status'], $startDate, $endDate) == 0) {
                                                            echo 'hidden';
                                                        }; ?>>
                                <th>---</th>
                                <th colspan="3" class="text-primary"><?= $ex['nama']; ?></th>
                                <th class="text-primary text-end"><?= number_format($this->finance_model->accountsCount($ex['kode'], $ex['status'], $startDate, $endDate)); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acc_code = $ex['kode'] . '%';
                            $acc_coa = $this->db->query("SELECT * FROM acc_coa WHERE acc_code LIKE '$acc_code'")->result_array();
                            foreach ($acc_coa as $c) {; ?>
                                <tr <?php if ($this->finance_model->endBalance($c['acc_code'], $c['status'], $startDate, $endDate) == 0) {
                                        echo 'hidden';
                                    }; ?>>
                                    <td colspan="2"></td>
                                    <td><?= $c['acc_code']; ?></td>
                                    <td><?= $c['acc_name']; ?></td>
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], $startDate, $endDate)); ?></td>
                                </tr>
                            <?php }; ?>
                        <?php }; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>