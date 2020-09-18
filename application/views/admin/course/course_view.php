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
                            <h3 class="card-title"><?php echo anchor('admin/course/add_course', '<i class="fa fa-plus"></i> '. 'Add Course', array('class' => 'btn btn-primary')); ?></h3>
                        </div>
    
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table_datatable table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Unit</th>
                                        <th>Semester</th>
                                        <th>Level</th>
                                        <th>Department</th>
                                        <th>Faculty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($list_course as $row): ?>
                                        <tr>
                                            <td><?= $row['course_code']; ?></td>
                                            <td><?= $row['course_title']; ?></td>
                                            <td><?= $row['course_unit']; ?> Units</td>
                                            <td><?php switch ($row['course_sem']) {
                                                case 1:
                                                    echo 'First';
                                                    break;
                                                
                                                case 2:
                                                    echo 'Second';
                                                    break;
    
                                                default:
                                                    echo 'NULL';
                                                    break;
                                            }; ?> Semester</td>
                                            <td><?= $row['level_name']; ?> Level</td>
                                            <td><?php 
                                            $dept_name = NULL;
                                            $faculty_name = NULL;
    
                                            foreach ($list_dept as $dept):
                                                if($dept['department_id'] == $row['course_dept_id']):
                                                $dept_name = $dept['department_name'];
                                                $faculty_name = $dept['faculty_name'];
                                                endif;
                                            
                                            endforeach;
    
                                            echo $dept_name;
                                        
                                            ?></td>
                                            <td><?= $faculty_name;?></td>
                                            <td>
                                                <a href="<?= site_url('admin/course/edit_course/') . $row['course_id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i>Edit</a>
                                                <a href="<?=base_url()?>admin/course/delete_course/<?=$row['course_id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')";><i class="fas fa-trash"></i>Delete</a>
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

// var_dump($list_dept);

// var_dump($list_course);
