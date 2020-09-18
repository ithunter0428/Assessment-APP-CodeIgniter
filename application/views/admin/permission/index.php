<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <div class="content-wrapper">
                <section class="content-header text-capitalize ">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <?php echo $group[0]['name'].'<i class="fa fa-stop" style="color:'.$group[0]['bgcolor'].'"></i>'.$pagetitle; ?>
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
                                    <div class="card-body">
                                        <div class="text-danger">
                                        <?php echo $this->session->flashdata('error'); ?>
                                        </div>
    
                                        <table class="table table-borderless table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Page Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php echo form_open('admin/permission/index/'.$group[0]['id'].'/1', array('class' => 'form-horizontal', 'id' => 'form-create_user')); ?>
    <?php foreach ($all_links as $values):?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($values['link_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($values['link_des'], ENT_QUOTES, 'UTF-8'); ?></td>                                                
                                                    <td><?php
                                                    $check = FALSE;
                                                    foreach ($permission as $row):
                                                        if ($row['page_id'] == $values['link_id']):
                                                            $check = TRUE;
                                                        endif;
                                                    endforeach;
                                                    
                                                    $data = ['name' => $values['link_name'].$values['link_id'],'value' => $values['link_id'],'checked'=> $check];
                                                    echo form_checkbox($data)?></td>
                                                </tr>
    <?php endforeach;?>
                                                <tr>
                                                    <td>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <div class="btn-group">
                                                                <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary', 'content' => 'Save')); ?>
                                                                <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning', 'content' => lang('actions_reset'))); ?>
                                                                <?php echo anchor('admin/groups', lang('actions_cancel'), array('class' => 'btn btn-default')); ?>
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

