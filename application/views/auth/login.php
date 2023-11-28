<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jour Apps</title>
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/fontawesome.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/style.css" />
    <style>
        body {
            background-color: rgb(255, 255, 255);
        }
    </style>
</head>

<body>
    <div class="container">
        <?= $this->session->flashdata('message'); ?>
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-lg-5">
                <div class="card pt-3 pb-3" style="background-color: rgba(0, 0, 0, 0.3); border-radius: 15px">
                    <div class="card-body">
                        <div class="text-center mb-3 text-light">
                            <img src="<?= base_url('assets'); ?>/img/jour-logo.png" alt="logo" srcset="" height="80" />
                            <sup>&trade;</sup><strong>Accounting</strong>
                            <p class="mt-3 fs-6">Sign in to your account.</p>
                        </div>
                        <form action="<?= base_url('auth'); ?>" method="post">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" autofocus />
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" />
                                <label for="password">Password</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-secondary mt-3 d-inline-block">
                                    <i class="fa-solid fa-right-to-bracket"></i> Sign in
                                </button>
                                <span class="text-light">Need an account?
                                    <strong class="text-warning">Click Here !</strong></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar fixed-bottom">
        <div class="container">
            <p class="ms-auto me-auto">
                Jour by
                <img src="<?= base_url('assets'); ?>/img/logo.png" alt="logo" srcset="" height="25" />
                Copyright &copy; 2023. All right reserved.
            </p>
        </div>
    </nav>
    <script src="<?= base_url('assets'); ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/jquery-3.7.0.js"></script>
    <script src="<?= base_url('assets'); ?>/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/jquery-ui.js"></script>
    <script src="<?= base_url('assets'); ?>/js/fontawesome.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/all.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/myjs.js"></script>
</body>

</html>