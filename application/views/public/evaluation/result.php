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
                <div class="card col-12">
                    <div class="card-body">
                        <table class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Title</th>
                                    <th>Assessment Name</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
<?php foreach($result as $row): ?>
                                <tr>
                                    <td><?=$row['course_code']?></td>                        
                                    <td><?=$row['course_title']?></td>                        
                                    <td style="text-transform:uppercase;"><?=$row['assessment_name']?></td>                        
                                    <td><?=$row['answer_result']?></td>                        
                                </tr>
<?php endforeach;?>
                            </tbody>
                        </table>
    
                    </div>
    
                </div>
    
            </div>
        </div>
    </section>

</div>