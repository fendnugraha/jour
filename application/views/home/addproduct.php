<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-addproduct col-sm">
                <form action="<?= base_url('home/addProduct'); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_name" class="col-sm col-form-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_name" id="p_name" value="<?= set_value('p_name'); ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_code" class="col-sm col-form-label">Kode Produk</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_code" id="p_code" value="<?= set_value('p_code'); ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_cat" class="col-sm col-form-label">Kategori Produk</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="p_cat" id="p_cat">
                                <option value="">- Pilih kategori -</option>
                                <?php
                                foreach ($cat_product as $cat) {
                                ?>
                                    <option value="<?= $cat['id']; ?>" <?= set_select('p_cat', $cat['id']); ?>><?= $cat['category']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_cost" class="col-sm col-form-label">Harga Beli</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="p_cost" id="p_cost" value="<?= set_value('p_cost'); ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_sale" class="col-sm col-form-label">Harga Jual</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="p_sale" id="p_sale" value="<?= set_value('p_sale'); ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?= base_url('home'); ?>">Kembali</a>
                    </div>
                </form>
            </div>
            <div class="info-addproduct col-sm">
                <?php echo validation_errors(); ?>
            </div>
        </div>
    </div>
</div>