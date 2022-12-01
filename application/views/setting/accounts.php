<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm">
                <div class="control-nav mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContact">
                        + Tambah Kontak
                    </button>
                </div>
                <table class="table display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Type</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contact as $ct) {; ?>
                            <tr>
                                <td><?= $ct['id']; ?></td>
                                <td><?= $ct['nama']; ?></td>
                                <td><?= $ct['type']; ?></td>
                                <td><?= $ct['keterangan']; ?></td>
                            </tr>
                        <?php }; ?>
                    </tbody>
                </table>

                <a href="<?= base_url('setting'); ?>">Kembali</a>
            </div>
            <div class="col-sm">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>
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
                <form action="<?= base_url('setting/addContact'); ?>" method="post">
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


<!-- Modal -->
<div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('setting/addContact'); ?>" method="post">
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