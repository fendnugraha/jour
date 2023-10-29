<h2>Neraca Bulanan</h2>
<div class="card">
    <div class="card-body overflow-auto">
        <table class="table">
            <thead class="thead">
                <tr>
                    <th>Daftar Akun</th>
                    <?php
                    foreach ($bulan as $b) {
                        $tahun = $this->session->userdata('periode');
                    ?>
                        <th><?= date('M Y', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))); ?></th>
                    <?php }; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="13">Assets</th>
                </tr>
                <?php
                foreach ($assets as $a) {; ?>
                    <tr>
                        <td><?= $a['kode'] . ' - ' . $a['nama']; ?></td>
                        <?php
                        foreach ($bulan as $b) {
                            // $this->finance_model->profitLossCount('0000-00-00', date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                            // $this->finance_model->modalCount(date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))));
                        ?>
                            <td><?= number_format($this->finance_model->accountsCount($a['kode'], $a['status'], '0000-00-00', date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))))); ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>
                <tr>
                    <th colspan="13">Liabilities</th>
                </tr>
                <?php
                foreach ($liabilities as $l) {; ?>
                    <tr>
                        <td><?= $l['kode'] . ' - ' . $l['nama']; ?></td>
                        <?php
                        foreach ($bulan as $b) {

                        ?>
                            <td><?= number_format($this->finance_model->accountsCount($l['kode'], $l['status'], '0000-00-00', date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15'))))); ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>
                <tr>
                    <th colspan="13">Ekuitas</th>
                </tr>
                <?php
                foreach ($ekuitas as $e) {; ?>
                    <tr>
                        <td><?= $e['kode'] . ' - ' . $e['nama']; ?></td>
                        <?php
                        foreach ($bulan as $b) {
                            $tahun = $this->session->userdata('periode');
                            $startDate = date('Y-m-d', strtotime("First day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                            $endDate = date('Y-m-d', strtotime("Last day of this month", strtotime($tahun . '-' . $b['nomor'] . '-15')));
                        ?>
                            <td><?= number_format($this->finance_model->modalCountNo($endDate)); ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>

            </tbody>
        </table>
    </div>
</div>