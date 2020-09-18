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
                            <h3 class="card-title"><?php echo anchor('admin/department/add_department', '<i class="fa fa-plus"></i> '. 'Add Department', array('class' => 'btn btn-primary')); ?></h3>
                        </div>
    
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table_datatable table table-striped table-bordered no-margin">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Faculty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($list_department as $row): ?>
                                        <tr>
                                            <td><?= $row['department_name']; ?></td>
                                            <td><?= $row['faculty_name']; ?></td>
                                            <td>
                                                <a href="<?= site_url('admin/department/edit_department/') . $row['department_id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i>Edit</a>
                                                <a href="<?=base_url()?>admin/department/delete_department/<?=$row['department_id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')";><i class="fas fa-trash"></i>Delete</a>
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

    <?php 
    // var_dump($faculty_info);