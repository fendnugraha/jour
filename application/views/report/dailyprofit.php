<form action="<?= base_url('report/profitLossStatementDaily/'); ?>" class="row mb-2" method="post">
    <div class="col-auto">
        <label for="startDate">Dari</label>
    </div>
    <div class="col-auto">
        <select class="form-control" name="bulan" id="bulan">
            <option value="">- Bulan -</option>
            <?php
            foreach ($tb_bulan as $c) {
            ?>
                <option value="<?= $c['nomor']; ?>" <?= set_select('bulan', $c['nomor']); ?>><?= $c['nomor']; ?> <?= $c['nama']; ?></option>
            <?php
            }; ?>
        </select>
    </div>
    <div class="col-auto">
        <select class="form-control" name="tahun" id="tahun">
            <option value="">- Tahun -</option>
            <?php
            for ($th = 2020; $th <= 2025; $th++) {
            ?>
                <option value="<?= $th; ?>" <?= set_select('tahun', $th); ?>><?= $th; ?></option>
            <?php
            }; ?>
        </select>
        <!-- <input type="text" name="endDate" id="endDate" class="form-control form-control-sm datepicker" value="<?= $endDate; ?>"> -->
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
    </div>
</form>
<div class="card overflow-auto" style="height: 80vh;">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <table class="table table-bordered">
                    <thead class="thead table-primary">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">Date</th>
                            <th>Sales (Pendapatan)</th>
                            <th rowspan="2" class="align-middle text-center">Profit</th>
                        </tr>
                        <tr>
                            <th>Cost (Harga Pokok Penjualan)</th>
                        </tr>
                    </thead>

                    <tbody class=" table-group-divider">
                        <?php
                        $days = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                        $tprofit = 0;
                        for ($x = 1; $x <= $days; $x++) {
                            $endDate = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . $x));
                            $profit = $this->finance_model->accountsCount('40100', 'K', $endDate, $endDate) - $this->finance_model->accountsCount('50100', 'D', $endDate, $endDate);
                            $tprofit += $profit;
                            $namabulan = $this->db->get_where('bulan', ['nomor' => $bulan])->row_array();
                        ?>
                            <tr>
                                <td rowspan=" 2" class="align-middle text-center"><span class="fw-bold" style="font-size:1.5rem;"><?= $x; ?></span><br><small><?= $namabulan['nama2'] . ' ' . $tahun; ?></small></td>
                                <td><?= number_format($this->finance_model->accountsCount('40100', 'K', $endDate, $endDate)); ?></td>
                                <td rowspan="2" class="align-middle text-end" style="font-size:1.5rem;"><?= number_format($profit); ?></td>
                            </tr>
                            <tr>
                                <td><?= number_format($this->finance_model->accountsCount('50100', 'D', $endDate, $endDate)); ?></td>
                            </tr>
                        <?php
                        }; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm">Gross Profit Total: <?= number_format($tprofit); ?></div>
        </div>
    </div>
</div>