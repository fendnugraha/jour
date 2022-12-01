<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-edit-product col-sm">
                <form action="<?= base_url('home/edit_cashflow/' . $cashflow['id']); ?>" method="post">
                    <div class="mb-3 row">
                        <label for="cf_id" class="col-sm col-form-label">Trx ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="cf_id" id="cf_id" value="<?= $cashflow['id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="tanggal" id="tanggal" value="<?= $cashflow['waktu']; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row" <?php if ($cashflow['masuk'] == 0) {
                                                echo "hidden";
                                            }; ?>>
                        <label for="masuk" class="col-sm col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="masuk" id="masuk" value="<?= $cashflow['masuk']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row" <?php if ($cashflow['masuk'] > 0) {
                                                echo "hidden";
                                            }; ?>>
                        <label for="keluar" class="col-sm col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="keluar" id="keluar" value="<?= $cashflow['keluar']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="<?= $cashflow['deskripsi']; ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="status" class="col-sm col-form-label">Status</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="status" id="status">
                                <?php
                                foreach ($status as $s) {
                                ?>
                                    <option value="<?= $s['id']; ?>" <?php if ($cashflow['status'] == $s['id']) {
                                                                            echo "selected";
                                                                        }; ?>><?= $s['id'] . " - " . $s['status']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= base_url('home'); ?>">Kembali</a>
                    </div>
                </form>
            </div>
            <div class="col-sm">
                <?php echo validation_errors(); ?>
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>
    </div>
</div>