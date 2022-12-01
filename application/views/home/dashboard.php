<div class="row mb-3">
    <div class="col-sm">
        <div class="card bg-primary text-bg-dark">
            <div class="card-body">
                <p>Total Inventory</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-warehouse"></i> <b><?= number_format($total_inv['total_inv']); ?> ,-</b></h2>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-warning text-bg-light">
            <div class="card-body">
                <p>Total Pendapatan</p>
                <h2 class="d-flex justify-content-between"><i class="fas fa-cash-register"></i> <b><?= number_format($total_so['total']); ?> ,-</b></h2>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card bg-success text-bg-dark">
            <div class="card-body">
                <p>Total Keuntungan</p>
                <h2 class="d-flex justify-content-between"><i class="fa-solid fa-sack-dollar"></i> <b><?= number_format($laba['laba']); ?> ,-</b></h2>

            </div>
        </div>
    </div>
</div>



<div class="card mb-3">
    <div class="card-body">
        <div class="control-nav mb-3">
            <a href="<?= base_url('home/addProduct'); ?>" class=" btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Produk</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCatProduct">
                <i class="fa-solid fa-circle-plus"></i> Kategori
            </button>
        </div>
        <table class="table display table-striped">
            <thead class="table-light">
                <tr>
                    <th>KODE</th>
                    <th>NAMA</th>
                    <th>KATEGORI</th>
                    <th>MODAL</th>
                    <th>JUAL</th>
                    <th>SISA</th>
                    <th>UPDATE TERAKHIR</th>
                    <th>DETAIL</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                foreach ($product as $p) {
                ?>
                    <tr>
                        <td><?= $p['kode']; ?></td>
                        <td><?= $p['nama']; ?></td>
                        <td><?= $p['category']; ?></td>
                        <td><?= number_format($p['beli']); ?></td>
                        <td><?= number_format($p['jual']); ?></td>
                        <td><?= number_format($p['stok']); ?></td>
                        <td><?= date('Y-m-d H:s', $p['date_modified']); ?></td>
                        <td class="text-center">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="<?= base_url('home/edit_product/') . $p['inv_id']; ?>">Edit Produk</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('home/pr_detail/') . $p['inv_id']; ?>">Details</a></li>
                                        <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>

        </table>
    </div>
</div>
<!-- cashflow -->
<div class="card">
    <div class="card-body">
        <div class="control-nav mb-3 d-flex justify-content-between">
            <div class="control-btn">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cashInMod">
                    <i class="fa-solid fa-circle-plus"></i> Kas Masuk
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cashOutMod">
                    <i class="fa-solid fa-circle-plus"></i> Kas Keluar
                </button>
            </div>
            <div class="end-balance">
                <h2 class="fw-bold"><i class="fa-solid fa-wallet"></i> Rp <?= number_format($kasakhir); ?>,-</h2>
            </div>
        </div>
        <table class="table display table-striped">
            <thead class="table-light">
                <tr>
                    <th>WAKTU</th>
                    <th>INVOICE</th>
                    <th>DESKRIPSI</th>
                    <th>STATUS</th>
                    <th>MASUK</th>
                    <th>KELUAR</th>
                    <th>USER</th>
                    <th>UPDATE TERAKHIR</th>
                    <th>OPSI</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                foreach ($cashflow as $cf) {
                    if ($cf['masuk'] > 0) {
                        echo '<tr class="table-success">';
                    } else {
                        echo '<tr class="table-danger">';
                    };
                    if ($cf['status'] == 1) {
                        $status = "<span class='badge rounded-pill text-bg-success'>success</span>";
                    } elseif ($cf['status'] == 2) {
                        $status = "<span class='badge rounded-pill text-bg-danger'>void</span>";
                    };
                ?>
                    <td><?= $cf['waktu']; ?></td>
                    <td><?= $cf['invoice']; ?></td>
                    <td><?= $cf['deskripsi']; ?></td>
                    <td class="text-center"><?= $status; ?></td>
                    <td><?= number_format($cf['masuk']); ?></td>
                    <td><?= number_format($cf['keluar']); ?></td>
                    <td><?= $cf['username']; ?></td>
                    <td><?= date('Y-m-d H:i:s', $cf['date_modified']); ?></td>
                    <td class="text-center">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <?php if ($cf['deskripsi'] == "Pembelian stok barang" || $cf['deskripsi'] == "Penjualan barang") {
                                        echo "";
                                    } else { ?>
                                        <li><a class="dropdown-item" href="<?= base_url('home/edit_cashflow/') . $cf['id']; ?>">Edit</a></li>
                                    <?php }; ?>

                                    <li><a class="dropdown-item" href="<?= base_url('home/cf_detail/') . $cf['id'];; ?>">Details</a></li>
                                    <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                </ul>
                            </li>
                        </ul>
                    </td>
                    </tr>
                <?php }; ?>
            </tbody>

        </table>
    </div>
</div>
</div>




<!-- Modal -->
<div class="modal fade" id="addCatProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('home/addCatProduct'); ?>" method="post">
                    <div class="mb-1 row">
                        <label for="catname" class="col-sm col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="catname" id="catname" value="<?= set_value('catname'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="catprefix" class="col-sm col-form-label">Kode Prefix</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="catprefix" id="catprefix" value="<?= set_value('catprefix'); ?>">
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


<div class="modal fade" id="cashInMod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success text-bg-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Kas Masuk (Income)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('home/cashin'); ?>" method="post">
                    <div class="mb-1 row">
                        <label for="tanggal" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d H:i'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="jumlah" class="col-sm col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="jumlah" id="jumlah" value="<?= set_value('jumlah'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="deskripsi" class="col-sm col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="<?= set_value('deskripsi'); ?>">
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


<div class="modal fade" id="cashOutMod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-danger text-bg-dark">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Kas Keluar (Expense)</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('home/cashout'); ?>" method="post">
                    <div class="mb-1 row">
                        <label for="tanggal" class="col-sm col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="datetime-local" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d H:i'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="jumlah" class="col-sm col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="jumlah" id="jumlah" value="<?= set_value('jumlah'); ?>">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label for="deskripsi" class="col-sm col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="<?= set_value('deskripsi'); ?>">
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