<div class="card mb-3">
    <div class="card-body">
        <h2>Daily Profit</h2>
        <table class="table display">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pendapatan</th>
                    <th>Laba Rugi</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dailyprofit as $dp) { ?>
                    <tr>
                        <td><?= $dp['tanggal']; ?></td>
                        <td><?= number_format($dp['jual']); ?></td>
                        <td><?= number_format($dp['jual'] - $dp['modal']); ?></td>
                        <td><a href="#">Detail</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <h2>Monthly Profit</h2>
        <table class="table display">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pendapatan</th>
                    <th>Laba Rugi</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($monthlyprofit as $mp) { ?>
                    <tr>
                        <td><?= $mp['bulan'] . '-' . $mp['tahun']; ?></td>
                        <td><?= number_format($mp['jual']); ?></td>
                        <td><?= number_format($mp['jual'] - $mp['modal']); ?></td>
                        <td><a href="#">Detail</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <h2>Yearly Profit</h2>
        <table class="table display">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Pendapatan</th>
                    <th>Laba Rugi</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($yearlyprofit as $yp) { ?>
                    <tr>
                        <td><?= $yp['tanggal']; ?></td>
                        <td><?= number_format($yp['jual']); ?></td>
                        <td><?= number_format($yp['jual'] - $yp['modal']); ?></td>
                        <td><a href="#">Detail</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>