<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Get class name
        $path = explode('\\', __CLASS__);
        $class_name = array_pop($path);
        $class_name;

        // CHECK IF USER HAS PERMISSION TO THIS FUNCTION
        if ( ! $this->ion_auth->logged_in() OR ! $this->get_permission($class_name))
		{
			redirect('auth/login', 'refresh');
        }

        // TO CHECK IF USER HAS REGISTERED COURES FOR THAT SEMESTER
        if (! $this->check_reg() ){
            redirect('public/course_reg/register_course', 'refresh');
        }
        
        /* Data */
        $this->data['title'] = $this->config->item('title');

        $this->load->model('public/Course_Reg_model','course_reg_model');
        
        // $this->load->model('admin/Course_model','course_model');
       
    }
    
    public function check_assessment()
    {
        $this->form_validation->set_rules('assessment_name','Assessment name', 'required');
        $this->output->set_content_type('application_json');

        if ($this->form_validation->run() == TRUE){
            $this->output->set_output(json_encode(['result' => 1,'type' => $this->input->post('assessment_type'),'question_type' => $this->input->post('question_type'),]));
        }
        else{
            $this->output->set_output(json_encode(['result' => 0,'error' => $this->form_validation->error_array()]));
        }
    }

    public function create()
    {
        $this->load->model('public/Assessment_model','ast_model');
        $this->load->model('admin/Ses_model','ses_model');

        $sem_info = $this->ses_model->get(['sem_status' => 0],1);
        $this->output->set_content_type('application_json');

        $name = null;

        if ($this->input->post('mytype') == 'number' ){
            $name = 'duration';
        }elseif($this->input->post('mytype') == 'date' ){
            $name = 'deadline';
        }

        $this->form_validation->set_rules('type_input',$name,'required|greater_than[0]|is_numeric');

        if ($this->input->post('question_type') == 1){
            $this->form_validation->set_rules('total_mark','Total Mark','required|greater_than[0]|is_numeric');
        }

        if ($this->form_validation->run() == TRUE){
            switch ($name) {
                case 'duration':
                    $row = $this->ast_model->insert_return_field([
                        'assessment_name' => $this->input->post('assessment_name'),
                        'assessment_user_id' => $this->session->userdata('user_id'),
                        'assessment_sem' => $sem_info[0]['sem_id'],
                        'assessment_course' => $this->input->post('assessment_course'),
                        'assessment_type' => $this->input->post('assessment_type'),
                        'question_type' => $this->input->post('question_type'),
                        'assessment_date_added' => date("Y-m-d h:i"),
                        'duration' => $this->input->post('type_input'),
                        'total_mark' => $this->input->post('total_mark'),]);
                    break;

                case 'deadline':
                    $d = strtotime($this->input->post('type_input'));

                    $row = $this->ast_model->insert_return_field([
                        'assessment_name' => $this->input->post('assessment_name'),
                        'assessment_user_id' => $this->session->userdata('user_id'),
                        'assessment_sem' => $sem_info[0]['sem_id'],
                        'assessment_course' => $this->input->post('assessment_course'),
                        'assessment_type' => $this->input->post('assessment_type'),
                        'question_type' => $this->input->post('question_type'),
                        'assessment_date_added' => date("Y-m-d h:i"),
                        'deadline' => date("Y-m-d",$d),
                        'total_mark' => $this->input->post('total_mark'),]);
                    break;
                
                default:
                    # code...
                    break;
            }
            $this->output->set_output(json_encode(['result' => 1,'ast_id' => $row[0]['assessment_id']]));
        }else{
            $this->output->set_output(json_encode(['result' => 0,'error' => $this->form_validation->error_array()]));
        }
    }

    public function question()
    {
        $this->load->model('public/Assessment_model','ast_model');

        /* Title Page */
        $this->page_title->push('<i class="fa fa-question-circle"></i> Questions');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Questions', 'public/course_reg');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['course'] = $this->course_reg_model->join('school_course','course_id','reg_course_id',['reg_user_id' => $this->session->userdata('user_id')]);
        // $info = $this->ast_model->order('assessment_date_added','D',['assessment_user_id' => $this->session->userdata('user_id')]);

        $info = $this->ast_model->join_multiple_order([
            'reg_course'=>'reg_course_id',
            'school_course'=>'course_id',
        ],'assessment_course','assessment_date_added','D',
        ['reg_user_id' => $this->session->userdata('user_id')]);
        
        // 1 means live
        // 2 means Deadline

        $this->data['all_question'] = $info;

        $this->template->public_render('public/assessment/index',$this->data);
    }

    public function view($ast_id)
    {
        $this->load->model('public/Assessment_model','ast_model');
        $info = $this->ast_model->get(['assessment_id' => $ast_id],1);
        
        $this->data['assessment_id'] = $info[0]['assessment_id'];

        $type = $info[0]['question_type'];
        // 2 means essay
        // 1 means objective

        $this->data['question_type'] = $type;

        switch ($type) {
            case 2:
                $this->load->model('public/Essay_model','essay_model');
                $question = $this->essay_model->order('essay_question_date','D',['assessment_essay_id' => $ast_id]);

                $this->data['total_num_question'] = $info[0]['no_question'];
                $this->data['average_mark'] = $this->essay_model->sum('essay_question_mark',['assessment_essay_id' => $ast_id]);
                break;
            
            case 1:
                $this->load->model('public/Obj_model','obj_model');
                $question = $this->obj_model->order('obj_question_date','D',['assessment_obj_id' => $ast_id]);

                $no_question = $info[0]['no_question'];
                $total_mark = $info[0]['total_mark'];
                $this->data['total_num_question'] = $info[0]['no_question'];

                if($no_question != 0 AND $total_mark != 0){
                    $this->data['average_mark'] = number_format($total_mark/$no_question,2);
                }else{
                    $this->data['average_mark'] = 0;
                }
                
                break;

            default:
                # code...
                break;
        }

        /* Title Page :: Common */
		$this->page_title->push($info[0]['assessment_name']);
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, $info[0]['assessment_name'], 'public/asessment/view/'.$ast_id);
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['question'] = $question;

        $this->template->public_render('public/assessment/view',$this->data);   
    }

    public function add_question($question_type,$ast_id)
    {
        $this->output->set_content_type('application_json');

        switch ($question_type) {
            case 2:
                // ESSAY
                $this->form_validation->set_rules('essay_question', 'Question', 'required|min_length[4]');
                $this->form_validation->set_rules('essay_mark', 'Mark', 'required|greater_than[0]');

                if ($this->form_validation->run() == TRUE){
                    $this->load->model('public/Essay_model','essay_model');
                    $this->load->model('public/Assessment_model','ast_model');

                    $this->essay_model->insert([
                        'assessment_essay_id' => $ast_id,
                        'essay_question' => $this->input->post('essay_question'),
                        'essay_question_mark' => $this->input->post('essay_mark'),
                        'essay_question_date' => date('YmdHis'),
                    ]);

                    // TO ADD 1 TO THE NUMBER OF QUESTIONS
                    $this->ast_model->increment('no_question',['assessment_id' => $ast_id]);

                    $this->output->set_output(json_encode(['result' => 'success','message'=>'Question Added Successfully','url' => '/public/assessment/view/' . $ast_id]));
                }else{
                    $this->output->set_output(json_encode(['result' => 'error','error' => $this->form_validation->error_array(),'input' => $question_type ]));
                }
                break;
            
            case 1:
                // OBJ
                $this->form_validation->set_rules('obj_question', 'Question', 'required|min_length[4]');
                $this->form_validation->set_rules('obj_a', 'Option A', 'required');
                $this->form_validation->set_rules('obj_b', 'Option B', 'required');
                $this->form_validation->set_rules('obj_c', 'Option C', 'required');
                $this->form_validation->set_rules('obj_d', 'Option D', 'required');
                $this->form_validation->set_rules('answer', 'Answer', 'required');

                if ($this->form_validation->run() == TRUE){
                    $this->load->model('public/Obj_model','obj_model');
                    $this->load->model('public/Assessment_model','ast_model');
                    
                    $answer = $this->input->post('answer');

                    $this->obj_model->insert([
                        'assessment_obj_id' => $ast_id,
                        'obj_question' => $this->input->post('obj_question'),
                        'obj_option_A' => $this->input->post('obj_a'),
                        'obj_option_B' => $this->input->post('obj_b'),
                        'obj_option_C' => $this->input->post('obj_c'),
                        'obj_option_D' => $this->input->post('obj_d'),
                        'obj_question_ans' => $this->input->post('obj_'.$answer),
                        'obj_question_date' => date('YmdHis'),
                    ]);

                    // TO ADD 1 TO THE NUMBER OF QUESTIONS
                    $this->ast_model->increment('no_question',['assessment_id' => $ast_id]);

                    $this->output->set_output(json_encode(['result' => 'success','message'=>'Question Added Successfully','url' => '/public/assessment/view/' . $ast_id]));
                }else{
                    $this->output->set_output(json_encode(['result' => 'error','error' => $this->form_validation->error_array(),'input' => $question_type ]));
                }
                break;

            default:
                $this->output->set_output(json_encode(['result' => 'error','error' => 'Assessment type error contact your provider']));
                break;
        }
    }

    public function get_answer($answer,$option_a,$option_b,$option_c,$option_d){
        switch ($answer) {
            case $option_a:
                return 'a';
                break;
            case $option_b:
                return 'b';
                break;
            case $option_c:
                return 'c';
                break;
            case $option_d:
                return 'd';
                break;
            default:
                # code...
                break;
        }
    }

    public function get_question($type,$id)
    {       
        switch ($type) {
            case 2:
                $this->load->model('public/Essay_model','essay_model');
                $question = $this->essay_model->get(['essay_question_id' => $id]);

                $this->output->set_content_type('application_json');
                $this->output->set_output(json_encode([
                    'type' => 1,
                    'question' => $question[0]['essay_question'],
                    'mark' => $question[0]['essay_question_mark'],
                ]));
                break;
            
            case 1:
                $this->load->model('public/Obj_model','obj_model');
                $question = $this->obj_model->get(['obj_question_id' => $id]);

                $answer = $this->get_answer(
                    $question[0]['obj_question_ans'],
                    $question[0]['obj_option_A'],
                    $question[0]['obj_option_B'],
                    $question[0]['obj_option_C'],
                    $question[0]['obj_option_D']
                );

                $this->output->set_content_type('application_json');
                $this->output->set_output(json_encode([
                    'type' => 2,
                    'question' => $question[0]['obj_question'],
                    'option_A' => $question[0]['obj_option_A'],
                    'option_B' => $question[0]['obj_option_B'],
                    'option_C' => $question[0]['obj_option_C'],
                    'option_D' => $question[0]['obj_option_D'],
                    'answer' => $answer,
                ]));


                break;

            default:
                # code...
                break;
        }
        
    }

    public function update_question($question_type,$question_id,$ast_id)
    {
        $this->output->set_content_type('application_json');

        switch ($question_type) {
            case 2:
                // ESSAY
                $this->form_validation->set_rules('essay_question', 'Question', 'required|min_length[4]');

                if ($this->form_validation->run() == TRUE){
                    $this->load->model('public/Essay_model','essay_model');

                    $this->essay_model->update(['essay_question_id' => $question_id],
                        ['assessment_essay_id' => $ast_id,
                        'essay_question' => $this->input->post('essay_question'),
                        'essay_question_mark' => $this->input->post('essay_mark'),
                        'essay_question_date' => date('YmdHis'),
                    ]);

                    $this->output->set_output(json_encode(['result' => true,'message'=>'Question Edited Successfully']));
                }else{
                    $this->output->set_output(json_encode(['result' => 'error','error' => $this->form_validation->error_array(),'input' => $question_type ]));
                }
                break;
            
            case 1:
                // OBJ
                $this->form_validation->set_rules('obj_question', 'Question', 'required|min_length[4]');
                $this->form_validation->set_rules('obj_a', 'Option A', 'required');
                $this->form_validation->set_rules('obj_b', 'Option B', 'required');
                $this->form_validation->set_rules('obj_c', 'Option C', 'required');
                $this->form_validation->set_rules('obj_d', 'Option D', 'required');
                $this->form_validation->set_rules('answer', 'Answer', 'required');

                if ($this->form_validation->run() == TRUE){
                    $this->load->model('public/Obj_model','obj_model');
                    
                    $answer = $this->input->post('answer');

                    $this->obj_model->update(['obj_question_id' => $question_id],
                        ['assessment_obj_id' => $ast_id,
                        'obj_question' => $this->input->post('obj_question'),
                        'obj_option_A' => $this->input->post('obj_a'),
                        'obj_option_B' => $this->input->post('obj_b'),
                        'obj_option_C' => $this->input->post('obj_c'),
                        'obj_option_D' => $this->input->post('obj_d'),
                        'obj_question_ans' => $this->input->post('obj_'.$answer),
                        'obj_question_date' => date('YmdHis'),
                    ]);

                    $this->output->set_output(json_encode(['result' => true,'message'=>'Question Edited Successfully']));
                }else{
                    $this->output->set_output(json_encode(['result' => 'error','error' => $this->form_validation->error_array(),'input' => $question_type ]));
                }
                break;

            default:
                $this->output->set_output(json_encode(['result' => 0,'error' => 'Assessment type error contact your provider']));
                break;
        }
    }

    public function send($assessment_id)
    {
        $this->load->model('public/Assessment_model','ast_model');

        $info = $this->ast_model->join('school_course','course_id','assessment_course',['assessment_id' => $assessment_id]);

        switch ($info[0]['assessment_type']) {
            case 1:
                // LIVE
                $duration = $info[0]['duration'];
                $start_time = date('Y-m-d H:m');
                $end_time = date('Y-m-d H:m',strtotime('+' . $duration . 'minutes'));

                $this->ast_model->update(['assessment_id' => $assessment_id],
                ['assessment_start_time' => $start_time,
                'assessment_end_time' => $end_time,
                'assessment_access' => 1]);
                $name_type = $info[0]['duration'].' minutes live '.$info[0]['assessment_name'].' which starts now. ';

                $this->output->set_content_type('application_json');
                $this->output->set_output(json_encode(['result' => 1]));
                break;

            case 2:
                // DEADLINE
                $this->ast_model->update(['assessment_id' => $assessment_id],['assessment_access' => 1]);
                $name_type = $info[0]['assessment_name'].' to be submitted before ' . date('F jS, Y H:s:a',strtotime($info[0]['deadline']));

                $this->output->set_content_type('application_json');
                $this->output->set_output(json_encode(['result' => 1]));
                break;
            
            default:
                # code...
                break;
        }

        $this->send_notification($info[0]['assessment_course'],$info[0]['assessment_id'],'You have a new assessment on ' .$info[0]['course_title'].' '.$name_type);

    }

    public function check_deadline()
    {
        // THIS FUNCTION IS TO BE RUN BY A CRON SERVICE EVERY DAY TO CHECK ASESSMENT THAT HAS PASSED ITS DEALINE,
        // AND CHANGE THIER ASSESSMENT ACCESS IN THE DB

        $this->load->model('public/Assessment_model','ast_model');

        $all_assessment = $this->ast_model->get(['assessment_access' => 1]);

        $output = 0;

        foreach ($all_assessment as $row){
            if($row['assessment_type'] == 2 ){
                // DEADLINE ASSESSMENT
                $deadline = new dateTime($row['deadline']);

            }elseif($row['assessment_type'] == 1){
                // LIVE ASSESSMENT
                $deadline = new dateTime($row['assessment_end_time']);
            }

            $current_date = new dateTime();

            $diff = 0;

            if($deadline != null){
                // TO AVOID NULL ERRORS
                $diff = date_diff($current_date,$deadline);
            

                if($diff->format('%R%a') < 0){
                    $this->ast_model->update(['assessment_id' => $row['assessment_id']],['assessment_access' => 2]);
                    $output ++;
                }
            }
            
        }

        // $data['output'] = $output;
        // $this->load->view('test',$data);
    }

    public function submited($assessment_id)
    {
        /* Title Page :: Common */
        $this->page_title->push('Submitted Assessment');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Submitted Assessment', 'public/assessment/submited/'.$assessment_id);

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['assessment_id'] = $assessment_id;

        $this->load->model('public/Answer_model','answer_log_model');

        $this->data['answer_log'] = $this->answer_log_model->join_multiple_order(
            ['users' => 'id',],
            'answer_log_user_id',
            'answer_date_added',
            'D',
            ['answer_assessment_id' => $assessment_id,
            'answer_status' => 1]
        );

        $this->template->public_render('public/assessment/submited',$this->data);
    }

    public function compile_result($assessment_id)
    {
        /* Title Page :: Common */
        $this->page_title->push('Compile');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Compile', 'public/assessment/compile_result');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('public/Assessment_model','assessment_model');
        $this->load->model('public/Answer_model','answer_log_model');

        $assessment_log = $this->assessment_model->join_multiple_order(
            ['school_course' => 'course_id',],
            'assessment_course',
            'course_id',
            'A',
            ['assessment_id' => $assessment_id,]
        );

        $this->data['course_code'] = $assessment_log[0]['course_code'];

        $this->data['result'] = $this->answer_log_model->join_multiple_order(
            ['users' => 'id',],
            'answer_log_user_id',
            'matric_no',
            'A',
            ['answer_assessment_id' => $assessment_id,
            'answer_status' => 1,
            'mark_status' => 1]
        );

        $this->template->public_render('public/assessment/compile',$this->data);
    }

    public function mark($assessment_id,$user_id)
    {
        /* Title Page :: Common */
        $this->page_title->push('Mark');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Mark', 'public/assessment/mark');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('public/Essay_answer_model','essay_answer_model');
        $this->load->model('public/Essay_model','essay_model');

        $this->data['total_score'] = $this->essay_model->sum('essay_question_mark',['assessment_essay_id' => $assessment_id]);
        $this->data['score'] = $this->essay_model->sum('essay_score',['assessment_essay_id' => $assessment_id]);

        $this->data['answer'] = $this->essay_answer_model->join_multiple_order(
            ['essay_question' => 'essay_question_id'],
            'answer_question_id',
            'answer_question_id',
            'A',
            ['answer_assessment_id' => $assessment_id,
            'answer_user_id' => $user_id]);

        $this->data['assessment_id'] = $assessment_id;
        $this->data['user_id'] = $user_id;

        // IF JAVASCRIPT AND JQUERY SCRIPT HAS ALREADY BEEN CALLED IN THE VIEW THIS 
        // $this->data['js'] = FALSE; SHOULD DE SET TO AVOID CALLING IT TWICE
        $this->data['js'] = FALSE;
        // END

        $this->template->public_render('public/assessment/mark',$this->data);
    }

    public function get_mark_question($assessment_id,$user_id,$question_id)
    {
        $this->load->model('public/Essay_answer_model','essay_answer_model');

        $essay_answer_log = $this->essay_answer_model->join_multiple(
            ['essay_question' => 'essay_question_id'],
            'answer_question_id',
            ['answer_assessment_id' => $assessment_id,
            'answer_user_id' => $user_id,
            'answer_question_id' => $question_id],1);

        $this->output->set_content_type('application_json');
        $this->output->set_output(json_encode([
            'question' => $essay_answer_log[0]['essay_question'],
            'answer' => $essay_answer_log[0]['answer'],
            'mark' => $essay_answer_log[0]['essay_question_mark'],
            'current_mark' => $this->essay_answer_model->sum('answer_essay_score',['answer_assessment_id' => $assessment_id,'answer_user_id' => $user_id,]),
            'score' => $essay_answer_log[0]['answer_essay_score'],
        ]));
    }

    public function submit_score($assessment_id,$user_id,$question_id)
    {
        $answer = $this->input->post('essay_answer_mark');

        if($answer != ""){
            $this->load->model('public/Essay_answer_model','essay_answer_model');

            $this->essay_answer_model->update(
                ['answer_assessment_id' => $assessment_id,
                'answer_user_id' => $user_id,
                'answer_question_id' => $question_id],
                ['answer_essay_score' => $answer]);
        }
        $this->output->set_content_type('application_json');
        $this->output->set_output(json_encode(['result' => true]));
    }

    public function finish_marking($assessment_id,$user_id)
    {
        $this->load->model('public/Answer_model','answer_log_model');
        $this->load->model('public/Essay_answer_model','essay_answer_model');

        $this->answer_log_model->update([
            'answer_log_user_id' => $user_id,
            'answer_assessment_id' => $assessment_id],
            ['mark_status' => 1,
            'answer_result' => $this->essay_answer_model->sum('answer_essay_score',['answer_assessment_id' => $assessment_id,'answer_user_id' => $user_id,]),
            ]);

        // redirect(,'refresh');
        $this->output->set_content_type('application_json');
        $this->output->set_output(json_encode([
            'result' => true,
            'message' => 'Marking Completed',
            'url'=> '/public/assessment/submited/'.$assessment_id,
        ]));
    }

    public function delete($assessment_id)
    {
        $this->output->set_content_type('application_json');

        $this->load->model('public/Assessment_model','assessment_model');
        $this->load->model('public/Answer_model','answer_log_model');
        
        $this->load->model('public/Essay_model','essay_model');
        $this->load->model('public/Obj_model','obj_model');
        
        $this->load->model('public/Essay_answer_model','essay_answer_model');
        $this->load->model('public/Obj_answer_model','obj_answer_model');

        $this->assessment_model->delete(['assessment_id' => $assessment_id]);
        $this->answer_log_model->delete(['answer_assessment_id' => $assessment_id]);
        $this->essay_model->delete(['assessment_essay_id' => $assessment_id]);
        $this->obj_model->delete(['assessment_obj_id' => $assessment_id]);
        $this->essay_answer_model->delete(['answer_assessment_id' => $assessment_id]);
        $this->obj_answer_model->delete(['answer_assessment_id' => $assessment_id]);

        $this->output->set_output(json_encode(['result' => true]));
    }

    public function test()
    {
        $this->load->model('public/Assessment_model','ast_model');
        $this->ast_model->increment('no_question',['assessment_id' => 87]);
    }
}