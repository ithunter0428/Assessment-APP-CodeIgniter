<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/public/js/javascript.js'); ?>"></script>

<div class="content-wrapper">
    <section class="content-header">
        Indox
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="list-group">
                            <?php foreach($message as $row): ?>
                            <div style="padding:5px;">
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start prevent <?php if($row['view_status'] == 0){echo "active";} ?> " onclick="open_message(<?= $row['messaging_id'] ?>);">                         
                                <div class="d-flex w-100 justify-content-between">
                                <h5 style="text-transform:uppercase; font-weight:bold;" class="mb-1"><?= $row['username'] ?></h5>
                                <p><?php echo substr($row['messaging_body'],0,50) ?></p>
                                </div>
                                <small><?php if($row['matric_no'] == null): echo "LECTURER"; else: echo "STUDENT" . "<strong>(". $row['matric_no'] . ")</strong>"; endif; ?></small>
                            </a>
                            </div>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>