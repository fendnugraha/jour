<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-addproduct col-sm-7">
                <form action="<?= base_url('finance/editjournal/' . $journal['id']); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_date" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="p_date" id="p_date" value="<?= $journal['waktu']; ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="acc_debet" class="col-sm col-form-label">Debet</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="acc_debet" id="acc_debet">
                                <option value="">- Pilih Akun Debet -</option>
                                <?php
                                foreach ($accounts as $c) {
                                ?>
                                    <option value="<?= $c['acc_code']; ?>" <?php if ($journal['debt_code'] == $c['acc_code']) {
                                                                                echo "selected";
                                                                            }; ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="acc_credit" class="col-sm col-form-label">Credit</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="acc_credit" id="acc_credit">
                                <option value="">- Pilih Akun Credit -</option>
                                <?php
                                foreach ($accounts as $c) {
                                ?>
                                    <option value="<?= $c['acc_code']; ?>" <?php if ($journal['cred_code'] == $c['acc_code']) {
                                                                                echo "selected";
                                                                            }; ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="description" class="col-sm col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5">
                                <?= $journal['description']; ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="jumlah" class="col-sm col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="jumlah" id="jumlah" value="<?= $journal['jumlah']; ?>" placeholder="Jumlah">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="status" class="col-sm col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status">
                                <?php
                                foreach ($status as $s) {
                                ?>
                                    <option value="<?= $s['id']; ?>" <?php if ($journal['status'] == $s['id']) {
                                                                            echo "selected";
                                                                        }; ?>><?= $s['id']; ?> | <?= $s['status']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?= base_url('finance/jurnal'); ?>">Kembali</a>
                    </div>
                </form>
            </div>
            <div class="info-addproduct col-sm">
                <?php echo validation_errors(); ?>
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>
    </div>
</div>