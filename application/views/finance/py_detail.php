<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>Total Hutang</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-warehouse"></i> <b><?= number_format($rv_stats['billing']); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-success text-bg-dark">
            <div class="card-body">
                <p>Total Pembayaran</p>
                <h2 class="d-flex justify-content-between"><i class="fas fa-cash-register"></i> <b><?= number_format($rv_stats['payments']); ?> ,-</b></h2>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-danger text-bg-dark">
            <div class="card-body">
                <p>Sisa Hutang</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-sack-dollar"></i> <b><?= number_format($rv_stats['rv_remain']); ?> ,-</b></h2>

            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="control-nav mb-3 d-flex justify-content-between">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRvPayment">
                <i class="fa-solid fa-circle-plus"></i> Input Pembayaran
            </button>
            <div class="control-nav-info">
                <a href="<?= base_url('finance/payable'); ?>" class=" btn btn-primary"> <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Hutang</a>
            </div>
        </div>
        <table class="table display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>WAKTU</th>
                    <th>INVOICE</th>
                    <th>DESKRIPSI</th>
                    <th>JUMLAH</th>
                    <th>PEMBAYARAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rv_detail as $rv) {
                ?>
                    <tr>
                        <td><?= $rv['id']; ?></td>
                        <td><?= $rv['waktu']; ?></td>
                        <td><?= $rv['invoice']; ?></td>
                        <td><?= $rv['description']; ?></td>
                        <td><?= number_format($rv['bill_amount']); ?></td>
                        <td><?= number_format($rv['pay_amount']); ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
        <div class="info-addproduct col-sm">
            <?php echo validation_errors(); ?>
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="addRvPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-danger text-bg-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Pembayaran Hutang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('finance/py_detail/' . $contact_id); ?>" method="post">
                    <div class="mb-2 row">
                        <label for="p_date" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="p_date" id="p_date" value="<?= date('Y-m-d H:i'); ?>">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="invoice" class="col-sm col-form-label">No. Invoice</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="invoice" id="invoice">
                                <option value="">- Pilih Invoice Hutang -</option>
                                <?php
                                foreach ($rv_remain as $c) {
                                ?>
                                    <option value="<?php if ($c['remaining'] == 0) {
                                                        echo '';
                                                    } else {
                                                        echo $c['invoice'];
                                                    }; ?>" <?= set_select('invoice', $c['invoice']); ?>><?= $c['invoice']; ?> | <?= $c['waktu']; ?> | <?= $c['remaining']; ?></option>
                                <?php
                                }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="acc_debet" class="col-sm col-form-label">Sumber Dana</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="acc_debet" id="acc_debet">
                                <option value="">- Pilih Akun Kas -</option>
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
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-warning">Save changes</button>
            </div>
        </div>
        </form>
    </div>
</div>