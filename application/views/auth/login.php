<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/bootstrap.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        * {
            font-family: "Quicksand", sans-serif;
        }

        html,
        body,
        .container {
            height: 100vh;
        }

        body {
            background: rgb(255, 255, 255);
            background: linear-gradient(180deg, rgba(255, 255, 255, 1) 70%, rgba(255, 147, 45, 1) 95%, rgba(245, 81, 81, 1) 100%);
        }

        a {
            text-decoration: none;
            color: blue;
        }

        a:hover {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="login-form">
            <h4><img src="<?= base_url() . 'assets/img/jour-logo.png'; ?>" height="64rem"> Apps <sup>by</sup> <img src="<?= base_url() . 'assets/img/logo-long.png'; ?>" height="64rem"> &trade;</h4>
            <form action="<?= base_url('auth'); ?>" method="post">
                <div class="row">
                    <div class="col-sm">
                        <label for="username" class="form-label"><i class="fa-solid fa-face-smile"></i> Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="col-sm">
                        <label for="password" class="form-label"><i class="fa-solid fa-key"></i> Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-dark mt-1">Sign in</button>
                <?= $this->session->flashdata('message'); ?>
            </form>
            <p class="mt-2">Need an account? <a href="<?= base_url("auth/register"); ?> ">Click here!</a></p>
        </div>

    </div>


    <script src="<?= base_url(); ?>/assets/js/bootstrap.js"></script>
</body>

</html>