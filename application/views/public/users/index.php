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
                <div class="col-12">
                    <div class="card card-solid">
                        <div class="card-body pb-0">
                            <div class="row d-flex align-items-stretch">
<?php foreach($contact as $row):?>
<?php if($row['user_id'] != $this->session->userdata('user_id') ): ?>
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            <?php echo $row['course_code']; ?>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="lead text-capitalize"><b><?= $row['username']; ?></b></h2>
                                                    <p class="text-muted text-sm"><b>Email: </b><?= $row['email'] ?></p>
<?php if($row['group_id'] == 3): ?>
                                                    <p class="text-muted text-sm"><b>Level: </b><?= $row['level'] ?></p>
<?php endif; ?>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Department: <?= $row['department']; ?></li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Matric No: <?= $row['matric_no'];?></li>
                                                    </ul>
                                                </div>
                                                <?php 
if($row['group_id'] == 2){
    $image_path = '/m_001.png';
}elseif($row['group_id'] == 3){
    $image_path = '/'. $row['passport'];
} 
?>
                                                <div class="col-5 text-center">
                                                    <img src="<?= base_url($avatar_dir . $image_path) ?>" alt="" class="img-circle img-fluid">
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <a href="#" class="btn btn-sm bg-teal" onclick="send_message(<?=$row['user_id']; ?>)">
                                                    <i class="fas fa-comments"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-user"></i> View Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php endif; ?>
<?php endforeach; ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <nav aria-label="Contacts Page Navigation">
                                <ul class="pagination justify-content-center m-0">
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>