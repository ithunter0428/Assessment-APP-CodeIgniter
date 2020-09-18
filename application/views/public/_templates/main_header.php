<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url() ?>" class="nav-link">Home</a>
                    </li>
<?php if($this->session->userdata('group_value') == 2): ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url()?>public/users/lecturer_students" class="nav-link">Students</a>
                    </li>
<?php endif ?>
                </ul>

                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-comments"></i>
                            <span class="badge badge-danger navbar-badge"><?= $no_unread ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<?php foreach($recieved_msg as $msg): 
    if($msg['group_id'] == 2 OR $msg['group_id'] == 1){
        $image_path = '/m_001.png';
    }elseif($msg['group_id'] == 3){
        $image_path = '/'.$msg['passport'];
    } 
?>
                        <a href="<?=base_url()?>public/messaging/open/<?=$msg['messaging_from']?>" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="<?php echo base_url($avatar_dir . $image_path); ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        <?=$msg['username']?>
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm"><?php echo substr($msg['messaging_body'],0,20)?></p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?=$msg['messaging_date_added']?>o</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
<?php endforeach ?>
                        <a href="<?=base_url()?>public/messaging" class="dropdown-item dropdown-footer"><?php echo lang('header_view_all'); ?></a>
                        </div>
                    </li>
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge"><?=$no_notification?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header"><?=$no_notification?> <?php echo lang('header_notification'); ?></span>
<?php foreach($recieved_notification as $notifications): ?>
                            <div class="dropdown-divider"></div>
                            <a href="<?=base_url()?>public/notification/" class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="text-sm">
<?php if($notifications['notification_type'] == 1 ): ?>
                                            <i class="fas fa-edit mr-2"></i> New Assessment
<?php else: ?>
                                            <i class="fas fa-check mr-2"></i><?=$notifications['course_code']?> Result
<?php endif; ?> 
                                        </h3>
                                        <p class="text-muted small"><?= $notifications['notification_date_added']?></p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
<?php endforeach; ?>
                            <a href="<?=base_url()?>public/notification" class="dropdown-item dropdown-footer"><?php echo lang('header_view_all'); ?></a>
                        </div>
                    </li>

                    <div class="nav-item dropdown user-menu show">
<?php 
if($this->session->userdata('group_value') == 2 OR $this->session->userdata('group_value') == 1){
    $image_path = '/m_001.png';
}elseif($this->session->userdata('group_value') == 3){
    $image_path = '/'.$this->session->userdata('passport');
} 
?>
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="<?php echo base_url($avatar_dir . $image_path); ?>" class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline"><?php echo $user_login['firstname'].$user_login['lastname']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user p-0 m-0">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-info">
                                    <h3 class="widget-user-username"><?php echo $user_login['firstname'].$user_login['lastname']; ?></h3>
                                    <h4 class="widget-user-desc"><?= $this->session->userdata('department_name');?> 
<?php if($this->session->userdata('user_level_name')): ?>
                                        &amp; <?php echo "". $this->session->userdata('user_level_name'); ?>
<?php endif;?>  
                                    </h4>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="<?php echo base_url($avatar_dir . $image_path); ?>" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
<?php if($this->session->userdata('group_value') == 2): ?>
                                                <h5 class="description-header"><?= $user_students_count ?></h5>
                                                <span class="description-text text-sm">STUDENTS</span>
<?php else: ?>
                                                <h5 class="description-header"><?= $user_students_count ?></h5>
                                                <span class="description-text text-sm">COURSEMATES</span>
<?php endif; ?>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header"><?= $user_courses_count ?></h5>
                                                <span class="description-text text-sm">COURSES</span>
                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4">
                                            <div class="description-block">
<?php if($this->session->userdata('group_value') == 2): ?>
                                                <h5 class="description-header"><?= $user_assessment_count ?></h5>
                                                <span class="description-text text-sm">QUESTIONS</span>
<?php else: ?>
                                                <h5 class="description-header"><?= $user_lecturers_count ?></h5>
                                                <span class="description-text text-sm">LECTURERS</span>
<?php endif; ?>

                                            </div>
                                            <!-- /.description-block -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    </div>

<?php if ($admin_prefs['ctrl_sidebar'] == TRUE): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                        </a>
                    </li>
<?php endif; ?>                    
                </ul>
            </nav>
            <!-- /.navbar -->