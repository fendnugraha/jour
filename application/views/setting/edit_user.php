<div class="card">
    <div class="card-body">
        <h1>Edit User</h1>
        <form action="<?= base_url('setting/edit_user/') . $usermng['id']; ?>" method="post" class="mb-3">
            <div class="mb-1 row">
                <label for="u_id" class="col-sm col-form-label">ID</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="u_id" id="u_id" value="<?= $usermng['id']; ?>" readonly>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="username" class="col-sm col-form-label">Username</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="username" id="username" value="<?= $usermng['username']; ?>" readonly>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="fullname" class="col-sm col-form-label">Full Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?= $usermng['fullname']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="password" class="col-sm col-form-label">Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="password" id="password" value="<?= $usermng['password']; ?>" readonly>
                    <small><a href="<?= base_url('setting/resetpassword/') . $usermng['id']; ?>">Reset Password</a></small>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="role" class="col-sm col-form-label">Role</label>
                <div class="col-sm-8">
                    <select name="role" class="form-control" id="role">
                        <?php
                        foreach ($user_role as $r) { ?>
                            <option value="<?= $r['id']; ?>" <?php if ($usermng['role'] == $r['id']) {
                                                                    echo "selected";
                                                                }; ?>><?= $r['role']; ?></option>
                        <?php }; ?>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn btn-primary" type="submit">Submit</button>
                <span><a href="<?= base_url('setting/usermng'); ?>">Kembali</a></span>

            </div>
        </form>

    </div>
    <?= $this->session->flashdata('message'); ?>
    <div>
        <?php echo validation_errors('<div class="alert alert-warning alert-dismissible fade show error" role="alert">', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'); ?>

    </div>
</div>