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
                            <?php if(isset($course_id)): ?>
                            Edit Course
                            <?php else: ?>
                            Add Course
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
                            if (isset($course_id)) {
                                echo form_open_multipart(site_url('admin/course/edit_course_data/'.$course_id), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user store_add_form'));
                            }else{
                                echo form_open(site_url('admin/course/add_course_data'), array('class' => 'ajax_submit form-horizontal', 'id' => 'form-create_user store_add_form')); 
                            }
                            ?>   
                            <div class="form-group col">
                            <div class="col-12 control-label font-weight-bold">Course Code</div>
                                <?php if (! isset($course_id)){
                                    $course_code = NULL;
                                    }
    
                                    $input = ['name' => 'course_code', 'value' => $course_code, 'class' => 'form-control col-12'];
                                    echo form_input($input);
                                ?>
                            </div>
    
                            <div class="form-group col-12">
                            <div class="col-12 control-label font-weight-bold">Course Title</div>
                                <?php if (! isset($course_id)){
                                    $course_title = NULL;
                                    }
    
                                    $input = ['name' => 'course_title', 'value' => $course_title, 'class' => 'form-control col-12'];
                                    echo form_input($input);
                                ?>
                            </div>
    
                            <div class="form-group col-12">
                            <div class="col-12 control-label font-weight-bold">Credit Unit</div>
                                <?php if (! isset($course_id)){
                                    $course_unit = NULL;
                                    }
    
                                    $input = ['name' => 'course_unit', 'value' => $course_unit, 'class' => 'form-control col-12'];
                                    echo form_input($input);
                                ?>
                            </div>
    
                            <div class="form-group col-12">
                                <div class="col-12 control-label font-weight-bold">Semester</div>
                                <?php
                                    $option = [1 => 'First Semester', 2 => 'Second Semester'];
    
                                    if (isset($course_id)){
                                        echo form_dropdown('course_sem',$option,$course_sem,['class' => 'form-control col-12']);
                                    }else{
                                        echo form_dropdown('course_sem',$option,'',['class' => 'form-control col-12']);
                                    }
                                    ?>
                            </div>
    
                            <div class="form-group col-12">
                                <div class="col-12 control-label font-weight-bold">Level</div>
                                <?php
                                    $option = [];
                                    foreach ($list_level as $value){
                                        $option += [$value['level_id'] => $value['level_name']];
                                    }
    
                                    if (isset($course_id)){
                                        echo form_dropdown('course_level_id',$option,$level_id,['class' => 'form-control col-12']);
                                    }else{
                                        echo form_dropdown('course_level_id',$option,'',['class' => 'form-control col-12']);
                                    }
                                    ?>
                            </div>
    
                            <div class="form-group col-12">
                                <div class="col-12 control-label font-weight-bold">Department</div>
                                <?php
                                    $option = [];
                                    foreach ($list_dept as $value){
                                        $option += [$value['department_id'] => $value['department_name']];
                                    }
    
                                    if (isset($course_id)){
                                        echo form_dropdown('course_dept_id',$option,$department_id,['class' => 'form-control col-12']);
                                    }else{
                                        echo form_dropdown('course_dept_id',$option,'',['class' => 'form-control col-12']);
                                    }
                                    ?>
                            </div>
    
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="btn-group">
                                        <?php echo form_button(array('type' => 'submit', 'class' => 'ajax_button btn btn-primary', 'content' => lang('actions_submit'))); ?>
                                        <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning', 'content' => lang('actions_reset'))); ?>
                                        <?php echo anchor('admin/course', lang('actions_cancel'), array('class' => 'btn btn-default')); ?>
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