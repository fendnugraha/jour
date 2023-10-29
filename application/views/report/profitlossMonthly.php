<h2>Laba Rugi Bulanan</h2>
<div class="card">
    <div class="card-body overflow-auto">
        <table class="table">
            <thead class="thead">
                <tr>
                    <th></th>
                    <?php
                    foreach ($bulan as $b) {
                        $tahun = $this->session->userdata('periode');
                        $startDate = date('Y-m-d', strtotime("First day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                        $endDate = date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                    ?>
                        <th><?= date('M Y', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))); ?></th>
                    <?php }; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="13">Pendapatan (Income)</th>
                </tr>
                <?php
                foreach ($pendapatan as $a) {; ?>
                    <tr>
                        <td><?= $a['kode'] . ' - ' . $a['nama']; ?></td>
                        <?php
                        foreach ($bulan as $b) {
                            $tahun = $this->session->userdata('periode');
                            $startDate = date('Y-m-d', strtotime("First day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            $endDate = date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            // $this->finance_model->profitLossCount('0000-00-00', date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                            // $this->finance_model->modalCount(date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                        ?>
                            <td><?= number_format($this->finance_model->accountsCount($a['kode'], $a['status'], $startDate, $endDate)); ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>
                <tr>
                    <td colspan="13"></td>
                </tr>
                <tr>
                    <th colspan="13">Harga Pokok Penjualan (HPP)</th>
                </tr>
                <?php
                foreach ($hpp as $a) {; ?>
                    <tr>
                        <td><?= $a['kode'] . ' - ' . $a['nama']; ?></td>
                        <?php
                        foreach ($bulan as $b) {
                            $tahun = $this->session->userdata('periode');
                            $startDate = date('Y-m-d', strtotime("First day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            $endDate = date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            // $this->finance_model->profitLossCount('0000-00-00', date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                            // $this->finance_model->modalCount(date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                        ?>
                            <td><?= number_format($this->finance_model->accountsCount($a['kode'], $a['status'], $startDate, $endDate)); ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>
                <tr>
                    <td colspan="13"></td>
                </tr>
                <tr>
                    <th colspan="13">Biaya - Biaya (Expense)</th>
                </tr>
                <?php
                foreach ($biaya as $a) {; ?>
                    <tr>
                        <td><?= $a['kode'] . ' - ' . $a['nama']; ?></td>
                        <?php
                        foreach ($bulan as $b) {
                            $tahun = $this->session->userdata('periode');
                            $startDate = date('Y-m-d', strtotime("First day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            $endDate = date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            // $this->finance_model->profitLossCount('0000-00-00', date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                            // $this->finance_model->modalCount(date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                        ?>
                            <td><?= number_format($this->finance_model->accountsCount($a['kode'], $a['status'], $startDate, $endDate)); ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>
            </tbody>
            <tfoot class="tfoot">
                <tr>
                    <th>Net Profit</th>
                    <?php
                    foreach ($bulan as $b) {
                        $tahun = $this->session->userdata('periode');
                        $startDate = date('Y-m-d', strtotime("First day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                        $endDate = date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                    ?>
                        <th><?= number_format($this->finance_model->profitLossCount($startDate, $endDate)); ?></th>
                    <?php }; ?>
                </tr>
            </tfoot>
        </table>
    </div>