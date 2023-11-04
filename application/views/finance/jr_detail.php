<?php
if ($account_trace['status'] == 1) {
    $status = "<span class='badge rounded-pill text-bg-success'>success</span>";
} elseif ($account_trace['status'] == 2) {
    $status = "<span class='badge rounded-pill text-bg-danger'>void</span>";
}; ?>

<h2>#<?= $account_trace['id']; ?></h2>
<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead class="thead">
                        <tr>
                            <td class="fw-bold text-primary">Waktu</td>
                            <td>: <?= $account_trace['waktu']; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">Invoice</td>
                            <td>: <?= $account_trace['invoice']; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">Descripsi</td>
                            <td>: <?= $account_trace['description']; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">Debet</td>
                            <td>: <?= $account_trace['debt_name']; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">Credit</td>
                            <td>: <?= $account_trace['cred_name']; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">Jumlah</td>
                            <td>: <sup>Rp</sup><?= number_format($account_trace['jumlah']); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">Status</td>
                            <td>: <?= $status; ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary">User Input</td>
                            <td>: <?= $account_trace['username']; ?></td>
                        </tr>
                    </thead>
                </table>
                <p><a href="<?= base_url('finance/jurnal'); ?>">Kembali</a></p>
            </div>

        </div>
    </div>
    <!-- <div class="col-sm">

    </div> -->
</div>