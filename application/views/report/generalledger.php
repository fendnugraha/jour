<div class="card bg-dark text-bg-dark mb-1 p-0">
    <div class="card-body pb-0">
        <div class="account-balance-info d-flex justify-content-evenly mb-2">
            <div class="account-info">
                <span class="badge text-bg-primary">Saldo Awal</span>
                <h4 class="fw-bold">Rp. <?= number_format($saldo); ?></h4>
            </div>
            <div class="account-info">
                <span class="badge text-bg-success">Total Debet</span>
                <h4 class="fw-bold">Rp. <?= number_format($debt_total); ?></h4>
            </div>
            <div class="account-info">
                <span class="badge text-bg-danger">Total Credit</span>
                <h4 class="fw-bold">Rp. <?= number_format($cred_total); ?></h4>
            </div>
            <div class="account-info">
                <span class="badge text-bg-warning">Saldo Akhir</span>
                <h4 class="fw-bold">Rp. <?= number_format($endBalance); ?></h4>
            </div>
        </div>

    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <form class="mb-1" action="<?= base_url('report/generalLedger'); ?> " method="post">
            <div class="row">
                <div class="col-sm-7">
                    <label for="kode_akun" class="">Pilih Akun</label>
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
                <div class="col-sm">
                    <label for="startDate">Tanggal Awal</label>
                    <input type="text" name="startDate" id="startDate" class="form-control datepicker" value="<?= $startDate; ?>">
                </div>
                <div class="col-sm">
                    <label for="endDate">Tanggal Akhir</label>
                    <input type="text" name="endDate" id="endDate" class="form-control datepicker" value="<?= $endDate; ?>">
                </div>
            </div>
            <div class="mt-1">
                <button type="submit" class="btn btn-primary mb-3">Confirm</button>
            </div>
        </form>

        <table class="table display-noorder">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Invoice</th>
                    <th>Deskripsi</th>
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
                        <td><?= $at['description']; ?><br>
                            <span class="badge text-bg-warning"><?= $at['username']; ?></span>
                            <span class="badge text-bg-secondary mt-2"><?= $at['debtname']; ?> x <?= $at['credname']; ?></span>
                        </td>
                        <td><?= number_format($debt); ?></td>
                        <td><?= number_format($cred); ?></td>
                        <td><?= number_format($saldo); ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>
</div>