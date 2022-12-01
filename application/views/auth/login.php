<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App JOUR</title>
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap.css">
    <style>
        html,
        body,
        .container {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-form">
            <h1>APP JOUR by <strong class="text-danger">DNA Network</strong></h1>
            <form action="<?= base_url('auth'); ?>" method="post">
                <div class="row">
                    <div class="col-sm">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="col-sm">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-dark mt-1">Sign in</button>
                <?= $this->session->flashdata('message'); ?>
            </form>
            <a href="<?= base_url("auth/register"); ?> ">Daftar pengguna baru disini !</a>
        </div>

    </div>


    <script src="<?= base_url(); ?>/assets/js/bootstrap.js"></script>
</body>

</html>