<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/public/js/javascript.js'); ?>"></script>

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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bell"></i> Notifications
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
<?php foreach($notification as $row): 
    
switch($row['notification_type']){
    case 1:
            $class = 'callout-danger';
        break;
    case 2:
            $class = 'callout-warning';
        break;
    
}
?>
                            <div class="callout <?=$class?>">
                                <h5>
<?php if($row['notification_type'] == 1 ):?>
                                    New Assessment
<?php endif ?>
<?php if($row['notification_type'] == 2 ):?>
                                    <?= $row['course_code'] ?> Result
<?php endif ?>
                                </h5>
                                
                                <p>
                                    <?= $row['notification_body'] ?>
                                </p>

                                <small>
                                    <?=$row['notification_date_added']?>
                                </small>
                            </div>
<?php endforeach; ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

 
</div>


    



