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
                            <div class="col-md-12">
                                 <div class="card">
                                    <div class="card-header with-border">
                                        <h3 class="card-title"><?php echo lang('users_create_user'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <?php echo form_open(base_url().'admin/users/create_data', array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user')); ?>
                                            <div class="form-group">
                                                <?php echo lang('users_firstname', 'first_name', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($first_name);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('users_lastname', 'last_name', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($last_name);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class = 'col-sm-2 control-label'>
                                                    <strong>Matric No</strong>
                                                </div>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($matric_no);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class = 'col-sm-2 control-label'>
                                                    <strong>Faulty</strong>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select id="faculty" name="faculty" class="form-control">
                                                        <option value="">Select a faculty</option>
                                                        <?php foreach($faculty as $row): ?>
                                                        <option value="<?=$row['faculty_id']?>"><?=$row['faculty_name']?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class = 'col-sm-2 control-label'>
                                                    <strong>Department</strong>
                                                </div>
                                                <div class="col-sm-10">
                                                    <?php 
                                                    // echo form_dropdown('department',$option,'form-control');
                                                    ?>
                                                    <select id="department" name="department" class="form-control"> 
                                                        <option value="">Select a Department</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('users_email', 'email', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($email);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('users_phone', 'phone', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($phone);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('users_password', 'password', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($password);?>
                                                    <div class="progress" style="margin:0">
                                                        <div class="pwstrength_viewport_progress"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('users_password_confirm', 'password_confirm', array('class' => 'col-sm-2 control-label')); ?>
                                                <div class="col-sm-10">
                                                    <?php echo form_input($password_confirm);?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <div class="btn-group">
                                                        <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary ajax_button', 'content' => lang('actions_submit'))); ?>
                                                        <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning', 'content' => lang('actions_reset'))); ?>
                                                        <?php echo anchor('admin/users', lang('actions_cancel'), array('class' => 'btn btn-default')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </section>
            </div>
