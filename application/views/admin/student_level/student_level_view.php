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
                            <h3 class="card-title"><?php echo anchor('admin/student_level/add_level', '<i class="fa fa-plus"></i> '. 'Add Level', array('class' => 'btn btn-block btn-primary')); ?></h3>
                        </div>
    
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($list_level as $row): ?>
                                        <tr>
                                            <td><?= $row['level_name']; ?></td>
                                            <td width="20%">
                                                <a href="<?= site_url('admin/student_level/edit_level/') . $row['level_id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i>Edit</a>
                                                <a href="<?=base_url()?>admin/student_level/delete_level/<?=$row['level_id']?>" onclick="return confirm('Are you sure?')"; class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>