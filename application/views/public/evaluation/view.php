<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if(!isset($submited)): ?>
    <script>
        <?php if($assessment[0]['assessment_type'] == 1): ?>
            // TO BE AVAILABLE ONLY IF IT IS A LIVE ASSESSMENT
            var countDownDate = new Date(<?php if($duration != false){echo "'". $duration ."'";}?>).getTime();

        var x = setInterval(function() {
            var now = new Date();

            var distance = countDownDate - now;
                
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById("duration").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

            if (distance <= 0) {
                clearInterval(x);
                document.getElementById("duration").innerHTML = "TIME UP";
                submit_final(<?=$assessment[0]['assessment_id'] ?>);
            }
            
        }, 1000);
        <?php endif;?>

        function confirm_submit_final($user_id,assessment_id){
            $.confirm({
                title: 'Send',
                content: 'Do you want to submit this assessment?',
                type: 'red',
                typeAnimated: true,
                buttons:{
                    confirm: function (){
                        submit_final(<?=$assessment[0]['assessment_id'] ?>);
                    },
                    close: function (){
                        
                    }                                    
                }  
            });
        }
    </script>
<?php endif;?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="card col-12">
                    <div class="card-header text-center">
<?php if(!isset($submited)): ?>
<?php if($assessment[0]['assessment_type'] == 1): 
                        // TO BE AVAILABLE ONLY IF IT IS A LIVE ASSESSMENT?>        
                        <h4>DURATION:<span id="duration"></span> </h4>
<?php endif;?>
<?php endif;?>
        
<?php if($question_type == 1): 
                        // TO BE AVAILABLE ONLY IF IT IS AN OBJ ASSESSMENT?>        
                        <h5>Each question carries <?= $average_mark ?> Marks</h4>
<?php endif;?>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="font-weight:bold;">COURSE CODE</td>
                                <td><?=$assessment[0]['course_code'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">COURSE TITLE</td>
                                <td><?=$assessment[0]['course_title'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">CREDIT UNIT</td>
                                <td><?=$assessment[0]['course_unit'] ?></td>
                            </tr>
                        </tbody>
                        </table>
<?php if(!isset($submited)): ?>
                    <div onclick="confirm_submit_final();" class="float-right col-sm-offset-2 " style="margin:1%;" >
                        <div class="btn-group">
                            <?php echo form_button(['type' => 'submit','id' => 'submit_evaluation', 'class' => 'btn btn-block btn-danger', 'content' => 'Submit']); ?>
                        </div>
                    </div>
                </div>
<?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-header-pills">
                        <div class="card-header with-border">
                            <h3 class="card-title">
                            Question
                            </h3>
                        </div>
    
                        <div class="card-body">
    
                            <?php echo form_open('#', array('class' => 'form-horizontal', 'id' => 'form_evaluation_submit')); ?>   
    
<?php if($question_type == 2): ?>
<!-- ESSAY -->
                            <label id="essay_question"></label><br>
                            <textarea name="answer" class="col-sm-12" placeholder="Answer" id="" cols="30" rows="10" <?php if(isset($submited) AND $submited == true): ?>readonly = "true" style="background: #f1f1f1" <?php endif; ?>></textarea>
<?php endif; ?>
    
<?php if($question_type == 1): ?>
<!-- OBJECTIVE -->
                                <div class="row" id="question_type_obj">
                                    <div class="col-12">
                                        <label id="obj_question"></label>
                                    </div>
                                    
                                    <div class="form-group m-1">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ans_a" name="answer" value="" <?php if(isset($submited) AND $submited == true): ?> onclick ="return false" <?php endif; ?> >
                                            <label for="ans_a"></label>
                                        </div>
                                        <label id="obj_a"></label>
                                    </div>
                                    
                                    <div class="form-group m-1">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ans_b" name="answer" value="" <?php if(isset($submited) AND $submited == true): ?> onclick ="return false" <?php endif; ?> >
                                            <label for="ans_b"></label>
                                        </div>
                                        <label id="obj_b"></label>
                                    </div>
                                    
                                    <div class="form-group m-1">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ans_c" name="answer" value="" <?php if(isset($submited) AND $submited == true): ?> onclick ="return false" <?php endif; ?> >
                                            <label for="ans_c"></label>
                                        </div>
                                        <label id="obj_c"></label>
                                    </div>
                                    
                                    <div class="form-group m-1">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ans_d" name="answer" value="" <?php if(isset($submited) AND $submited == true): ?> onclick ="return false" <?php endif; ?> >
                                            <label for="ans_d"></label>
                                        </div>
                                        <label id="obj_d"></label>
                                    </div>
                                </div>
<?php endif; ?>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    </div>
                                </div>
                            <?php echo form_close();?>
                            
                            <div id="question_links">
<?php
$i = 0;
foreach($question_link as $row):
$i++;

    switch ($question_type) {
        case 2: ?> 
                                            <div class="btn-group m-1">
                                                <button class="btn btn-primary btn-flat" onclick = " <?php if(!isset($submited)): ?> submit_answer(); <?php endif; ?>
                                                get_question_ans(<?php echo $question_type . ','. $row['essay_question_id']. ','. $row['assessment_essay_id'];?>); 
                                                current_link(<?php echo $link_id = 'link'.$i ?>);" id = <?=$link_id?> > <?=$i?> </button>
                                            </div>
                                            
            <?php
            break;
        
        case 1:?> 
                                            <div class="btn-group m-1">
                                                <button class="btn btn-primary btn-flat" onclick = " <?php if(!isset($submited)): ?> submit_answer(); <?php endif; ?>
                                                get_question_ans(<?php echo $question_type . ','. $row['obj_question_id']. ','. $row['assessment_obj_id'];?>); 
                                                current_link(<?php echo $link_id = 'link'.$i ?>);" id = <?=$link_id?> > <?=$i?> </button>
                                            </div>
                                            
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
