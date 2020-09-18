<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">ChilliesDev</a>. </strong>
			&nbsp All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<?php echo lang('footer_version'); ?> Development
			</div>
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="<?php echo base_url($plugins_dir . '/jquery/jquery.min.js'); ?>"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo base_url($plugins_dir . '/jquery-ui/jquery-ui.min.js'); ?>"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url($plugins_dir . '/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url($plugins_dir . '/toastr/toastr.min.js'); ?>"></script>
	<!-- ChartJS -->
	<script src="<?php echo base_url($plugins_dir . '/chart.js/Chart.min.js'); ?>"></script>
	<!-- Sparkline -->
	<script src="<?php echo base_url($plugins_dir . '/sparklines/sparkline.js'); ?>"></script>
	<!-- JQVMap -->
	<script src="<?php echo base_url($plugins_dir . '/jqvmap/jquery.vmap.min.js'); ?>"></script>
	<script src="<?php echo base_url($plugins_dir . '/jqvmap/maps/jquery.vmap.usa.js'); ?>"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url($plugins_dir . '/jquery-knob/jquery.knob.min.js'); ?>"></script>
	<!-- daterangepicker -->
	<script src="<?php echo base_url($plugins_dir . '/moment/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url($plugins_dir . '/daterangepicker/daterangepicker.js'); ?>"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo base_url($plugins_dir . '/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); ?>"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url($plugins_dir . '/summernote/summernote-bs4.min.js'); ?>"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo base_url($plugins_dir . '/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url($plugins_dir . '/datatables/jquery.dataTables.js'); ?>"></script>
	<script src="<?php echo base_url($plugins_dir . '/datatables-bs4/js/dataTables.bootstrap4.js'); ?>"></script>
	<!-- Confirm-Jquery -->
	<script src="<?php echo base_url($plugins_dir . '/confirm/jquery-confirm.min.js'); ?>"></script>

<?php if ($mobile == TRUE): ?>
	<script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
	<script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
	<script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
	<script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
	<script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
	
	<!-- AdminLTE App -->
	<script src="<?php echo base_url($dist_dir . '/js/adminlte.js'); ?>"></script>
	<!-- Main Script -->
	<script src="<?php echo base_url($frameworks_dir . '/public/js/script.js'); ?>"></script>

<?php if ($this->router->fetch_class() == 'evaluation' && ($this->router->fetch_method() == 'submited_view' OR $this->router->fetch_method() == 'view')): ?>
	<script>
<?php
switch ($question_type) {
	case 1:
		$question_id = $question_link[0]['obj_question_id'];
		$assessment_id = $question_link[0]['assessment_obj_id'];
		break;
	case 2:
			$question_id = $question_link[0]['essay_question_id'];
			$assessment_id = $question_link[0]['assessment_essay_id'];
		break;
	
	default:
		# code...
		break;
}
?>

		$(function(){
			get_question_ans(<?php echo $question_type . ','. $question_id. ','. $assessment_id?>)
			current_link(<?php echo $link_id = 'link1' ?>)
		})
	</script>
<?php endif; ?>

<?php if ($this->router->fetch_class() == 'assessment' && ($this->router->fetch_method() == 'mark')): ?>
	<script>
		$(document).ready(function(){
			get_mark_question(<?php echo $answer[0]['answer_assessment_id'] . ','. $answer[0]['answer_user_id']. ','. $answer[0]['answer_question_id']?>);        
			current_link(<?php echo $link_id = 'link1' ?>);

			$('#finish_marking').click(function(evt){

				evt.preventDefault();

				$.confirm({
					title: 'Finish Marking?',
					content: 'Do you want to send this result to your student?',
					type: 'green',
					typeAnimated: true,
					buttons:{
						confirm: function(){
							showLoadingOverlay()
							submit_answer();
							console.log('true')
							$('#form_evaluation_submit').attr('action','http://localhost/assessment_app/public/assessment/finish_marking/'  + <?=$assessment_id ?> +'/' + <?=$user_id ?>)
							hideLoadingOverlay()
							$('#form_evaluation_submit').submit()
						},
						close: function (){
							
						}                                    
					}  
				})
			})
		})
	</script>
<?php endif; ?>

	</body>
</html>