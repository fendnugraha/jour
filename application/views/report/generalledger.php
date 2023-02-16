<div class="row mb-3">
    <div class="col-sm-6">
        <form class="" action="<?= base_url('report/generalLedger'); ?> " method="post">
            <div class="mb-3">
                <label for="kode_akun">Pilih Akun</label>
                <select name="kode_akun" id="kode_akun" class="form-control">
                    <!-- <option value="">- Chart of Account -</option> -->
                    <?php
                    foreach ($coa as $c) {
                    ?>
                        <option value="<?= $c['acc_code']; ?>" <?php if ($c['acc_code'] == $kode_akun) {
                                                                    echo 'selected';
                                                                }; ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
                    <?php }; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="startDate">Tanggal Awal</label>
                <input type="text" name="startDate" id="startDate" class="form-control datepicker" value="<?= $startDate; ?>">
            </div>
            <div class="mb-3">
                <label for="endDate">Tanggal Akhir</label>
                <input type="text" name="endDate" id="endDate" class="form-control datepicker" value="<?= $endDate; ?>">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary mb-3">Confirm</button>
            </div>
        </form>
    </div>
    <div class="col-sm-6 ">
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <p>SALDO AWAL: <?= number_format($saldo); ?></p>
        <table class="table display-noorder">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Invoice</th>
                    <th>Deskripsi</th>
                    <th>Akun</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($accTrace as $at) {
                    if ($at['debt_code'] == $kode_akun) {
                        $debt = $at['jumlah'];
                    } else {
                        $debt = 0;
                    }

                    if ($at['cred_code'] == $kode_akun) {
                        $cred = $at['jumlah'];
                    } else {
                        $cred = 0;
                    }
                    $saldo += $debt - $cred;
                ?>
                    <tr>
                        <td><?= $at['waktu']; ?></td>
                        <td><?= $at['invoice']; ?></td>
                        <td><?= $at['description']; ?></td>
                        <td><?= $at['debtname']; ?> x <?= $at['credname']; ?></td>
                        <td><?= number_format($debt); ?></td>
                        <td><?= number_format($cred); ?></td>
                        <td><?= number_format($saldo); ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>
</div>