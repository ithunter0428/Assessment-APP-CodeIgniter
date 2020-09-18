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

                <section class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?php echo $count_users?></h3>

                                        <p>Users</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <a href="<?php echo base_url(); ?>admin/users" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo $count_lecturers ?><sup style="font-size: 20px"></sup></h3>

                                        <p>Lecturers</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <a href="<?php echo base_url(); ?>admin/users" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3><?php echo $count_students ?></h3>

                                        <p>Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <a href="<?php echo base_url(); ?>admin/users" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3><?php echo $count_groups ?></h3>

                                        <p>Security Groups</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <a href="<?php echo base_url(); ?>admin/groups" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i><i class="fa fa-shield">
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
    
                        <div class="row">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header with-border">
                                            <h3 class="card-title">CONTROL</h3>
                                            <div class="card-tools pull-right">
                                                <button type="button" class="btn btn-card-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- <div class="col-md-6">
                                                    <p class="text-center"><strong>xxx</strong></p>
                                                </div> -->
                                                <div class="col-md-12">
                                                    <p class="text-center text-uppercase"><strong>SCHOOL SEMESTER CONTROL PANEL</strong></p>
                                                        <?php if ($sem_status == 0): ?>
                                                            <p class="card-title">
                                                            <strong>Start Semester</strong>
                                                            </p>
                                                        
                                                        
                                                        <div class="card-body">
                                                            <?php $error = $this->form_validation->error_array();
                                                            foreach ($error as $error){
                                                                echo '<li>'.$error.'</li>';
                                                            }
                                                            ?>
        
                                                            <?php
                                                            
                                                            echo form_open(site_url('admin/dashboard/start_sem'), array('class' => 'form-horizontal', 'id' => 'form-create_user store_add_form')); 
                                                            ?>   
                                                            <div class="form-group col-sm-12">
                                                                <div class="col-sm-2 control-label">
                                                                    <strong>Timeline</strong>
                                                                </div>
                                                                <?php 
                                                                    $input = ['name' => 'ses_name', 'class' => 'class="col-sm-10"'];
                                                                    echo form_input($input);
                                                                ?>
                                                            </div>
        
                                                            <div class="form-group col-sm-12">
                                                                <div class="col-sm-2 control-label">
                                                                    <strong>Semester</strong>
                                                                </div>
        
                                                                <?php
                                                                    $option = [ 1 => 'First Semester', 2 => 'Second Semester'];
                                                                    
                                                                    echo form_dropdown('sem_name',$option,'class="col-lg-10"');
                                                                    ?>
                                                            </div>
                                                        
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-2 col-sm-10">
                                                                    <div class="btn-group">
                                                                        <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => 'Start')); ?>
                                                                        <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => 'Reset')); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php echo form_close();?>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                            
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>Semester</th>
                                                                <th>Timeline</th>
                                                                <th>Begin Date</th>
                                                                <th>End Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach($list_ses as $row): ?>
                                                                <tr>
                                                                    <td><?php switch ($row['sem_name']) {
                                                                                    case 1:
                                                                                        echo 'First';
                                                                                        break;
                                                                                    
                                                                                    case 2:
                                                                                        echo 'Second';
                                                                                        break;
        
                                                                                    default:
                                                                                        echo 'NULL';
                                                                                        break;
                                                                                }; ?> Semester</td>
                                                                    <td><?= $row['ses_name']; ?></td>
                                                                    <td><?= $row['sem_begin_date']; ?></td>
                                                                    <td><?= $row['sem_end_date']; ?></td>
                                                                    <td>
                                                                    <?php if($row['sem_status'] == 0):?>
                                                                        <a href="<?=base_url()?>admin/dashboard/end_sem/<?=$row['sem_id']?>" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure')";>End Semester</a>
                                                                    <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </section>
            </div>
