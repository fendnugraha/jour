<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Nama Produk</td>
                            <td><?= $product['nama']; ?></td>
                        </tr>
                        <tr>
                            <td>Kode Produk</td>
                            <td><?= $product['kode']; ?></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td><?= $product['category']; ?></td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td><?= $product['beli']; ?></td>
                        </tr>
                        <tr>
                            <td>Harga Jual</td>
                            <td><?= $product['jual']; ?></td>
                        </tr>
                        <tr>
                            <td>Sisa Stok</td>
                            <td><?= $product['stok']; ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><?php if ($product['is_active'] == 1) {
                                    echo 'Aktif';
                                } else {
                                    echo 'Non Aktif';
                                }; ?></td>
                        </tr>
                        <tr>
                            <td>Dibuat Tanggal Stok</td>
                            <td><?= date('Y-m-d H:m:s', $product['date_modified']); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="action d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('home/edit_product/') . $product['inv_id']; ?>">Edit Produk</a>
                    <a href="<?= base_url('home'); ?>">Kembali</a>
                </div>
            </div>
            <div class="col-sm">
                <table class="table display">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>WAKTU</th>
                            <th>KONTAK</th>
                            <th>BELI</th>
                            <th>JUAL</th>
                            <th>DIBUAT</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        foreach ($product_trace as $p) {
                            if ($p['status'] == 1) {
                                $status = "<span class='badge rounded-pill text-bg-success'>success</span>";
                            } elseif ($p['status'] == 2) {
                                $status = "<span class='badge rounded-pill text-bg-danger'>void</span>";
                            };
                        ?>
                            <tr>
                                <td><?= $p['id']; ?></td>
                                <td><?= $p['waktu']; ?></td>
                                <td><?= $p['supplier']; ?></td>
                                <td><?= $p['purchases']; ?></td>
                                <td><?= $p['sales']; ?></td>
                                <td><?= date('Y-m-d H:s', $p['date_created']) . " by " . $p['username']; ?></td>
                                <td><?= $status; ?></td>
                            </tr>
                        <?php }; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>