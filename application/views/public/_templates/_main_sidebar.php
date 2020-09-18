<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <aside class="main-sidebar">
                <section class="sidebar">
<?php if ($admin_prefs['user_panel'] == TRUE): ?>
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url($avatar_dir . '/m_001.png'); ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $user_login['firstname'].$user_login['lastname']; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('menu_online'); ?></a>
                        </div>
                    </div>

<?php endif; ?>
<?php if ($admin_prefs['sidebar_form'] == TRUE): ?>
                    <!-- Search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="<?php echo lang('menu_search'); ?>...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>

<?php endif; ?>
                    <!-- Sidebar menu -->
                    <ul class="sidebar-menu">
                        <li class="<?=active_link_controller('messaging')?>">
                            <a href="<?php echo site_url('public/messaging/index/'.$session_user_id); ?>">
                                <i class="fa fa-envelope"></i> <span>Messaging</span>
                            </a>
                        </li>

                        <li class="<?=active_link_controller('notification')?>">
                            <a href="<?php echo site_url('public/notification/'); ?>">
                                <i class="fa fa-bell"></i> <span>Notifications</span>
                            </a>
                        </li>
                        
                        <li class="<?=active_link_controller('course_reg')?>">
                            <a href="<?php echo site_url('public/course_reg'); ?>">
                                <i class="fa fa-mortar-board"></i> <span>Course Registration</span>
                            </a>
                        </li>
                        
                        <li class="header text-uppercase">ASSESSMENT</li>
<?php if ($user_group == 2):
// FOR LECTURERS ONLY
?>
                        <li class="create_assessment">
                            <a href="<?php echo site_url('public/assessment/new'); ?>">
                                <i class="fa fa-pencil-square"></i> <span>Create</span>
                            </a>
                        </li>
                        <li class="<?=active_link_controller('assessment')?>">
                            <a href="<?php echo site_url('public/assessment/question'); ?>">
                                <i class="fa fa-question-circle"></i> <span>Questions</span>
                            </a>
                        </li>
                        <li class="<?php if(active_link_function('submited') OR active_link_function('submited_view')){ echo 'active'; } ?>">
                            <a href="<?php echo site_url('public/evaluation/submited'); ?>">
                                <i class="fa fa-book"></i> <span>Submited</span>
                            </a>
                        </li>
                        <li class="<?=active_link_function('result')?>">
                            <a href="<?php echo site_url('public/evaluation/result'); ?>">
                                <i class="fa fa-check"></i> <span>Results</span>
                            </a>
                        </li>
<?php endif; ?>

<?php if ($user_group == 3):
// FOR STUDENTS ONLY
?>
                        <li class=" <?php if((active_link_controller('evaluation') AND active_link_function('index')) OR active_link_function('view') ){ echo 'active'; } ?>">
                            <a href="<?php echo site_url('public/evaluation/index'); ?>">
                                <i class="fa fa-edit"></i> <span>New</span>
                            </a>
                        </li>
                        <li class="<?php if(active_link_function('submited') OR active_link_function('submited_view')){ echo 'active'; } ?>">
                            <a href="<?php echo site_url('public/evaluation/submited'); ?>">
                                <i class="fa fa-book"></i> <span>Submited</span>
                            </a>
                        </li>
                        <li class="<?=active_link_function('result')?>">
                            <a href="<?php echo site_url('public/evaluation/result'); ?>">
                                <i class="fa fa-check"></i> <span>Results</span>
                            </a>
                        </li>
<?php endif; ?>
                        <li class="header text-uppercase">My Profile</li>

<?php if ($user_group == 2):
// FOR LECTURERS ONLY
?>
                        <li class="<?php if(active_link_controller('users') AND active_link_function('lecturer_students')){ echo 'active'; }; ?>">
                            <a href="<?php echo site_url('public/users/lecturer_students/');?>">
                                <i class="fa fa-users"></i> <span>Students</span>
                            </a>
                        </li>
<?php endif; ?>

<?php if ($user_group == 3):
// FOR STUDENTS ONLY
?>
                        <li class=" <?php if(active_link_controller('users') AND active_link_function('lecturers') ){ echo 'active'; }; ?>">
                            <a href="<?php echo site_url('public/users/lecturers/'); ?>">
                                <i class="fas fa-university"></i> <span>Lecturers</span>
                            </a>
                        </li>
                        <li class="<?php if(active_link_controller('users') AND active_link_function('students')){ echo 'active'; }; ?>">
                            <a href="<?php echo site_url('public/users/students/');?>">
                                <i class="fa fa-suitcase"></i> <span>Cousremates</span>
                            </a>
                        </li>
<?php endif; ?>
                        <li class="">
                            <a href="<?php echo site_url('auth/logout'); ?>">
                                <i class="fa fa-sign-out"></i> <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>
