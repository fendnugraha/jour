<div class="card">
    <div class="card-body">
        <h4 class="card-title">Import Journal</h4>
        <div class="row">
            <div class="col-sm">
                <form action="<?= base_url() ?>finance/importJurnalAction" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".xls, .xlsx" required>
                    </div>
                    <div class="form-group">
                        <label for="wh">Warehouse</label>
                        <select name="wh" id="wh" class="form-control">
                            <?php foreach ($wh as $w) : ?>
                                <option value="<?= $w['id'] ?>"><?= $w['warehouse_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Import</button>
                </form>

            </div>
            <div class="col-sm">
                <?= $this->session->flashdata('message'); ?>
            </div>
        </div>
    </div>
</div>