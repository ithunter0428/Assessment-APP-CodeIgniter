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
                <div class="col">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <table class="table_datatable table table-bordered " style ="display: table;">
                                <thead>
                                <tr>
                                    <th>Assessment Name</th>
                                    <th>Course code</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
<?php foreach($assessment as $row):?>
                                    <tr>
                                        <td class="text-uppercase" ><?= $row['assessment_name']; ?></td>
                                        <td><?= $row['course_code']; ?></td>
                                        <td><?= date("F jS, Y H:i a", strtotime($row['assessment_date_added'])); ?></td>
                                        <td>
<?php if(isset($submited) AND $submited == true): ?>
                                            <div style="margin: 2px;">
                                                <a class="btn btn-success btn-sm" href="<?= site_url('public/evaluation/submited_view/') . $row['assessment_id']; ?>">
                                                    <i class="fas fa-play"></i> View
                                                </a>
                                            </div>
<?php else: ?>
                                            <div style="margin: 2px;">
                                                <a class="btn btn-success btn-sm" href="<?= site_url('public/evaluation/view/') . $row['assessment_id']; ?>">
                                                    <i class="fas fa-play"></i> Start
                                                </a>
                                            </div>
<?php endif; ?>
                                        </td>
                                    </tr>
<?php endforeach; ?>            
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>