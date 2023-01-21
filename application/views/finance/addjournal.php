<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-addproduct col-sm">
                <form action="<?= base_url('finance/addJournal'); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_date" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="p_date" id="p_date" value="<?= date('Y-m-d H:i'); ?>">
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
                                    <option value="<?= $c['acc_code']; ?>" <?= set_select('acc_debet', $c['acc_code']); ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
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
                                    <option value="<?= $c['acc_code']; ?>" <?= set_select('acc_credit', $c['acc_code']); ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="description" class="col-sm col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="jumlah" class="col-sm col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="jumlah" id="jumlah" value="<?= set_value('jumlah'); ?>" placeholder="Jumlah">
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