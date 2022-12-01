<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm">
                <div class="control-nav mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContact">
                        + Tambah User
                    </button>
                </div>
                <table class="table display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th>Terdaftar Sejak</th>
                            <th>Aktivitas Terakhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usermng as $usr) {; ?>
                            <tr>
                                <td><?= $usr['id']; ?></td>
                                <td><?= $usr['username']; ?></td>
                                <td><?= $usr['fullname']; ?></td>
                                <td><?= $usr['role']; ?></td>
                                <td><?= date('Y-m-d H:m:s', $usr['date_reg']); ?></td>
                                <td><?= date('Y-m-d H:m:s', $usr['last_login']); ?></td>
                                <td>
                                    <a href="<?= base_url('setting/edit_user/') . $usr['id']; ?>">Edit</a>
                                    <a href="<?= base_url('setting/userdetail/') . $usr['id']; ?>">Detail</a>
                                </td>
                            </tr>
                        <?php }; ?>
                    </tbody>
                </table>

                <a href="<?= base_url('setting'); ?>">Kembali</a>
            </div>

        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('setting/usermng'); ?>" method="post" class="mb-3">
                    <div class="mb-1 row">
                        <label for="username" class="col-sm col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="username" id="username" value="<?= set_value('username'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="fullname" class="col-sm col-form-label">Full Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?= set_value('fullname'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="password" class="col-sm col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="password" value="<?= set_value('password'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="cpassword" class="col-sm col-form-label">Confirm Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="cpassword" id="cpassword" value="<?= set_value('cpassword'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="role" class="col-sm col-form-label">Role</label>
                        <div class="col-sm-8">
                            <select name="role" class="form-control" id="role">
                                <option value="1">Administrator</option>
                                <option value="2">Kasir</option>
                                <option value="3">Staff</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
            </form>
        </div>