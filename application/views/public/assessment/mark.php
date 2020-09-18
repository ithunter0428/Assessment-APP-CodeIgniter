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
                    <div class="card card-primary">
                        <div class="card-header with-border">
                            <h3 class="col-12 card-title">Question</h3>
                        </div>
                        <div class="card-body">
                            <h4 class="col-12 card-title m-1">Score: <span id="current_mark"><?=$score?></span></h4>
                            <h4 class="col-12 card-title m-1">Total: <?=$total_score?></h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <?php echo $this->session->flashdata('error')?>
    
                            <?php echo form_open(site_url('#'), array('class' => 'form-horizontal ajax_submit', 'id' => 'form_evaluation_submit')); ?>   
    
                            <!-- ESSAY -->
                            <div id="student_question"></div>
                                
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label id="student_answer"></label>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Score</span>
                                </div>
                                <input type="number" name="essay_answer_mark" id="essay_answer_mark" class="form-control" placeholder="Score">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row" id="question_links">
<?php
$i = 0;
foreach($answer as $row):
$i++;
?>
                                <button onclick = "submit_answer(); get_mark_question(<?php echo $row['answer_assessment_id'] . ','. $row['answer_user_id'] . ','. $row['answer_question_id'];?>); current_link(<?php echo $link_id = 'link'.$i ?>);" class="prevent_default" id = <?=$link_id?> > <?=$i?> </button>
<?php endforeach;?>
                            </div>
                            <div class="row my-3">
                                <?php echo form_button(['type' => 'submit','id' => 'finish_marking', 'class' => 'ajax_button btn btn-success', 'content' => 'Finish Marking']); ?>
                            </div>
                                <?php echo form_close();?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

