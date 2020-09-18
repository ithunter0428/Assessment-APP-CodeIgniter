<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?php echo base_url($plugins_dir . '/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url($plugins_dir . '/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<?php if ($this->router->fetch_class() == 'auth' && ($this->router->fetch_method() == 'register')): ?>
	<!-- bs-custom-file-input -->
	<script src="<?php echo base_url($plugins_dir .  '/bs-custom-file-input/bs-custom-file-input.min.js'); ?>"></script>
<?php endif;?>
	<!-- Toastr -->
	<script src="<?php echo base_url($plugins_dir . '/toastr/toastr.min.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url($dist_dir . '/js/adminlte.min.js'); ?>"></script>
	<!-- Main Script -->
	<script src="<?php echo base_url($frameworks_dir . '/public/js/script.js'); ?>"></script>
<?php if ($this->router->fetch_class() == 'auth' && ($this->router->fetch_method() == 'register')): ?>
	<script type="text/javascript">
	    $(document).ready(function () {
	    bsCustomFileInput.init();
	    });
	</script>
<?php endif;?>
<?php if ($this->router->fetch_class() != 'auth'): ?>
	<script type="text/javascript">
		// DATATABLES
		$('.table_datatable').DataTable()
	</script>
<?php endif;?>

	</body>
</html>