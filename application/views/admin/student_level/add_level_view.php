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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">
                        <?php if(isset($level_name)): ?>
                        Edit Level
                        <?php else: ?>
                        Add Level
                        <?php endif; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php $error = $this->form_validation->error_array();
                        foreach ($error as $error){
                            echo '<li>'.$error.'</li>';
                        }
                        ?>

                        <?php
                         if (isset($level_name)) {
                            echo form_open_multipart(site_url('admin/student_level/edit_level_data/'.$level_id), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user store_add_form'));
                        }else{
                            echo form_open(site_url('admin/student_level/add_level_data'), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user store_add_form')); 
                        }
                        ?>   
                        <div class="form-group col-sm-12">
                            
                            <?php if (isset($level_name)){
                                $placeholder = "Edit Level"; 
                                }else{
                                    $placeholder = "Add Level";
                                    $level_name = null;
                                }

                                $input = ['name' => 'level_name', 'value' => $level_name, 'placeholder' => $placeholder, 'class' => 'form-control col-sm-12'];
                                echo form_input($input);
                            ?>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="btn-group">
                                    <?php echo form_button(array('type' => 'submit', 'class' => 'ajax_button btn btn-primary', 'content' => lang('actions_submit'))); ?>
                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning', 'content' => lang('actions_reset'))); ?>
                                    <?php echo anchor('admin/student_level', lang('actions_cancel'), array('class' => 'btn btn-default')); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>