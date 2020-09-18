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
							<div class="col-md-6">
								 <div class="card">
									<div class="card-header with-border">
										<h3 class="card-title">Information</h3>
									</div>
									<div class="card-body">
										<table class="table table-striped table-hover">
											<tbody>
	<?php foreach ($user_info as $user):?>
		<?php if($this->session->userdata('group_value') == 1):?>
												<tr>
													<th><?php echo lang('users_ip_address'); ?></th>
													<td><?php echo $user->ip_address; ?></td>
												</tr>
		<?php endif;?>
												<tr>
													<th><?php echo lang('users_firstname'); ?></th>
													<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
												</tr>
												<tr>
													<th><?php echo lang('users_lastname'); ?></th>
													<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
												</tr>
												<tr>
													<th><?php echo lang('users_username'); ?></th>
													<td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
												</tr>
												<tr>
													<th><?php echo lang('users_email'); ?></th>
													<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
												</tr>
												<tr>
													<th><?php echo lang('users_created_on'); ?></th>
													<td><?php echo date('d-m-Y', $user->created_on); ?></td>
												</tr>
		<?php if($this->session->userdata('group_value') == 1):?>
												<tr>
													<th><?php echo lang('users_last_login'); ?></th>
													<td><?php echo ( ! empty($user->last_login)) ? date('d-m-Y', $user->last_login) : NULL; ?></td>
												</tr>
												<tr>
													<th><?php echo lang('users_status'); ?></th>
													<td><?php echo ($user->active) ? '<span class="label label-success">'.lang('users_active').'</span>' : '<span class="label label-default">'.lang('users_inactive').'</span>'; ?></td>
												</tr>
		<?php endif;?>	
												<tr>
													<th>Matric number</th>
													<td><?php echo htmlspecialchars($user->matric_no, ENT_QUOTES, 'UTF-8'); ?></td>
												</tr>
												<tr>
													<th>Department</th>
													<td><?php echo htmlspecialchars($department, ENT_QUOTES, 'UTF-8'); ?></td>
												</tr>
	
												<tr>
													<th><?php echo lang('users_phone'); ?></th>
													<td><?php echo $user->phone; ?></td>
												</tr>
												<tr>
													<th><?php echo lang('users_groups'); ?></th>
													<td>
	<?php foreach ($user->groups as $group):?>
														<?php // Disabled temporary !!! ?>
														<?php //echo '<span class="label" style="background:'.$group->bgcolor.'">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>'; ?>
														<?php echo '<span class="label label-default">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>'; ?>
	<?php endforeach?>
													</td>
												</tr>
	<?php endforeach;?>
											</tbody>
										</table>
									</div>
								</div>
							 </div>
	
							<div class="col-md-6">
								 <div class="card">
									<div class="card-header with-border">
										<h3 class="card-title">Passport</h3>
									</div>
									<div class="card-body">
	
									
									<img src="<?php echo base_url($avatar_dir . '/' . $user_info[0]->passport); ?>" style="margin:auto;" alt="User Image">
	
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
