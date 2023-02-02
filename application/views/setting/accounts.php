<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm">
                <div class="control-nav mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccounts">
                        + Tambah Account
                    </button>
                </div>
                <table class="table display">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Saldo Awal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($acc_coa as $coa) {; ?>
                            <tr>
                                <!-- <td><?= $coa['id']; ?></td> -->
                                <td><?= $coa['acc_code']; ?></td>
                                <td><?= $coa['acc_name']; ?></td>
                                <td><?= $coa['main_acc']; ?></td>
                                <td><?= $coa['status']; ?></td>
                                <td><?= $coa['type']; ?></td>
                                <td class="text-end"><?= number_format($coa['st_balance']); ?></td>
                                <td class="text-center"><a href="<?= base_url('setting/editAccount/') . $coa['acc_code']; ?>">Edit</a></td>
                            </tr>
                        <?php }; ?>
                    </tbody>
                </table>
                <a href="<?= base_url('setting'); ?>">Kembali</a>
            </div>

        </div>
    </div>
</div>
<?= $this->session->flashdata('message'); ?>



<!-- Modal -->
<div class="modal fade" id="addAccounts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('setting/accounts'); ?>" method="post">
                    <div class="mb-3 row">
                        <label for="acc_name" class="col-sm col-form-label">Nama Account</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="acc_name" id="acc_name" value="<?= set_value('acc_name'); ?>">
                            <div class="form-text">Maksimal 60 Karakter</div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="main_acc" class="col-sm col-form-label">Type</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="main_acc" id="main_acc">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($accounts as $acc) {; ?>
                                    <option value="<?= $acc['nama']; ?>"><?= $acc['nama'] . " - " . $acc['kode']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="st_balance" class="col-sm col-form-label">Saldo Awal</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="st_balance" id="st_balance" value="<?= set_value('st_balance'); ?>">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                <?php echo validation_errors('<div class="alert alert-warning alert-dismissible fade show error" role="alert">', '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'); ?>
            </div>
        </div>
        </form>
    </div>
</div>