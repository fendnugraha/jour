<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-addproduct col-sm">
                <form action="<?= base_url('sales/edit_sales/' . $sales['id']); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="po_id" class="col-sm col-form-label">ID</label>
                        <div class="col-sm-3 me-auto">
                            <input type="text" class="form-control" name="po_id" id="po_id" value="<?= $sales['id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_date" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="p_date" id="p_date" value="<?= $sales['waktu']; ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_sup" class="col-sm col-form-label">Konsumen</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="p_sup" id="p_sup">
                                <option value="">- Pilih Supplier -</option>
                                <?php
                                foreach ($contact as $c) {
                                ?>
                                    <option value="<?= $c['id']; ?>" <?php if ($sales['contact_id'] == $c['id']) {
                                                                            echo "selected";
                                                                        }; ?>><?= $c['nama']; ?></option>
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
                                    <option value="<?= $p['id']; ?>" <?php if ($sales['product_id'] == $p['id']) {
                                                                            echo "selected";
                                                                        }; ?>><?= $p['nama'] . " - " . $p['kode']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_qty" class="col-sm col-form-label">Jumlah (Pcs)</label>
                        <div class="col-sm-3 me-auto">
                            <input type="number" class="form-control" name="p_qty" id="p_qty" value="<?= $sales['sales']; ?>" placeholder="Qty">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_price" class="col-sm col-form-label">Harga (Rp)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="p_price" id="p_price" value="<?= $sales['price']; ?>" placeholder="Harga">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_status" class="col-sm col-form-label">Status</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="p_status" id="p_status">
                                <?php
                                foreach ($status as $s) {
                                ?>
                                    <option value="<?= $s['id']; ?>" <?php if ($sales['status'] == $s['id']) {
                                                                            echo "selected";
                                                                        }; ?>><?= $s['id'] . " - " . $s['status']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-success">Update</button>
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