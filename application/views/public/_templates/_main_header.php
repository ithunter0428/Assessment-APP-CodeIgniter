<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
            <header class="main-header">
                <a href="<?php echo site_url('/'); ?>" class="logo">
                    <span class="logo-mini"><?php echo $title_mini; ?></span>
                    <span class="logo-lg"><?php echo $title_lg; ?><b> ASSESSMENT PORTAL</b></span>
                </a>

                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- Messages -->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success"> <?= $no_unread ?> </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?= $no_unread ?> new message(s) </li>
                                    <li>
                                        <ul class="menu">
                                        <?php foreach($recieved_msg as $msg): 
                                            if($msg['group_id'] == 2 OR $msg['group_id'] == 1){
                                                $image_path = '/m_001.png';
                                            }elseif($msg['group_id'] == 3){
                                                $image_path = '/'.$msg['passport'];
                                            } 
                                            ?>
                                            <li <?php if($msg['view_status'] == 0){echo "style='background:#ddd;'";} ?> ><!-- start message -->
                                                <a href="<?=base_url()?>public/messaging/open/<?=$msg['messaging_from']?>">
                                                    <div class="pull-left">
                                                        <img src="<?php echo base_url($avatar_dir . $image_path); ?>" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4 style="text-transform:capitalize;"><?=$msg['username']?><small><i class="fa fa-clock-o"></i> <?=$msg['messaging_date_added']?></small></h4>
                                                    <p><?php echo substr($msg['messaging_body'],0,20)?></p>
                                                </a>
                                            </li><!-- end message -->
                                        <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="<?=base_url()?>public/messaging"><?php echo lang('header_view_all'); ?></a></li>
                                </ul>
                            </li>

                            <!-- Notifications -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning" id="header_notification"> <?=$no_notification?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have<span id="header_notification"> <?=$no_notification?> </span>new notification(s)</li>
                                    <li>
                                        <ul class="menu">
                                        <?php foreach($recieved_notification as $notifications): ?>
                                            <li class="prevent" onclick="view_notification(<?=$notifications['notification_id']?>);"><!-- start notification -->
                                        <a href="<?=base_url()?>public/notification/"><i class="fa fa-<?php if($notifications['notification_type'] == 1 ): ?>edit<?php else: ?>check<?php endif; ?> text-aqua"></i> <?php echo substr($notifications['notification_body'],0,25); ?> ... </a>
                                            </li><!-- end notification -->
                                        <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="<?=base_url()?>public/notification"><?php echo lang('header_view_all'); ?></a></li>
                                </ul>
                            </li>

<?php if ($admin_prefs['tasks_menu'] == TRUE): ?>
                            <!-- Tasks -->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">0</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo lang('header_you_have'); ?> 0 <?php echo lang('header_task'); ?></li>
                                    <li>
                                        <ul class="menu">
                                            <li><!-- start task -->
                                                <a href="#">
                                                    <h3>Design some buttons<small class="pull-right">20%</small></h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% <?php echo lang('header_complete'); ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#"><?php echo lang('header_view_all'); ?></a></li>
                                </ul>
                            </li>

<?php endif; ?>
<?php if ($admin_prefs['user_menu'] == TRUE): ?>
                            <!-- User Account -->
                            <li class="dropdown user user-menu">
                                
                                <?php if($this->session->userdata('group_value') == 2 OR $this->session->userdata('group_value') == 1){
                                    $image_path = '/m_001.png';
                                }elseif($this->session->userdata('group_value') == 3){
                                    $image_path = '/'.$this->session->userdata('passport');
                                } 
                                
                                ?>

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url($avatar_dir . $image_path); ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $user_login['username']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?php echo base_url($avatar_dir . $image_path); ?>" class="img-circle" alt="User Image">
                                        <p><?php echo $user_login['firstname'].$user_login['lastname']; ?><small><?php echo $this->session->userdata('group_name') ?></small></p>
                                    </li>
<?php if($this->session->userdata('group_value') == 2): 
// FOR LECTURERS ONLY
?>
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <a href="<?php echo site_url('public/users/lecturer_students'); ?>">Students</a>
                                            </div>
                                        </div>
                                    </li>
<?php endif; ?>

<?php if($this->session->userdata('group_value') == 3): 
// FOR STUDENTS ONLY
?>
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <a href="<?php echo site_url('public/users/lecturers'); ?>">Lecturers</a>
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                <a href="<?php echo site_url('public/users/students'); ?>">Coursemates</a>
                                            </div>
                                        </div>
                                    </li>
<?php endif; ?>

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo site_url('public/users/profile/'.$user_login['id']); ?>" class="btn btn-default btn-flat"><?php echo lang('header_profile'); ?></a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-default btn-flat">Logout</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

<?php endif; ?>
<?php if ($admin_prefs['ctrl_sidebar'] == TRUE): ?>
                            <!-- Control Sidebar Toggle Button -->
                            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>
<?php endif; ?>
                        </ul>
                    </div>
                </nav>
            </header>
