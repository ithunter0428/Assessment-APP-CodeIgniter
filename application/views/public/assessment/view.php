<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-6 text-uppercase">
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
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title text-uppercase col-12">
                                <?php if($question_type == 1){
                                        echo 'Objective';
                                    }elseif($question_type == 2){
                                        echo 'Essay';
                                    }?> 
                                &nbsp QUESTIONS
                            </div>
                            
                            <div class="card-title col-12" id="average_mark">
                                <div class="text-bold">
                                    <?php if($question_type == 1){
                                        echo 'Average mark:';
                                    }elseif($question_type == 2){
                                        echo 'Total mark:';
                                    }?> 
                                </div>
                                <div class=""><?=$average_mark?></div>
                            </div>
    
                            <div class="card-title col-12" id="average_mark">
                                <div class="text-bold">Total:</div>
                                <div class=""><?=$total_num_question?></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <a id="question_go_back_btn" class="btn btn-app" href="<?php echo site_url('public/assessment/view/'. $assessment_id );?>">
                                <i class="fas fa-edit"></i> Add New Question
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card card-primary card-outline">            
                        <div class="card-header">
                            <div class="card-title">Insert Questions</div>
                        </div>
    
                        <div class="card-body">
                            <?php echo $this->session->flashdata('error')?>
    
                            <?php echo form_open(site_url('public/assessment/add_question/'.$question_type.'/'.$assessment_id), array('class' => 'ajax_submit form-horizontal', 'id' => 'form_question_add')); ?>   
    
    <!-- ESSAY -->
    <?php if($question_type == 2): ?>
                            <div class="row">
                                <div class="form-group col" id="question_type_eassy">
                                    <textarea class="form-control" name="essay_question" placeholder="Insert youe the question here" id="" cols="70" rows="10"></textarea>
                                </div>
    
                                <div class="form-group col" >
                                    <div class="col-4 control-label">
                                        <strong>Mark</strong>
                                    </div>
                                    <input type="number" name="essay_mark" placeholder="" class="col-8 form-control" id="essay_mark"/>
                                </div>
                            </div>
    <?php endif; ?>
    <!-- OBJECTIVE -->
    <?php if($question_type == 1): ?>
                            <div class="row" id="question_type_obj">
                                <div class="col-12 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Question</span>
                                        </div>
                                        <input type="text" name="obj_question" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><input type="radio" name="answer" value="a" placeholder="Option A" ></span>
                                        </div>
                                        <input type="text" id="option" name="obj_a" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text">Option A</span></div>
                                    </div>
                                </div>
                                <div class="col-12 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><input type="radio" name="answer" value="b" placeholder="Option B" ></span>
                                        </div>
                                        <input type="text" id="option" name="obj_b" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text">Option B</span></div>
                                    </div>
                                </div>
                                <div class="col-12 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><input type="radio" name="answer" value="c" placeholder="Option C" ></span>
                                        </div>
                                        <input type="text" id="option" name="obj_c" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text">Option C</span></div>
                                    </div>
                                </div>
                                <div class="col-12 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><input type="radio" name="answer" value="d" placeholder="Option D" ></span>
                                        </div>
                                        <input type="text" id="option" name="obj_d" class="form-control">
                                        <div class="input-group-append"><span class="input-group-text">Option D</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php endif ?>
                        <div class="card-group">
                            <div class="form-group">
                                <div class="col">
                                    <?php echo form_button(['type' => 'submit','id' => 'add_question', 'class' => 'ajax_button btn btn-success', 'content' => 'Add']); ?>
                                </div>                                    
                            </div>
                            <?php echo form_close();?>
                            
                            <div id="question_links">
<?php
$i = 0;
foreach($question as $row):
$i++;
?>
                                    <?php 
                                        switch ($question_type) {
                                            case 2: ?> 
                                                <button class="btn btn-primary btn-flat" onclick="get_question(<?php echo $question_type.','.$row['essay_question_id'].','.$row['assessment_essay_id'];?>); current_link(<?php echo $link_id='link'.$i ?>);" id = <?=$link_id?> > <?=$i?> </button>
                                                <?php
                                                break;
                                            
                                            case 1:?> 
                                                <button class="btn btn-primary btn-flat" onclick="get_question(<?php echo $question_type.','.$row['obj_question_id'].','.$row['assessment_obj_id'];?>);  current_link(<?php echo $link_id='link'.$i ?>);" id = <?=$link_id?>> <?=$i?> </button>
                                                <?php
                                                break;
    
                                            default:
                                                # code...
                                                break;
                                        }
                                    ?>
<?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>