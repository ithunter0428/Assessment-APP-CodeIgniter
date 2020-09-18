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

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title"><?php echo anchor('public/assessment/compile_result/'.$assessment_id,'Compile Results', array('class' => 'btn btn-primary')); ?></h3>
                        </div>
        
                        <div class="card-body">
                            <table class="table table-striped table-bordered" style ="display:table">
                                <thead>
                                    <tr>
                                        <th>Matric no</th>
                                        <th>Name</th>
                                        <th>Date Submited</th>
                                        <th>Time Submited</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php foreach($answer_log as $row): ?>
                                    <tr>
                                        <td><a href="<?= $row['answer_id']; ?>"><?= $row['matric_no']; ?></a></td>
                                        <td style="text-transform: uppercase;"><?= $row['username']; ?></td>
                                        <td><?= date("F jS, Y", strtotime($row['answer_date_added'])); ?></td>
                                        <td><?= date("H:i a", strtotime($row['answer_date_added'])); ?></td>
                                        <td>
                                            <?php
                                                if ($row['mark_status'] == 0){
                                                    $class = 'btn btn-success';
                                                    $text = 'Mark';
                                                    $disabled = '';
                                                }elseif($row['mark_status'] == 1){
                                                    $class = 'btn btn-default prevent_default';
                                                    $text = 'Marked';
                                                    $disabled = 'disabled';
                                                }
                                            ?>     
                                            <h3 style ="margin:0;" class="card-title"><a class = "<?=$class?>"
                                            <?php if ($row['answer_id'] == 0): ?>
                                            onclick=""
                                            <?php endif; ?>
                                            href="<?= site_url('public/assessment/mark/'.$assessment_id.'/'.$row['answer_log_user_id'])?>" <?= $disabled?>><?=$text?></a> </h3>                             
                                        </td>
                                    </tr>
<?php endforeach; ?>
                                </tbody>
                            </table>
<?php if( empty($answer_log)): ?>
                            <div class="card-group d-flex justify-content-center my-2">
                                No Assessment Has Been Submitted
                            </div>
<?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>