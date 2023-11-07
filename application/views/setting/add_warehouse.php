<div class="card">
    <div class="card-body">
        <div class="control-nav mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarehouse">
                + Tambah Gudang
            </button>
        </div>
        <table class="table display">
            <thead>
                <tr>
                    <th>Warehouse ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Cash ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($warehouse as $w) {
                ?>
                    <tr>
                        <td><?= $w['id']; ?></td>
                        <td><?= $w['warehouse_code']; ?></td>
                        <td><?= $w['warehouse_name']; ?></td>
                        <td><?= $w['address']; ?></td>
                        <td><?= $w['cash_id']; ?></td>
                        <td><i class="fa-solid fa-list-check"></i></td>

                    </tr>
                <?php }; ?>
            </tbody>
        </table>
        <?php echo validation_errors(); ?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addWarehouse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Gudang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('setting/addWarehouse'); ?>" method="post">
                    <div class="mb-1 row">
                        <label for="warehouse_name" class="col-sm col-form-label">Nama Gudang</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="warehouse_name" id="warehouse_name" value="<?= set_value('warehouse_name'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="warehouse_code" class="col-sm col-form-label">Kode Gudang</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="warehouse_code" id="warehouse_code" value="<?= set_value('warehouse_code'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="address" class="col-sm col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" name="address" id="address" value="<?= set_value('address'); ?>">
                            </textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="cash_id" class="col-sm col-form-label">Cash Account</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="cash_id" id="cash_id">
                                <option value="">- Pilih Akun Kas -</option>
                                <?php
                                foreach ($accounts as $c) {
                                ?>
                                    <option value="<?= $c['acc_code']; ?>" <?= set_select('cash_id', $c['acc_code']); ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </form>
    </div>
</div>