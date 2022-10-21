<!-- BEGIN: PAGE SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.1.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery_migrate/jquery-migrate-3.0.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery_ui/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<!-- Theme Javascript -->
<script src="<?php echo base_url('assets/js/utility/utility.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/demo/demo.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.form-validator.min.js'); ?>"></script>
<!-- Time/Date Plugin Dependencies -->
<script src="<?php echo base_url('assets/vendor/plugins/globalize/globalize.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/plugins/moment/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/plugins/datepicker/js/bootstrap-datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/init.js'); ?>"></script>
<script src="<?= base_url(); ?>assets/vendor/plugins/datatables/media/js/datatables.min.js"></script>

<script type="text/javascript">

    jQuery(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

    });

    $('#datatable2').dataTable({
		// dom: "Bfrtip",
		// dom: "rtip",
		dom: '<"top"fl>rt<"bottom"ip>'
		// select: true
	});


</script>

<!-- END: PAGE SCRIPTS -->
