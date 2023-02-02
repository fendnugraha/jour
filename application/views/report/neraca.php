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
                                <th colspan="4" class="text-primary"><?= $as['nama']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->finance_model->profitLossCount(date('Y-m-d'));
                            $this->finance_model->modalCount(date('Y-m-d'));
                            $acc_code = $as['kode'] . '%';
                            $acc_coa = $this->db->query("SELECT * FROM acc_coa WHERE acc_code LIKE '$acc_code'")->result_array();
                            foreach ($acc_coa as $c) {; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td><?= $c['acc_code']; ?></td>
                                    <td><?= $c['acc_name']; ?></td>
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], date('Y-m-d'))); ?></td>
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
                                <th colspan="4" class="text-primary"><?= $lb['nama']; ?></th>
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
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], date('Y-m-d'))); ?></td>
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
                                <th colspan="4" class="text-primary"><?= $eq['nama']; ?></th>
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
                                    <td class="text-end"><?= number_format($this->finance_model->endBalance($c['acc_code'], $c['status'], date('Y-m-d'))); ?></td>
                                </tr>
                            <?php }; ?>
                        <?php }; ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>