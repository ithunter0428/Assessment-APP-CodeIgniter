<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
.chat {
	border: 2px solid #dedede;
	background-color: #f1f1f1;
	border-radius: 5px;
	padding: 10px;
	margin: 10px 0;
}

.darker {
	border-color: #ccc;
	background-color: #ddd;
	text-align: right;
}

.chat::after {
	content: "";
	clear: both;
	display: table;
}

.chat img {
	float: left;
	max-width: 60px;
	width: 100%;
	margin-right: 20px;
	border-radius: 50%;
}

.chat img.right {
	float: right;
	margin-left: 20px;
	margin-right:0;
}

.time-right {
	float: right;
	color: #aaa;
}

.time-left {
	float: left;
	color: #999;
}
</style>

<script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/public/js/javascript.js'); ?>"></script>

<div class="content-wrapper">
		<section>
			<div class="container">
				<div class="row pt-4">
					<div class="col">
						<!-- DIRECT CHAT PRIMARY -->
						<div class="card card-prirary cardutline direct-chat direct-chat-primary">
							<div class="card-header">
								<h3 class="card-title">Conversation</h3>

								<div class="card-tools">
									<span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary"><?= $no_unread ?></span>
								</div>
							</div>

							<div class="card-header">
								<form action="<?php echo base_url() ?>public/messaging/send/<?=$conversation_user[0]['id']?>" class="ajax_submit" method="post">
									<div class="input-group">
										<input type="text" name="message" placeholder="Type Message ..." class="form-control">
										<span class="input-group-append">
											<button type="submit" class="ajax_button btn btn-primary">Send</button>
										</span>
									</div>
								</form>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<!-- Conversations are loaded here -->
								<div class="direct-chat-messages" style="height: 75%;">
<?php 

foreach($conversation_message as $row):

if($row['group_id'] == 2 OR $row['group_id'] == 1){
		$image_path = '/m_001.png';
}elseif($row['group_id'] == 3){
		$image_path = '/'.$row['passport'];
} 

if($row['messaging_from'] != $this->session->userdata('user_id')):
?>
									<!-- Message to the right -->
									<div class="direct-chat-msg right">
										<div class="direct-chat-infos clearfix">
											<span class="direct-chat-name float-right"><?= $conversation_user[0]['username']?></span>
											<span class="direct-chat-timestamp float-left"><?=$row['messaging_date_added'];?></span>
										</div>
										<!-- /.direct-chat-infos -->
										<img class="direct-chat-img" src="<?=base_url($avatar_dir . $image_path)?>" alt="Message User Image">
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
											<?=$row['messaging_body']?>
										</div>
										<!-- /.direct-chat-text -->
									</div>
									<!-- /.direct-chat-msg -->
<?php elseif($row['messaging_from'] == $this->session->userdata('user_id')): ?>
									<!-- Message. Default to the left -->
									<div class="direct-chat-msg">
										<div class="direct-chat-infos clearfix">
											<span class="direct-chat-name float-left"><?php echo $user_login['firstname'].$user_login['lastname']; ?></span>
											<span class="direct-chat-timestamp float-right"><?=$row['messaging_date_added'];?></span>
										</div>
										<!-- /.direct-chat-infos -->
										<img class="direct-chat-img" src="<?=base_url($avatar_dir . $image_path)?>" alt="Message User Image">
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
											<?=$row['messaging_body']?>
										</div>
										<!-- /.direct-chat-text -->
									</div>
									<!-- /.direct-chat-msg -->
<?php endif; ?>
<?php endforeach; ?>
								</div>
								<!--/.direct-chat-messages-->
							</div>
							<!-- /.card-body -->
							
							<!-- /.card-footer-->
						</div>
						<!--/.direct-chat -->
					</div>
				</div>
			</div>
		</section>
</div>
