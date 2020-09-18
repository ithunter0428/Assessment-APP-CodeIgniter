<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= base_url() ?>" class="brand-link p-0 pt-2">
            <div class="media m-0 p-0">
                <img src="<?php echo base_url($dist_dir . '/img/ksu_logo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"style="opacity: .8">
                <div class="media-body m-0 p-0">
                    <h2 class="brand-text text-light text-sm text-uppercase">Kogi State University</h2><br>
                    <div class="brand-text text-sm text-uppercase">Assessment Portal</div>
                </div>
            </div>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url("/") ?>" class="nav-link <?=active_link_controller('home')?>">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url("public/messaging") ?>" class="nav-link <?=active_link_controller('messaging')?>">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                Messaging
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url("public/notification") ?>" class="nav-link <?=active_link_controller('notification')?>">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>
                                Notifications
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url("public/course_reg") ?>" class="nav-link <?=active_link_controller('course_reg')?>">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Course Registration
                            </p>
                        </a>
                    </li>
                    <li class="nav-header text-uppercase">ASSESSMENT</li>
<?php if ($this->session->userdata('group_value') == 2):
// FOR LECTURERS ONLY
?>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/assessment'); ?>" class="create_assessment nav-link">
                            <i class="nav-icon fas fa-edit "></i>
                            <p>
                                Create
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/assessment/question'); ?>" class="nav-link <?=active_link_controller('assessment')?>">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>
                                Questions
                            </p>
                        </a>
                    </li>
<?php  endif;?>
<?php if ($this->session->userdata('group_value') == 3): 
// FOR STUDENTS ONLY
?>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/evaluation'); ?>" class="nav-link <?php if((active_link_controller('evaluation') AND active_link_function('index')) OR active_link_function('view') ){ echo 'active'; }?>">
                            <i class="nav-icon far fa-edit"></i>
                            <p>
                                New <span class="right badge badge-danger" id="new-assessment-label">New</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/evaluation/submited'); ?>" class="nav-link <?php if(active_link_function('submited') OR active_link_function('submited_view')){ echo 'active'; } ?>">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                submited
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/evaluation/result'); ?>" class="nav-link <?=active_link_controller('result')?>">
                            <i class="nav-icon fas fa-check-square"></i>
                            <p>
                                Results
                            </p>
                        </a>
                    </li>
<?php endif; ?>
                    <li class="nav-header text-uppercase">my profile</li>
<?php if ($this->session->userdata('group_value') == 2):
// FOR LECTURERS ONLY
?>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/users/lecturer_students'); ?>" class="nav-link <?php if(active_link_controller('users') AND active_link_function('lecturer_students') ){ echo 'active'; } ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Students
                            </p>
                        </a>
                    </li>
<?php endif;?>
<?php if ($this->session->userdata('group_value') == 3): 
// FOR STUDENTS ONLY
?>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/users/lecturers'); ?>" class="nav-link <?php if(active_link_controller('users') AND active_link_function('lecturers') ){ echo 'active'; } ?>">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                Lecturers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('public/users/students'); ?>" class="nav-link <?php if(active_link_controller('users') AND active_link_function('students')){ echo 'active'; } ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Coursemates
                            </p>
                        </a>
                    </li>
<?php endif;?>
                    <li class="nav-item menu-open">
                        <a href="<?php echo site_url('auth/logout'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>