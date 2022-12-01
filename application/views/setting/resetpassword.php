<div class="card">
    <div class="card-body">
        <form action="<?= base_url('setting/resetpassword/' . $dtuser['id']); ?>" method="post">
            <div class="mb-1 row">
                <label for="u_id" class="col-sm col-form-label">User ID</label>
                <div class="col-sm-8">
                    <input type="u_id" class="form-control" name="u_id" id="u_id" value="<?= $dtuser['id']; ?>" readonly>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="password" class="col-sm col-form-label">New Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="cpassword" class="col-sm col-form-label">Confirm New Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="cpassword" id="cpassword">
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn btn-primary" type="submit">Submit</button>
                <span><a href="<?= base_url('setting'); ?>">Kembali</a></span>

            </div>
        </form>
    </div>
</div>
<?php echo validation_errors('<div class="alert alert-warning alert-dismissible fade show error" role="alert">', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'); ?>