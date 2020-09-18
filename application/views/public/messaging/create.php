<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/public/js/javascript.js'); ?>"></script>

<div class="content-wrapper">
    <section class="content-header">
        Messaging
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Create Message
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="list-group">
                            <?php foreach($course_mate as $row): ?>
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start prevent" onclick="send_message(<?= $row['id'] ?>);">                             
                                <div class="d-flex w-100 justify-content-between">
                                <h5 style="text-transform:uppercase; font-weight:bold;" class="mb-1"><?= $row['username'] ?></h5>
                                <small style="text-transform:uppercase;"><?= $row['matric_no'] ?></small>
                                </div>
                                <p style="text-transform:uppercase;" class="mb-1"><?= $row['department_name'] ?></p>
                                <small><?php if($row['matric_no'] == null): echo "LECTURER"; else: echo "STUDENT" . "<strong>". $row('matric_no') . "</strong>"; endif; ?></small>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>