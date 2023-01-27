<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="5">ASSETS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($assets as $as) {; ?>
                    <tr>
                        <td>---</td>
                        <td colspan="4"><?= $as['nama']; ?></td>
                    </tr>
                    <?php
                    $acc_code = $as['kode'] . '%';
                    $acc_coa = $this->db->query("SELECT * FROM acc_coa WHERE acc_code LIKE '$acc_code'")->result_array();
                    foreach ($acc_coa as $c) {; ?>
                        <tr>
                            <td colspan="2"></td>
                            <td><?= $c['acc_code']; ?></td>
                            <td><?= $c['acc_name']; ?></td>
                            <td class="text-end"><?= number_format($c['st_balance']); ?></td>
                        </tr>
                    <?php }; ?>
                <?php }; ?>
            </tbody>
        </table>
    </div>
</div>