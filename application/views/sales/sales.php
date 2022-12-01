<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-addproduct col-sm">
                <form action="<?= base_url('sales/addSales'); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_date" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="p_date" id="p_date" value="<?= date('Y-m-d H:i'); ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_sup" class="col-sm col-form-label">Konsumen</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="p_sup" id="p_sup">
                                <option value="">- Pilih Konsumen -</option>
                                <?php
                                foreach ($contact as $c) {
                                ?>
                                    <option value="<?= $c['id']; ?>" <?= set_select('p_sup', $c['id']); ?>><?= $c['nama']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_id" class="col-sm col-form-label">Produk</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="p_id" id="p_id">
                                <option value="">- Pilih product -</option>
                                <?php
                                foreach ($product as $p) {
                                ?>
                                    <option value="<?= $p['id']; ?>" <?= set_select('p_id', $p['id']); ?>><?= $p['nama'] . " - " . $p['kode']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_qty" class="col-sm col-form-label">Jumlah (Pcs)</label>
                        <div class="col-sm-3 me-auto">
                            <input type="number" class="form-control" name="p_qty" id="p_qty" value="<?= set_value('p_qty'); ?>" placeholder="Qty">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_price" class="col-sm col-form-label">Harga (Rp)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="p_price" id="p_price" value="<?= set_value('p_price'); ?>" placeholder="Harga">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?= base_url('sales'); ?>">Kembali</a>
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