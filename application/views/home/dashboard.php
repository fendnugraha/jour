<!-- Main Content -->
<div class="row">
    <div class="col-sm-8">

        <div class="row mb-5 mt-3">
            <div class="col-sm">
                <div class="card card-dashboard-neraca text-light">
                    <div class="card-body">
                        <h5 style="font-weight: 700;">Assets</h5>
                        <i class="fa-solid fa-vault"></i> <span class="float-end"><sup>Rp</sup> <?= number_format($this->finance_model->accountsCount('10%', 'D', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="col-sm">
                    <div class="card card-dashboard-neraca text-light">
                        <div class="card-body">
                            <h5 style="font-weight: 700;">Liabilities</h5>
                            <span><i class="fa-solid fa-file-invoice"></i></span><span class="float-end"><sup>Rp</sup>
                                <?= number_format($this->finance_model->accountsCount('20%', 'C', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="col-sm">
                    <div class="card card-dashboard-neraca text-light">
                        <div class="card-body">
                            <h5 style="font-weight: 700;">Equity</h5>
                            <span><i class="fa-solid fa-briefcase"></i></span><span class="float-end"><sup>Rp</sup> <?= number_format($this->finance_model->accountsCount('30%', 'C', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4>Arus Kas</h4>
        <div class="dashboard mb-5">
            <div class="card card-kas">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h1 class="mb-3"><i class="fa-solid fa-wallet"></i></h1>
                    <h2><sup>Rp</sup>
                        <?= number_format($this->finance_model->cashflowCount('0000-00-00', date('Y-m-d'))); ?>,-</h2>
                    <span>Cash & Bank</span>
                </div>
            </div>
            <div class="card card-piutang">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Piutang</h5>
                    <span><i class="fa-solid fa-file-invoice-dollar"></i></span><span class="float-end"><sup>Rp</sup>
                        <?= number_format($this->finance_model->accountsCount('10400%', 'D', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                </div>
            </div>
            <div class="card card-hutang">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Hutang</h5>
                    <span><i class="fa-solid fa-credit-card"></i></span><span class="float-end"><sup>Rp</sup>
                        <?= number_format($this->finance_model->accountsCount('20100%', 'C', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                </div>
            </div>
        </div>


        <h4>Profit Loss</h4>
        <div class="dashboard-profitloss mb-5">
            <div class="card card-revenue text-light">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Revenue</h5>
                    <h2><i class="fa-solid fa-cash-register"></i></h2><span class="float-end"><sup>Rp</sup>
                        <?= number_format($this->finance_model->accountsCount('40%', 'C', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                </div>
            </div>
            <div class="card card-cost-of-sales text-light">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Cost of sales</h5>
                    <h2><i class="fa-solid fa-money-bills"></i></h2><span class="float-end"><sup>Rp</sup>
                        <?= number_format($this->finance_model->accountsCount('50%', 'D', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                </div>
            </div>
            <div class="card card-profit-loss">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Net Profit</h5>
                    <h2><i class="fa-solid fa-sack-dollar"></i></h2><span class="float-end"><sup>Rp</sup>
                        <?= number_format($this->finance_model->profitLossCount('0000-00-00', date('Y-m-d'))); ?>,-</span>
                </div>
            </div>
            <div class="card card-expense text-light">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Expenses</h5>
                    <h2><i class="fa-solid fa-tags"></i></h2><span class="float-end"><sup>Rp</sup>
                        <?= number_format($this->finance_model->accountsCount('60%', 'D', '0000-00-00', date('Y-m-d'))); ?>,-</span>
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm">
        <div class="card-dashboard-right">
            <h4>Financial Indicator</h4>
            <div class="card-finance-indicator mt-3 mt-2">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-file-invoice"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Debt Ratio</h5>
                    <span><sup class="text-success"><i class="fa-solid fa-circle-up"></i></sup>
                        <?= round($this->finance_model->accountsCount('20%', 'C', '0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('10%', 'D', '0000-00-00', date('Y-m-d')) * 100, 2); ?>%</span>
                </div>
            </div>
            <div class="card-finance-indicator mt-3 mt-2">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-coins"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Current Ratio</h5>
                    <span><sup class="text-success"><i class="fa-solid fa-circle-up"></i></sup>
                        <?= $currentRatio; ?>%</span>
                </div>
            </div>
            <div class="card-finance-indicator mt-3 mt-2">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-money-bills"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Quick Ratio</h5>
                    <span><sup class="text-success"><i class="fa-solid fa-circle-up"></i></sup>
                        <?= $quickRatio; ?>%</span>
                </div>
            </div>
            <div class="card-finance-indicator mt-3 mt-2">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-money-check-dollar"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Debt to Equity Ratio</h5>
                    <span><sup class="text-success"><i class="fa-solid fa-circle-up"></i></sup>
                        <?= round($this->finance_model->accountsCount('20%', 'C', '0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('30%', 'C', '0000-00-00', date('Y-m-d')) * 100, 2); ?>%</span>
                </div>
            </div>
            <div class="card-finance-indicator mt-3 mt-2">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-regular fa-gem"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Return on Equity Ratio</h5>
                    <span><sup class="text-success"><i class="fa-solid fa-circle-up"></i></sup>
                        <?= round($this->finance_model->profitLossCount('0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('30%', 'C', '0000-00-00', date('Y-m-d')) * 100, 2); ?>%</span>
                </div>
            </div>
            <div class="card-finance-indicator mt-3 mt-2">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-sack-dollar"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Net Profit Margin Ratio</h5>
                    <span><sup class="text-success"><i class="fa-solid fa-circle-up"></i></sup>
                        <?= round($this->finance_model->profitLossCount('0000-00-00', date('Y-m-d')) / $this->finance_model->accountsCount('40%', 'C', '0000-00-00', date('Y-m-d')) * 100, 2); ?>%</span>
                </div>
            </div>

            <!-- <div class="card mt-5">
            <div class="card-body">
              <h3 class="text-center" style="font-weight: 1000;">Your company is healthy</h3>
            </div>
          </div> -->
        </div>


    </div>
</div>

</div>
<!-- End Main Content -->