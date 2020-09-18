<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <div class="content-wrapper">
                <section class="content-header text-capitalize ">
                    <div class="row">
                        <div class="col-6">
                            <?php echo $pagetitle; ?>
                        </div>
                        <div class="col-6">
                            <?php echo $breadcrumb; ?>
                        </div>
                    </div>
                </section>


                <section class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                 <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="text-danger">
                                        <?php echo $this->session->flashdata('error'); ?>
                                        </div>
    
                                        <table class="table table-striped table-borderless table-responsive table-hover" style="display:table;">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php echo form_open('public/course_reg/register_course', array('class' => 'form-horizontal', 'id' => 'form-create_user')); ?>
<?php foreach ($user_course as $values):?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($values['course_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($values['course_title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($values['course_unit'], ENT_QUOTES, 'UTF-8'); ?></td>                                              
                                                    <td >
                                                        <div class="icheck-primary d-inline">
                                                            <?php
                                                            $data = ['name' => $values['course_id'],'value' => $values['course_id'],'class' => 'form-control','id' => $values['course_id']];
                                                            echo form_checkbox($data)?>
                                                            <label for="<?= $values['course_id'] ?>"></label>
                                                        </div>                                                    
                                                    </td>
                                                </tr>
<?php endforeach;?>
                                                <tr>
                                                    <td>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <div class="btn-group">
                                                                <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary', 'content' => 'Save')); ?>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    </td>             
                                                </tr>         
                                            <?php echo form_close();?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </section>
            </div>
<?php

