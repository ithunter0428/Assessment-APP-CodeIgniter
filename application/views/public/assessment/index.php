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
                            <div class="card">
                                <div class="card-header with-border">
                                    <h3 class="card-title"><?php echo anchor('#', '<i class="fa fa-pencil-square"></i> '. 'Create Assessment', array('class' => 'create_assessment btn btn-primary')); ?></h3>
                                </div>
                
                                <div class="card-body table-responsive">
                                    <table class="table_datatable table table-head-fixed" style ="display:table">
                                        <thead>
                                            <tr>
                                                <th>Assessment Name</th>
                                                <th>Course code</th>
                                                <th>Question Type</th>
                                                <th>Assessment Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php foreach($all_question as $row): ?>
                                            <tr id="assessment-row-<?= $row['assessment_id']; ?>">
                                                <td class="text-uppercase" ><a href="submited/<?= $row['assessment_id']; ?>"><?= $row['assessment_name']; ?></a></td>
                                                <td><?= $row['course_code']; ?></td>
                                                <td class="text-uppercase"><?php if($row['question_type'] == 1 ){ echo 'objectives'; }else{ echo'essay';} ?></td>
                                                <td class="text-uppercase"><?php if($row['assessment_type'] == 1 ){ echo 'Live'; }else{ echo 'Deadline';} ?></td>
                                                <td><?= date("F jS, Y H:i a",strtotime($row['assessment_date_added'])); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                        if ($row['assessment_access'] == 0){
                                                            $class = 'badge-success';
                                                            $text = 'Send';
                                                        }elseif($row['assessment_access'] == 1){
                                                            $class = 'badge-primary';
                                                            $text = 'Sent';
                                                        }elseif($row['assessment_access'] == 2){
                                                            $class = 'badge-danger ';
                                                            $text = 'Overdue';
                                                        }
                                                    ?>
                                                    <span id="assessment-badge-<?=$row['assessment_id']?>" class="badge <?=$class ?>"><?=$text?></span>
                                                </td>
                                                <td class="text-right" >
                                                    <a class="btn btn-info btn-sm" href="<?= site_url('public/assessment/view/') . $row['assessment_id']; ?>">
                                                        <i class="fas fa-pencil-alt"></i>Edit
                                                    </a>
                                                    <button class="assessment-button-<?= $row['assessment_id']; ?> btn btn-primary btn-sm" onclick=" send_assessment(<?=$row['assessment_id']?>)" <?php if ($row['assessment_access'] == (1||2)){echo 'disabled';} ?>>
                                                        <i class="fas fa-folder"></i>send
                                                    </button>
                                                    <button class="prevent_default assessment-button-<?= $row['assessment_id']; ?> btn btn-danger btn-sm" onclick="confirm_delete_assessment(<?=$row['assessment_id']?>)" <?php if ($row['assessment_access'] == (1||2)){echo 'disabled';} ?>>
                                                        <i class="fas fa-trash"></i>Delete
                                                    </button>
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

<script>
    function confirm_delete_assessment(assessment_id){
        $.confirm({
            title: 'Delete',
            content: 'Do you want to delete this assessment?',
            type: 'red',
            buttons: {
                delete:{
                    text: 'Delete',
                    btnClass: 'btn-danger',
                    action: function(){
                        showLoadingOverlay()
                        $.getJSON('http://localhost/assessment_app/public/assessment/delete/' + assessment_id,
                            function(o){
                                hideLoadingOverlay()
                                if(o.result == true){
                                    $('#assessment-row-' + assessment_id).hide()
                                    toastr.success('Asessment has been deleted!')
                                }else{
                                    toastr.error('Unable to delete')
                                }
                        })
                    }
                },
                close: {
                    text: 'Cancel',
                    btnClass: 'btn-success',
                    action: function(){

                    }
                }
            }
        })
    }
</script>