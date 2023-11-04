<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-addproduct col-sm-8">
                <form action="<?= base_url('sales/addSalesValues'); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_date" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="p_date" id="p_date" value="<?= date('Y-m-d H:i'); ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="cash_account" class="col-sm col-form-label">Kas</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="cash_account" id="cash_account">
                                <option value="">- Pilih Akun Kas -</option>
                                <?php
                                foreach ($accounts as $c) {
                                ?>
                                    <option value="<?= $c['acc_code']; ?>" <?= set_select('cash_account', $c['acc_code']); ?>><?= $c['acc_name']; ?> | <?= $c['acc_code']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="sales" class="col-sm col-form-label">Sales (Penjualan Barang)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="sales" id="sales" value="<?= set_value('sales'); ?>" placeholder="Sales">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="cost" class="col-sm col-form-label">Cost (HPP)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="cost" id="cost" value="<?= set_value('cost'); ?>" placeholder="Cost">
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