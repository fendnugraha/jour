<h2>NERACA</h2>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>Total Asset</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-warehouse"></i> <b><?= number_format($this->finance_model->accountsCount('10%', 'D', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-warning text-bg-light">
            <div class="card-body">
                <p>Total Liabilities</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-file-invoice"></i> <b><?= number_format($this->finance_model->accountsCount('20%', 'C', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h2>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-success text-bg-dark">
            <div class="card-body">
                <p>Modal (Ekuitas)</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-vault"></i> <b><?= number_format($this->finance_model->accountsCount('30%', 'C', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h2>

            </div>
        </div>
    </div>
</div>
<h2>LABA RUGI</h2>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-warning text-bg-light">
            <div class="card-body">
                <p>Net Profit</p>
                <h5 class="d-flex justify-content-between"><i class="fa-solid fa-sack-dollar"></i> <b><?= number_format($this->finance_model->profitLossCount('0000-00-00', date('Y-m-d'))); ?> ,-</b></h5>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-success text-bg-dark">
            <div class="card-body">
                <p>Pendapatan</p>
                <h5 class="d-flex justify-content-between"><i class="fas fa-cash-register"></i> <b><?= number_format($this->finance_model->accountsCount('40%', 'C', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h5>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-info text-bg-dark">
            <div class="card-body">
                <p>HPP</p>
                <h5 class="d-flex justify-content-between"><i class="fa-solid fa-tag"></i> <b><?= number_format($this->finance_model->accountsCount('50%', 'D', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h5>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-danger text-bg-dark">
            <div class="card-body">
                <p>Pengeluaran</p>
                <h5 class="d-flex justify-content-between"><i class="fa-solid fa-credit-card"></i> <b><?= number_format($this->finance_model->accountsCount('60%', 'D', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h5>

            </div>
        </div>
    </div>
</div>
<h2>ARUS KAS</h2>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>KAS</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-wallet"></i> <b><?= number_format($this->finance_model->cashflowCount('0000-00-00', date('Y-m-d'))); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-warning text-bg-light">
            <div class="card-body">
                <p>Piutang</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-file-invoice"></i> <b><?= number_format($this->finance_model->accountsCount('10400%', 'D', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h2>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-success text-bg-dark">
            <div class="card-body">
                <p>Hutang</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-money-bills"></i> <b><?= number_format($this->finance_model->accountsCount('20100%', 'C', '0000-00-00', date('Y-m-d'))); ?> ,-</b></h2>

            </div>
        </div>
    </div>
</div>
<h2>INDICATOR KEUANGAN</h2>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-secondary text-bg-secondary">
            <div class="card-body">
                <p>Debt Ratio (Liabilities/Assets)</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-money-bills"></i> <b><?= round($this->finance_model->accountsCount('20%', 'C', '0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('10%', 'D', '0000-00-00', date('Y-m-d')) * 100, 2); ?> %</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bbg-secondary text-bg-secondary">
            <div class="card-body">
                <p>Current Ratio (Current Assets/Current Liabilities)</p>
                <h2 class="d-flex justify-content-between"><i class="fas fa-warehouse"></i> <b><?= $currentRatio; ?> %</b></h2>

            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-secondary text-bg-secondary">
            <div class="card-body">
                <p>Quick Ratio (Cash, AR/Current Liabilities)</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-cash-register"></i> <b><?= $quickRatio; ?> %</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bbg-secondary text-bg-secondary">
            <div class="card-body">
                <p>Debt to Equity Ratio (Current Liabilities/Total Equity)</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-money-bills"></i> <b><?= round($this->finance_model->accountsCount('20%', 'C', '0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('30%', 'C', '0000-00-00', date('Y-m-d')) * 100, 2); ?> %</b></h2>

            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-secondary text-bg-secondary">
            <div class="card-body">
                <p>Return on Equity Ratio (Net Profit/Total Equity)</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-vault"></i> <b><?= round($this->finance_model->profitLossCount('0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('30%', 'C', '0000-00-00', date('Y-m-d')) * 100, 2); ?> %</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bbg-secondary text-bg-secondary">
            <div class="card-body">
                <p>Net Profit Margin Ratio (Net Profit/Sales Revenue)</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-sack-dollar"></i> <b><?= round($this->finance_model->profitLossCount('0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('40%', 'C', '0000-00-00', date('Y-m-d')) * 100, 2); ?> %</b></h2>

            </div>
        </div>
    </div>
</div>