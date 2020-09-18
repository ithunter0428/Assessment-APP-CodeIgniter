<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

						<div class="content-wrapper">
								<section class="content-header">
									<div class="container">
										<div class="row">
											<div class="col-6">
												<?php echo $pagetitle; ?>
											</div>
											<div class="col-6">
												<?php echo $breadcrumb; ?>
											</div>
										</div>
									</div>
								</section>
<?php if ($this->session->userdata('group_value') == 3):
// FOR STUDENTS ONLY
?>
								<section>
									<div class="container">
										<div class="row">
											<div class="col-lg-3 col-6">
												<!-- small card -->
												<div class="small-box bg-info">
													<div class="inner">
														<h3><?= $user_students_count ?></h3>
														<p>Coursemates</p>
													</div>
													<div class="icon">
														<i class="fas fa-users"></i>
													</div>
													<a href="<?php echo base_url()?>public/users/students" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
											<!-- ./col -->
											<div class="col-lg-3 col-6">
												<!-- small card -->
												<div class="small-box bg-success">
													<div class="inner">
														<h3><?= $user_lecturers_count ?></h3>
														<p>Lecturers</p>
													</div>
													<div class="icon">
														<i class="fas fa-user-tie"></i>
													</div>
													<a href="<?php echo base_url()?>public/lecturers" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
											<!-- ./col -->
											<div class="col-lg-3 col-6">
												<!-- small card -->
												<div class="small-box bg-warning">
													<div class="inner">
														<h3><?= $user_courses_count ?></h3>
														<p>Courses</p>
													</div>
													<div class="icon">
														<i class="fas fa-university"></i>
													</div>
													<a href="<?php echo base_url()?>public/assessment/question" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
											<div class="col-lg-3 col-6">
												<!-- small card -->
												<div class="small-box bg-danger">
													<div class="inner">
														<h3>0</h3>

														<p>Results</p>
													</div>
													<div class="icon">
														<i class="fas fa-check-square"></i>
													</div>
													<a href="<?= base_url()?>public/evaluation/results" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</section>

								<section class="content">
									<div class="container">
										<div class="row">
											<div class="card-body d-flex justify-content-center">
												<a class="btn btn-app col-3 p-3" href="<?=base_url()?>public/evaluation">
													<span class="badge bg-danger" id="new-assessment-count">0</span>
													<i class="fas fa-edit"></i> New Assessment
												</a>
												<a class="btn btn-app col-3 p-3" href="<?=base_url()?>public/notification">
													<span class="badge bg-warning"><?= $no_notification ?></span>
													<i class="fas fa-bullhorn"></i> Notifications
												</a>
												<a class="btn btn-app col-3 p-3" href="<?=base_url()?>public/messaging">
													<span class="badge bg-info"><?= $no_unread ?></span>
													<i class="fas fa-envelope"></i> Messaging
												</a>
											</div>
										</div>
									</div>
								</section>
<?php endif ?>
<?php if ($this->session->userdata('group_value') == 2):		
// FOR LECTURERS ONLY
?>
								<section>
									<div class="container">
										<div class="row">
											<div class="col-lg-4 col-6">
												<!-- small card -->
												<div class="small-box bg-info">
													<div class="inner">
														<h3><?= $user_students_count ?></h3>
														<p>Students</p>
													</div>
													<div class="icon">
														<i class="fas fa-users"></i>
													</div>
													<a href="<?php echo base_url()?>/public/users/lecturer_students" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
											<!-- ./col -->
											<div class="col-lg-4 col-6">
												<!-- small card -->
												<div class="small-box bg-success">
													<div class="inner">
														<h3><?= $user_courses_count ?></h3>
														<p>Courses</p>
													</div>
													<div class="icon">
														<i class="fas fa-university"></i>
													</div>
													<a href="<?php echo base_url()?>/public/course_reg" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
											<!-- ./col -->
											<div class="col-lg-4 col-12">
												<!-- small card -->
												<div class="small-box bg-warning">
													<div class="inner">
														<h3><?= $user_assessment_count ?></h3>
														<p>Questions</p>
													</div>
													<div class="icon">
														<i class="fas fa-question-circle"></i>
													</div>
													<a href="<?php echo base_url()?>/public/assessment/question" class="small-box-footer">
														More info <i class="fas fa-arrow-circle-right"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</section>

								<section class="content">
									<div class="container">
										<div class="row">
											<div class="card-body d-flex justify-content-center">
												<a class="create_assessment btn btn-app col-3 p-3">
													<i class="fas fa-edit"></i> Create Assessment
												</a>
												<a class="btn btn-app col-3 p-3" href="<?=base_url()?>/public/notification">
													<span class="badge bg-warning"><?= $no_notification ?></span>
													<i class="fas fa-bullhorn"></i> Notifications
												</a>
												<a class="btn btn-app col-3 p-3" href="<?=base_url()?>/public/messaging">
													<span class="badge bg-info"><?= $no_unread ?></span>
													<i class="fas fa-envelope"></i> Messaging
												</a>
											</div>
										</div>
									</div>
								</section>
