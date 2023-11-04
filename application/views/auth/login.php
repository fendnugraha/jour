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

        body {
            background: rgb(255, 255, 255);
            background: linear-gradient(180deg, rgba(255, 255, 255, 1) 70%, rgba(255, 147, 45, 1) 95%, rgba(245, 81, 81, 1) 100%);
        }

        a {
            text-decoration: none;
            color: black;
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
            <p class="mt-2">Need an account? <a href="<?= base_url("auth/register"); ?> ">Click here!</a></p>
        </div>

    </div>


    <script src="<?= base_url(); ?>/assets/js/bootstrap.js"></script>
</body>

</html>