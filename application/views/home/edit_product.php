<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-edit-product col-sm">
                <form action="<?= base_url('home/edit_product/' . $product['id']); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_id" class="col-sm col-form-label">ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_id" id="p_id" value="<?= $product['id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_name" class="col-sm col-form-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_name" id="p_name" value="<?= $product['nama']; ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_code" class="col-sm col-form-label">Kode Produk</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_code" id="p_code" value="<?= $product['kode']; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_code" class="col-sm col-form-label">Kode Produk</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="p_cat" id="p_cat">
                                <option value="">- Pilih kategori -</option>
                                <?php
                                foreach ($cat_product as $cat) {
                                ?>
                                    <option value="<?= $cat['id']; ?>" <?php if ($product['cat_id'] == $cat['id']) {
                                                                            echo "selected";
                                                                        }; ?>><?= $cat['category']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_cost" class="col-sm col-form-label">Harga Beli</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_cost" id="p_cost" value="<?= $product['beli']; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_sale" class="col-sm col-form-label">Harga Jual</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_sale" id="p_sale" value="<?= $product['jual']; ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="p_stock" class="col-sm col-form-label">Sisa Stok</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="p_stock" id="p_stock" value="<?= $product['stok']; ?>" readonly>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="<?= base_url('home'); ?>">Kembali</a>
                    </div>
                </form>
            </div>
            <div class="col-sm">

            </div>
        </div>
    </div>
</div>