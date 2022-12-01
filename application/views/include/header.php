<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App POS</title>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/datatables.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/fontawesome.min.css">
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.jqueryui.min.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/mycss.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><?= $this->session->userdata('brand-name'); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('home'); ?> ">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transaksi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('purchase'); ?>">Pembelian</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('sales'); ?>">Penjualan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('report'); ?>">Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('setting'); ?>">Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning active" href="#">Sign as <strong><?= $this->session->userdata('fullname'); ?></strong></a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <a class="nav-link text-light text-username" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>

    </nav>
    <div class="container mt-3">
        <div class="card card-page-title">
            <p><?= $title; ?></p>
        </div>
    </div>
    <div class="container mt-3">