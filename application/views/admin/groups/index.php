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
                                        <h3 class="card-title"><?php echo anchor('admin/groups/create', '<i class="fa fa-plus"></i> '. lang('groups_create'), array('class' => 'btn btn-primary')); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-reponsive table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('groups_name');?></th>
                                                    <th><?php echo lang('groups_description');?></th>
                                                    <th><?php echo lang('groups_color');?></th>
                                                    <th><?php echo lang('groups_action');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <?php foreach ($groups as $values):?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($values->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($values->description, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><i class="fa fa-stop" style="color:<?php echo $values->bgcolor; ?>"></i></td>
                                                    <td>
                                                    <?php if($values->id != 1): ?>
                                                    <?php echo anchor("admin/permission/index/".$values->id,'<i class="fas fa-folder"></i>' . lang('actions_see'),['class' => 'btn btn-primary btn-sm' ]); ?>
                                                    <?php endif ?>
                                                    <?php echo anchor("admin/groups/edit/".$values->id,'<i class="fas fa-pencil-alt"></i>' . lang('actions_edit'),['class' => 'btn btn-info btn-sm' ]); ?></td>
                                                </tr>
    <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </section>
            </div>
