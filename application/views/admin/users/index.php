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
										<h3 class="card-title"><?php echo anchor('admin/users/create', '<i class="fa fa-plus"></i> '. lang('users_create_user'), array('class' => 'btn btn-primary')); ?></h3>
									</div>
									<div class="card-body">
										<table class="table_datatable table table-striped table-hover table-responsive" style="display:table" >
											<thead>
												<tr>
													<th><?php echo lang('users_firstname');?></th>
													<th><?php echo lang('users_lastname');?></th>
													<th><?php echo lang('users_email');?></th>
													<th><?php echo lang('users_groups');?></th>
													<th><?php echo lang('users_status');?></th>
													<th><?php echo lang('users_action');?></th>
												</tr>
											</thead>
											<tbody>
	<?php foreach ($users as $user):?>
												<tr>
													<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
													<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
													<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
													<td>
	<?php
	
	foreach ($user->groups as $group)
	{
	
		// Disabled temporary !!!
		// echo anchor('admin/groups/edit/'.$group->id, '<span class="label" style="background:'.$group->bgcolor.';">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>');
		echo anchor('admin/groups/edit/'.$group->id, '<span class="badge badge-primary">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>');
	}
	
	?>
													</td>
													<td><?php echo ($user->active) ? anchor('admin/users/deactivate/'.$user->id, '<span class="badge badge-success">'.lang('users_active').'</span>') : anchor('admin/users/activate/'. $user->id, '<span class="badge badge-default">'.lang('users_inactive').'</span>'); ?></td>
													<td>
														<?php echo anchor('admin/users/edit/'.$user->id,'<i class="fas fa-pencil-alt"></i>' . lang('actions_edit'),['class' => 'btn btn-info btn-sm'] ); ?>
														<?php echo anchor('admin/users/profile/'.$user->id,'<i class="fas fa-folder"></i>' . lang('actions_see'),['class' => 'btn btn-primary btn-sm']); ?>
													</td>
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
