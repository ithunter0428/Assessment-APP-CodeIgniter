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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><?=$course_code?></h3>
                    </div>
                    <div class="card-body">
<?php foreach($result as $row): ?>
                        <table class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th>Matric Number</th>
                                    <th>Name</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$row['matric_no']?></td>                        
                                    <td style="text-transform:uppercase;"><?=$row['username']?></td>                        
                                    <td><?=$row['answer_result']?></td>                        
                                </tr>
                            </tbody>
                        </table>
<?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>