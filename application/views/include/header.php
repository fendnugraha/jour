<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App JOUR</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url(); ?>assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= base_url(); ?>assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.css">
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/datatables.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/fontawesome.min.css">
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.jqueryui.min.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/mycss.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><?= $this->session->userdata('brand-name'); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('home'); ?> "><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="# ">Dashboard</a>
                    </li> -->
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transaksi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('purchase'); ?>">Pembelian</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('sales'); ?>">Penjualan</a></li>
                        </ul>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('finance/jurnal'); ?>"><i class="fa-solid fa-book"></i> Jurnal</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-money-bill-transfer"></i> Hutang Piutang
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('finance/payable'); ?>">Hutang</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('finance/receivable'); ?>">Piutang</a></li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('report'); ?>">Report</a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-clipboard-list"></i> Report
                        </a>
                        <ul class="dropdown-menu">
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('setting'); ?>"><i class="fa-solid fa-screwdriver-wrench"></i> Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning active" href="#"><i class="fa-solid fa-masks-theater"></i> <strong><?= $this->session->userdata('fullname'); ?></strong></a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <a class="nav-link text-light text-username" href="<?= base_url('auth/logout'); ?>"><i class="fa-solid fa-power-off"></i></a>
            </div>
        </div>

    </nav>
    <div class="container mt-0">
        <div class="card card-page-title">
            <p><?= $title; ?></p>
        </div>
    </div>
    <div class="container mt-3">