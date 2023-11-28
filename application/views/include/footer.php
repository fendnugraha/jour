</body>
<script src="<?= base_url('assets'); ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets'); ?>/js/jquery-3.7.0.js"></script>
<script src="<?= base_url('assets'); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets'); ?>/js/dataTables.bootstrap5.min.js"></script>
<!-- <script src="<?= base_url('assets'); ?>/js/dataTables.jqueryui.min.js"></script> -->
<script src="<?= base_url('assets'); ?>/js/jquery-ui.js"></script>
<script src="<?= base_url('assets'); ?>/js/fontawesome.min.js"></script>
<script src="<?= base_url('assets'); ?>/js/all.min.js"></script>
<script src="<?= base_url('assets'); ?>/js/myjs.js"></script>
<script>
    // $(document).ready(function () {
    //   $('table.display').DataTable();
    //   $('table.display-noorder').DataTable({
    //     "ordering": false,
    //     // "paging": false
    //   });
    // });

    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy/mm/dd',
            showOtherMonths: true,
            selectOtherMonths: true
        }).val();
    });
</script>
</body>

</html>