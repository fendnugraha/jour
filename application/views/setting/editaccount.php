<div class="card">
    <div class="card-body">
        <form action="<?= base_url('setting/editAccount/') . $accounts['acc_code']; ?>" method="post">
            <div class="mb-3 row">
                <label for="acc_name" class="col-sm col-form-label">Nama Account</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="acc_name" id="acc_name" value="<?= $accounts['acc_name']; ?>">
                    <div class="form-text">Maksimal 60 Karakter</div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="st_balance" class="col-sm col-form-label">Saldo Awal</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="st_balance" id="st_balance" value="<?= $accounts['st_balance']; ?>">
                    <!-- <div class="form-text">Maksimal 60 Karakter</div> -->
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="<?= base_url('setting/accounts'); ?>">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->session->flashdata('message'); ?>