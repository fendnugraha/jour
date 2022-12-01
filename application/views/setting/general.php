<div class="card">
    <div class="card-body">
        <form action="<?= base_url('setting/general'); ?>" method="post">
            <div class="mb-2 row">
                <label for="brand-name" class="col-sm col-form-label">Brand Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="brand-name" id="brand-name" value="<?= $general['brand_name']; ?>">
                </div>
            </div>
            <div class="mb-2 row">
                <label for="slogan" class="col-sm col-form-label">Slogan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="slogan" id="slogan" value="<?= $general['slogan']; ?>">
                </div>
            </div>
            <div class="mb-2 row">
                <label for="address" class="col-sm col-form-label">Alamat</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="address" id="address" value="<?= $general['address']; ?>">
                </div>
            </div>
            <div class="mb-2 row">
                <label for="phone" class="col-sm col-form-label">Telepon</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="phone" id="phone" value="<?= $general['phone']; ?>">
                </div>
            </div>
            <div class="mb-2 row">
                <label for="kas_awal" class="col-sm col-form-label">Kas Awal</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="kas_awal" id="kas_awal" value="<?= $general['kas_awal']; ?>">
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn btn-primary" type="submit">Submit</button>
                <span><a href="<?= base_url('setting'); ?>">Kembali</a></span>

            </div>
        </form>
    </div>
</div>
<?= $this->session->flashdata('message'); ?>