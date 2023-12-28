<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>Total Piutang</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-file-invoice"></i> <b><?= custom_number($dt_receivable['bill']); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-warning text-bg-light">
            <div class="card-body">
                <p>Total Pembayaran</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-cash-register"></i> <b><?= custom_number($dt_receivable['got_paid']); ?> ,-</b></h2>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-dark text-bg-dark">
            <div class="card-body">
                <p>Sisa Piutang</p>
                <h2 class="d-flex justify-content-between"><i class="fa-regular fa-credit-card"></i> <b><?= number_format(floatval($dt_receivable['remaining'])); ?> ,-</b></h2>

            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="control-nav mb-3 d-flex gap-2 justify-content-between">

            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContact">
                + Tambah Kontak
            </button> -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tambah Piutang
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url('finance/addReceivable'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Piutang</a></li>
                    <li><a href="<?= base_url('finance/addReceivableSt'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Piutang Awal</a></li>
                    <li><a href="<?= base_url('finance/addRcvDeposit'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Piutang Saldo</a></li>
                    <li><a href="<?= base_url('finance/addReceivableSales'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Piutang Penjualan</a></li>
                </ul>
            </div>
            <div class="back-list">
                <a href="<?= base_url('finance/jurnal'); ?>" class="btn btn-primary"><i class="fa-solid fa-circle-arrow-left"></i> Jurnal</a>
                <a href="<?= base_url('finance/payable'); ?>" class="btn btn-primary"><i class="fa-solid fa-circle-arrow-left"></i> Hutang</a>
                <a href="<?= base_url('finance/expExcelRcv'); ?>" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
            </div>
        </div>
        <table class="table display">
            <thead class="thead-dark">
                <tr>
                    <th>NO</th>
                    <th>CONTACT</th>
                    <th>JUMLAH</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $no = 1;
                foreach ($receivable as $rv) {
                    if ($rv['bill_total'] == 0) {
                        $status = "<span class='badge rounded-pill text-bg-success'>Fullpaid</span>";
                    } else {
                        $status = "<span class='badge rounded-pill text-bg-danger'>Unpaid</span>";
                    };
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $rv['ct_name']; ?></td>
                        <td><?= number_format($rv['bill_total']); ?></td>
                        <td><?= $status; ?></td>
                        <td>
                            <!-- <a href="<?= base_url('finance/edit_journal/') . $rv['contact_id'];; ?> ">Edit</a> -->
                            <a href="<?= base_url('finance/rv_detail/') . $rv['contact_id'];; ?> ">Detail</a>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>

        </table>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('purchase'); ?>" method="post">
                    <div class="mb-1 row">
                        <label for="ct_name" class="col-sm col-form-label">Nama Kontak</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="ct_name" id="ct_name" value="<?= set_value('ct_name'); ?>">
                            <div class="form-text">Maksimal 60 Karakter</div>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="catprefix" class="col-sm col-form-label">Type</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="ct_type" id="ct_type">
                                <option value="Konsumen">Konsumen</option>
                                <option value="Supplier">Supplier</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="ct_desc" class="col-sm col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" name="ct_desc" id="ct_desc" value="<?= set_value('ct_desc'); ?>">
                            </textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </form>
    </div>
</div>