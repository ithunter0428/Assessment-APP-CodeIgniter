<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="login-logo">
    <!-- Brand Logo -->
    <div class="row d-flex justify-content-center">
        <a href="<?= base_url() ?>" class="brand-link p-0 pt-5" id="login-brand-logo">
            <div class="media m-0 p-0">
                <img src="<?php echo base_url($dist_dir . '/img/ksu_logo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"style="opacity: .8">
                <div class="media-body text-left m-0 p-0">
                    <h2 class="brand-text text-light text-md text-bold text-uppercase">Kogi State University</h2>
                    <p class="brand-text text-light text-md text-uppercase">Assessment Portal</p>
                </div>
            </div>
        </a>
    </div>
</div>
<!-- /.login-logo -->

<section class="content">
    <div class="row">
        <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-bold">Register</h3>
                    </div>
                    <div class="card-body">
                        <?php echo form_open_multipart(base_url('auth/register_data'), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user', 'role' => 'form')); ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($first_name);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($last_name);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($matric_no);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select id="faculty" class="form-control" name="faculty">
                                        <option value="">Select a faculty</option>
                                        <?php foreach($faculty as $row): ?>
                                        <option class="form-control" value="<?=$row['faculty_id']?>"><?=$row['faculty_name']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                            
                                <div class="col-sm-12">
                                    <select id="department"  class="form-control" name="department"> 
                                        <option class="form-control" value="">Select a Department</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div style="font-weight:bold" class="col-sm-12">
                                    Level
                                </div>
                                <div class="col-sm-12">
                                    <?php echo form_dropdown('level',$level,'',['class' => 'form-control']);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($email);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($phone);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($password);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo form_input($password_confirm);?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="passportInput">Passport</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="passport" class="custom-file-input" id="passportInput">
                                        <label class="custom-file-label" for="passportInput">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="btn-group">
                                        <?php echo form_button(array('type' => 'submit', 'class' => 'ajax_button btn btn-primary', 'content' => 'Register')); ?>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </section>