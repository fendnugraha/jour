<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jour Apps - Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/jquery-ui.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/dataTables.bootstrap5.min.css" />
    <!-- <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/dataTables.jqueryui.min.css" /> -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/fontawesome.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/style.css" />
</head>

<body>
    <header class="p-3 mb-3 border-bottom" style="background-color: rgba(85, 110, 255, 0.1);">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="<?= base_url('home'); ?>" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none me-3">
                    <img src="<?= base_url('assets'); ?>/img/jour-logo.png" alt="logo" height="32" /> <strong class="text-secondary">&nbsp;X&nbsp;<?= $setting['brand_name']; ?></strong>
                    <!-- <img src="<?= base_url('assets'); ?>/img/logo.png" alt="logo" height="32" /> -->
                </a>

                <ul class="nav col-12 col-lg-auto ms-lg-auto mb-2 justify-content-center mb-md-0 me-5 font-weight-bold">
                    <li>
                        <a href="<?= base_url('home'); ?>" class="nav-link px-2 link-secondary">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url('finance/jurnal'); ?>" class="nav-link px-2 link-body-emphasis">Jurnal</a>
                    </li>
                    <li>
                        <a class="nav-link px-2 link-body-emphasis dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Finance
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('finance/payable'); ?>">Hutang</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('finance/receivable'); ?>">Piutang</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link px-2 link-body-emphasis dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Report
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('report/cashflow'); ?>">Cashflow</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('report/neraca'); ?>">Neraca Lajur</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('report/neracaMonthly'); ?>">Neraca Bulanan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('report/profitLossStatementDaily'); ?>">Daily Profit</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('report/profitLossStatement'); ?>">Laba Rugi</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('report/profitLossStatementMonthly'); ?>">Laba Rugi Bulanan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('report/generalLedger'); ?>">Buku Besar</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis" id="user-email-addr-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle" /> -->
                        <span id="user-email-addr"><i class="fa-solid fa-masks-theater"></i> <strong><?= strtolower($this->session->userdata('fullname')); ?></strong> <sup><i class="fa-solid fa-sort-down"></i></sup></span>

                    </a>
                    <ul class="dropdown-menu text-small dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= base_url('setting'); ?>">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>"><i class="fa-solid fa-power-off"></i> Sign out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="breadchrumb d-flex justify-content-between mb-3">
            <pspan><?= $title; ?></pspan>
            <span class="float-end">Role: <?= $this->session->userdata('role_name'); ?>. Warehouse: <?= $this->session->userdata('warehouse_name'); ?></span>
        </div>