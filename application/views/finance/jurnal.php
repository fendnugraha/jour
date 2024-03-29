<!-- <div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>Total Inventory</p>
                <h2 class="d-flex justify-content-between">Rp <b><?= number_format($total_inv['total_inv']); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-info text-bg-light">
            <div class="card-body">
                <p>Total Pembelian</p>
                <h2 class="d-flex justify-content-between">Rp <b><?= number_format($total_po['total']); ?> ,-</b></h2>

            </div>
        </div>
    </div>
</div> -->
<form action="<?= base_url('finance/jurnal/'); ?>" class="row mb-3" method="post">
    <div class="col-auto">
        <label for="startDate">Dari</label>
    </div>
    <div class="col-auto">
        <input type="text" name="startDate" id="startDate" class="form-control form-control-sm datepicker" value="<?= $startDate; ?>">
    </div>
    <div class="col-auto">
        <label for="endDate">Sampai</label>
    </div>
    <div class="col-auto">
        <input type="text" name="endDate" id="endDate" class="form-control form-control-sm datepicker" value="<?= $endDate; ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Proses</button>
    </div>
</form>
<div class="card">
    <div class="card-body">
        <div class="control-nav mb-3 d-flex gap-2 justify-content-between">

            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContact">
    + Tambah Kontak
</button> -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Tambah Jurnal
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?= base_url('finance/addJournal'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Jurnal Umum</a></li>
                    <li><a href="<?= base_url('finance/addDeposit'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Deposit</a></li>
                    <li><a href="<?= base_url('sales/addSalesValues'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Penjualan Barang (Values)</a></li>
                    <li><a href="<?= base_url('finance/importJurnal'); ?>" class=" dropdown-item"> <i class="fa-solid fa-circle-plus"></i> Import Jurnal Umum</a></li>
                </ul>
            </div>
            <div class="link-list-finance">
                <a href="<?= base_url('finance/receivable'); ?>" class=" btn btn-warning"> <i class="fa-solid fa-circle-plus"></i> Piutang</a>
                <a href="<?= base_url('finance/payable'); ?>" class=" btn btn-warning"> <i class="fa-solid fa-circle-plus"></i> Hutang</a>
                <a href="<?= base_url('finance/cashTotal'); ?>" class=" btn btn-success"> <i class="fa-solid fa-wallet"></i> Cash & Bank</a>
            </div>
        </div>
        <table class="table display-noorder">
            <thead class="thead-dark">
                <tr>
                    <th>WAKTU</th>
                    <th>INVOICE</th>
                    <th>DESKRIPSI</th>
                    <th>JUMLAH</th>
                    <th>STATUS</th>
                    <th>OPSI</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                foreach ($account_trace as $p) {
                    if ($p['status'] == 1) {
                        $status = "<span class='badge rounded-pill text-bg-success'>success</span>";
                    } elseif ($p['status'] == 2) {
                        $status = "<span class='badge rounded-pill text-bg-danger'>void</span>";
                    };
                ?>
                    <tr>
                        <td><?= $p['waktu']; ?></td>
                        <td><?= $p['invoice']; ?></td>
                        <td><span class='badge rounded-pill text-bg-success'><?= $p['debt_name']; ?> X <?= $p['cred_name']; ?></span>
                            <span class='badge rounded-pill text-bg-secondary'><?= $p['warehouse_name']; ?></span>
                            <span class='badge rounded-pill text-bg-warning'><?= $p['username']; ?></span><br>
                            #<?= $p['id']; ?>. <?= ucwords($p['description']); ?>
                        </td>
                        <td><?= number_format($p['jumlah']); ?></td>
                        <td><?= $status; ?></td>
                        <td>
                            <div class="edit-journal-area d-inline" <?php if ($p['rvpy'] == !null) {
                                                                        echo "hidden";
                                                                    }; ?>>
                                <a href="<?= base_url('finance/editJournal/') . $p['id']; ?> " class="text-decoration-none"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

                            </div>
                            <a href="<?= base_url('finance/jr_detail/') . $p['id']; ?> " class="text-decoration-none" target="_blank"><i class="fa-solid fa-circle-info"></i> Detail</a>
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