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
            <div class="row">
                <div class="col">
                    <i class="fa fa-mortar-board"></i> Registered Courses For &nbsp
                    <strong>
                    
                    <?php
                        switch ($semester_info[0]['sem_name']) {
                            case '1':
                                echo 'First Semester';
                                break;
                            
                            default:
                                echo 'Second Semester';
                                break;
                        }
                    ?> 
                    </strong>
                    &nbsp
                    <strong>
                    <?=$semester_info[0]['ses_name']; ?> Session
                    </strong>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
    
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Course code</th>
                                        <th>Course title</th>
                                        <th>Unit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $total_unit = 0;
                                        foreach($my_course as $row): 
                                        $total_unit = $total_unit + $row['course_unit'];
                                        ?>
                                        <tr>
                                            <td><?= $row['course_code']; ?></td>
                                            <td><?= $row['course_title']; ?></td>
                                            <td><?= $row['course_unit']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><strong><?=$total_unit?></strong></td>
                                        </tr>
                                    </tfoot>
    
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
