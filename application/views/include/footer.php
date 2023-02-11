</div>
<script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/js/bootstrap.js"></script> -->
<!-- <script src="<?= base_url(); ?>assets/js/datatables.min.js"></script> -->
<!-- <script src="<?= base_url(); ?>assets/js/popper.min.js"></script> -->
<script src="<?= base_url(); ?>assets/js/jquery-3.5.1.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>assets/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/js/fontawesome.min.js"></script>
<script src="<?= base_url(); ?>assets/js/myjs.js"></script>
<script>
    $(document).ready(function() {
        $('table.display').DataTable();
        $('table.display-noorder').DataTable({
            "ordering": false,
            // "paging": false
        });
    });

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy/mm/dd'
        }).val();
    });
</script>
</body>

</html>