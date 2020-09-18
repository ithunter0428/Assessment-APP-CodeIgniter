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
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo base_url($avatar_dir . '/m_001.png'); ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $user_login['firstname'].$user_login['lastname']; ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url("admin/dashboard") ?>" class="nav-link <?=active_link_controller('dashboard')?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <!-- <i class="right fas fa-angle-left"></i> -->
                            </p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase"><?php echo lang('menu_administration'); ?></li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/users'); ?>" class="nav-link <?=active_link_controller('users')?>">
                            <i class="nav-icon far fa-user"></i>
                            <p>
                                <?php echo lang('menu_users'); ?>
                                <!-- <span class="badge badge-info right">2</span> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/faculty'); ?>" class="nav-link <?=active_link_controller('faculty')?>">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Faculty
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/department'); ?>" class="nav-link <?=active_link_controller('department')?>">
                            <i class="nav-icon fas fa-university"></i>
                            <p>
                                Department
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/student_level'); ?>" class="nav-link <?=active_link_controller('student_level')?>">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                Levels
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/course'); ?>" class="nav-link <?=active_link_controller('course')?>">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Courses
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/groups'); ?>" class="nav-link <?=active_link_controller('groups')?>">
                            <i class="nav-icon fas fa-shield-alt"></i>
                            <p>
                                <?php echo lang('menu_security_groups'); ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link <?=active_link_controller('prefs')?>">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                <?php echo lang('menu_preferences'); ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo site_url('admin/prefs/interfaces/admin'); ?>" class="nav-link <?=active_link_function('interfaces')?>">
                                    <!-- <i class="fas fa-sliders-h "></i> -->
                                    <p><?php echo lang('menu_interfaces'); ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header text-uppercase"><?php echo $title; ?></li>
                    <li class="nav-item">
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