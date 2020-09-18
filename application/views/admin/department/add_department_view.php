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
                            <h3 class="card-title">
                            <?php if(isset($department_name)): ?>
                            Edit Department
                            <?php else: ?>
                            Add Department
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
                            if (isset($department_name)) {
                                echo form_open_multipart(site_url('admin/department/edit_department_data/'.$department_id), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user store_add_form'));
                            }else{
                                echo form_open(site_url('admin/department/add_department_data'), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user store_add_form')); 
                            }
                            ?>   
                            <div class="form-group col">
                                <div class="control-label">
                                    <strong>Department Name</strong>
                                </div>
                                <?php if (isset($department_name)){
                                    $placeholder = "Edit Department"; 
                                    }else{
                                        $placeholder = "Add Department";
                                        $department_name = null;
                                    }
    
                                    $input = ['name' => 'department_name', 'value' => $department_name, 'placeholder' => $placeholder, 'class' => 'form-control col-sm-12'];
                                    echo form_input($input);
                                ?>
                            </div>
    
                            <div class="form-group col-12">
                                <div class="control-label">
                                    <strong>Faculty</strong>
                                </div>
    
                                <?php
                                    $option = [];
                                    foreach ($faculty_name as $value){
                                        $option += [$value['faculty_id'] => $value['faculty_name']];
                                    }
    
                                    if (isset($department_name)){
                                        echo form_dropdown('department_faculty_id',$option,$faculty_id,['class' => 'form-control col-12']);
                                    }else{
                                        echo form_dropdown('department_faculty_id',$option,'',['class' => 'form-control col-12']);
                                    }
                                    ?>
                            </div>
    
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="btn-group">
                                        <?php echo form_button(array('type' => 'submit', 'class' => 'ajax_button btn btn-primary', 'content' => lang('actions_submit'))); ?>
                                        <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning', 'content' => lang('actions_reset'))); ?>
                                        <?php echo anchor('admin/department', lang('actions_cancel'), array('class' => 'btn btn-default btn')); ?>
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