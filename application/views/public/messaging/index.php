<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
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
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Conversations</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" placeholder="Search Mail">
                                        <div class="input-group-append">
                                            <div class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                    </button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-reply"></i></button>
                                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i></button>
                                    </div>
                                    <!-- /.btn-group -->
                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                                    <div class="float-right">
                                        1-50/200
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button>
                                        </div>
                                        <!-- /.btn-group -->
                                    </div>
                                    <!-- /.float-right -->
                                </div>
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        <tbody>
<?php foreach($conversation as $row): 
if($row['passport'] == null){
    $image_path = '/m_001.png';
}else{
    $image_path = '/'. $row['passport'];
} 
?>
                                        <tr>
                                            <td>
                                                <div class="icheck-primary">
                                                    <input type="checkbox" value="" id="<?= $row['messaging_id'] ?>">
                                                    <label for="<?= $row['messaging_id'] ?>"></label>
                                                </div>
                                            </td>
                                            <td><img class="direct-chat-img" src="<?= base_url($avatar_dir . $image_path) ?>" alt="passport"></td>
                                            <td class="mailbox-name text-uppercase "><a href="<?=base_url();?>/public/messaging/open/<?php
if($row['messaging_from'] == $this->session->userdata['user_id']){
    echo $row['messaging_to'];
}elseif($row['messaging_to'] == $this->session->userdata['user_id']){
    echo $row['messaging_from'];
}
                            ?>"><?= $row['username'] ?></a></td>
                                            <td class="mailbox-subject"><?php echo substr($row['messaging_body'],0,50) ?>
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date"><?php if($row['matric_no'] == null): echo "LECTURER"; else: echo "STUDENT" . "<strong>(". $row['matric_no'] . ")</strong>"; endif; ?></td>
                                        </tr>
<?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer p-0">
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                    </button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-reply"></i></button>
                                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i></button>
                                    </div>
                                    <!-- /.btn-group -->
                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-sync-alt"></i></button>
                                    <div class="float-right">
                                        1-50/200
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button>
                                        </div>
                                        <!-- /.btn-group -->
                                    </div>
                                    <!-- /.float-right -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>        
        </div>
    </section>
</div>