<?php endif ?>
								<section class="content">
									<div class="container">
										<div class="row">
											<div class="timeline col-12">
<?php 
	$i = 0;
	foreach($timeline_log as $key => $timeline_date): 
	$i++;
	if($i == 1){
		$date_color = 'red';
	}else{
		$date_color = 'success';
	}
?>
												<!-- timeline time label -->
												<div class="time-label">
													<span class="bg-<?= $date_color ?>"><?= date('F j, Y',strtotime($key)) ?></span>
												</div>
												<!-- /.timeline-label -->
<?php foreach($timeline_date as $row): 
	
	switch ($row['type']) {
		case 'notification':
			if($row['notification_type'] == 1){
				$icon = 'bell';
				$color = 'warning';
			}elseif($row['notification_type'] == 2){
				$icon = 'bell';
				$color = 'success';
			}
			break;
		
		case 'message':
			$icon = 'envelope';
			$color = 'primary';
			break;
		
		default:
			# code...
			break;
	}
?>
<?php if($row['type'] == 'message'): ?>
												<!-- timeline item -->
												<div>
													<i class="fas fa-<?=$icon?> bg-<?=$color?>"></i>
													<div class="timeline-item">
														<span class="time"><i class="fas fa-clock"></i> <?= $row['date_ago'] ?></span>
														<h3 class="timeline-header"><a href="#"><?=$row['username']?></a> sent you an message</h3>
														<div class="timeline-body">
															<?= $row['messaging_body']?>
														</div>
														<div class="timeline-footer">
															<a class="btn btn-<?=$color?> btn-sm" href="<?=base_url()?>public/messaging/open/<?=$row['messaging_from']?>">Read more</a>
														</div>
													</div>
												</div>
												<!-- END timeline item -->
<?php endif ?>
<?php if($row['type'] == 'notification'): ?>
												<!-- timeline item -->
												<div>
													<i class="fas fa-<?=$icon?> bg-<?=$color?>"></i>
													<div class="timeline-item">
														<span class="time"><i class="fas fa-clock"></i> <?= $row['date_ago'] ?></span>
<?php if($row['notification_type'] == 1): ?>
														<h3 class="timeline-header">New <span class="text-uppercase"><?= $row['course_code'] ?></span> Assessment</h3>
<?php endif?>
<?php if($row['notification_type'] == 2): ?>
														<h3 class="timeline-header"><span class="text-uppercase"><?= $row['course_code'] ?></span> Result</h3>
<?php endif?>
														<div class="timeline-body">
															<?= $row['notification_body'] ?>
														</div>
														<div class="timeline-footer">
															<a class="btn btn-<?=$color?> btn-sm" href="<?=base_url()?>public/notification">Read more</a>
														</div>
													</div>
												</div>
												<!-- END timeline item -->
<?php endif ?>
<?php endforeach; ?>
<?php endforeach; ?>
												<div>
													<i class="fas fa-clock bg-gray"></i>
												</div>
											</div>
										</div>
									</div>
								</section>

						</div>
