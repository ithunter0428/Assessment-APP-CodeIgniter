<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends Public_Controller
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

        $this->load->model('public/Course_Reg_model','course_reg_model');
        
        // $this->load->model('admin/Course_model','course_model');
       
    }

    public function index($check_new_assessment = null)
    {
        /* Title Page :: Common */
        $this->page_title->push('<i class="fa fa-edit"></i>New Assessment');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'New Assessment', 'public/evaluation');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('public/Assessment_model','ast_model');
        $this->load->model('public/Course_reg_model','course_reg_model');
        $this->load->model('public/Answer_model','answer_log_model');
        $this->load->model('admin/Ses_model','ses_model');

        // GET CURRENT SEMESTER ID
        $current_sem = $this->ses_model->get(['sem_status' => 0]);
        $semester_id = $current_sem[0]['sem_id'];

        $assessment = $this->ast_model->join_multiple_order([
            'reg_course'=>'reg_course_id',
            'school_course'=>'course_id',
        ],'assessment_course','assessment_date_added','A',
        ['reg_user_id' => $this->session->userdata('user_id'),
        'assessment_access' => 1]);

        $my_assessment = [];

        foreach($assessment as $row){
            if($answer_log = $this->answer_log_model->get([
                'answer_log_user_id' => $this->session->userdata('user_id'),
                'answer_assessment_id' => $row['assessment_id'],
                'answer_status' => 0,
                ])){
                array_push($my_assessment,$row);
            }elseif(! $answer_log = $this->answer_log_model->get([
                'answer_log_user_id' => $this->session->userdata('user_id'),
                'answer_assessment_id' => $row['assessment_id'],
                'answer_status' => 1,
                ])){
                array_push($my_assessment,$row);
            };
        }

        $this->data['assessment'] = $my_assessment;

        if($check_new_assessment == 1 AND (count($my_assessment) > 0)):
            $this->output->set_content_type('application_json');
            $this->output->set_output(json_encode(['result' => true,'count' => count($my_assessment)]));
        else:
            $this->template->public_render('public/evaluation/index',$this->data);
        endif;

        // $this->load->view('test',$data);
    }

    public function view($assessment_id)
    {
        $this->load->model('public/Assessment_model','ast_model');

        $assessment_log = $this->ast_model->join_multiple_order(['school_course' => 'course_id'],'assessment_course','assessment_id','R',['assessment_id' => $assessment_id]);

        switch ($assessment_log[0]['assessment_type']) {
            case 1:
                // LIVE ASSESSMENT
                $current_time = new dateTime();
                $end_time = new dateTime($assessment_log[0]['assessment_end_time']);

                if ($current_time > $end_time){
                    // THE ASSESSMENT END TIME HAS PASSED
                    $this->data['duration'] = false;
                    $this->submit($assessment_id);
                    redirect(site_url('/'),'refresh');
                }else{
                    // THE REMAINING ASSESSMENT TIME
                    $end_time = date('m-d-Y H:i:s',strtotime($assessment_log[0]['assessment_end_time']));
                    $this->data['current_time'] = date('m-d-Y H:i:s');
                    $this->data['duration'] = $end_time;
                }
                break;
            
            default:
                // DEADLINE ASSESSMENT
                $duration = $assessment_log[0]['deadline'];
                break;
        }

        $this->data['assessment'] = $assessment_log;
        $this->data['question_type'] = $assessment_log[0]['question_type'];
        $this->data['assessment_id'] = $assessment_log[0]['assessment_id'];

        // FOR QUESTION LINKS
        switch ($assessment_log[0]['question_type']) {
            case 2:
                $this->load->model('public/Essay_model','essay_model');

                $question = $this->essay_model->order('essay_question_date','R',['assessment_essay_id' => $assessment_id]);
                break;
            
            case 1:
                $this->load->model('public/Obj_model','obj_model');
                $question = $this->obj_model->order('obj_question_date','R',['assessment_obj_id' => $assessment_id]);

                $no_question = $assessment_log[0]['no_question'];
                $total_mark = $assessment_log[0]['total_mark'];
                $this->data['total_num_question'] = $assessment_log[0]['no_question'];

                $this->data['average_mark'] = number_format($total_mark/$no_question,0);
                break;

            default:
                # code...
                break;
        }

        $this->data['question_link'] = $question;

        $this->template->public_render('public/evaluation/view',$this->data);
    }

    public function get_question($question_type,$question_id,$assessment_id)
    {
        // THIS FUNCTION IS TO BE CALLED BY AN AJAX CALL
        switch ($question_type) {
            case 2:
                $this->load->model('public/Essay_model','essay_model');

                if($question = $this->essay_model->join(
                    'answer_essay_log',
                    'answer_question_id',
                    'essay_question_id',
                    ['essay_question_id' => $question_id,
                    'answer_user_id' => $this->session->userdata('user_id')])
                    ){
                    $answer = $question[0]['answer'];
                }else{
                    $question = $this->essay_model->get(['essay_question_id' => $question_id],1);
                    $answer = "";
                }

                $this->output->set_content_type('application_json');
                $this->output->set_output(json_encode([
                    'question' => $question[0]['essay_question'],
                    'mark' => $question[0]['essay_question_mark'],
                    'answer' => $answer,
                    ]));
                break;
            
            case 1:
                $this->load->model('public/Obj_model','obj_model');
             
                if($question = $this->obj_model->join(
                    'answer_obj_log',
                    'answer_question_id',
                    'obj_question_id',
                    ['obj_question_id' => $question_id,
                    'answer_user_id' => $this->session->userdata('user_id')])
                    ){
                    $answer = $question[0]['answer'];
                }else{
                    $question = $this->obj_model->get(['obj_question_id' => $question_id],1);
                    $answer = null;
                }

                $this->output->set_content_type('application_json');
                $this->output->set_output(json_encode([
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

    public function answer($question_type,$question_id,$assessment_id)
    {
        // THIS FUNCTION IS TO SUBMIT AND UPDATE ANSWERS
        // CHECK IF USER POSTED AN ANSWER
        $answer = $this->input->post('answer');
        
        switch ($question_type) {
            case 2:
                $this->load->model('public/Essay_answer_model','answer_model');
                break;
            
            case 1:
                $this->load->model('public/Obj_answer_model','answer_model');
                break;

            default:
                # code...
                break;
        }
        // TO CHECK
        $value = $this->answer_model->get([
            'answer_assessment_id' => $assessment_id,
            'answer_question_id' => $question_id,
            'answer_user_id' => $this->session->userdata('user_id'),
        ],1);

        if($answer != "" AND ! $value){
            // TO IF THIS ANSWER HAS NOT INSERTED BY THE USER BEFORE INSERT
            $this->load->model('public/Answer_model','answer_log_model');

            if(!$answer_log = $this->answer_log_model->get([
                // IF THE ANSWER LOG DOSE NOT EXIST CREATE IT 
                'answer_assessment_id' => $assessment_id,
                'answer_log_user_id' => $this->session->userdata('user_id'),
                ])
            ){
                $answer_log = $this->answer_log_model->insert_return_field([
                'answer_assessment_id' => $assessment_id,
                'answer_log_user_id' =>  $this->session->userdata('user_id'),
                'answer_question_type' => $question_type,
                ]);
            }
            

            $this->answer_model->insert([
                'answer' => $answer,
                'answer_assessment_id' => $assessment_id,
                'answer_question_id' => $question_id,
                'answer_log_id' => $answer_log[0]['answer_id'],
                'answer_user_id' => $this->session->userdata('user_id'),
                'answer_date_added' => date("Y-m-d H:i:s"),
            ]); 
        }elseif($answer != "" AND $value){
            // IF AN ANSWER IS INSERTED AND HAS INSERTED BY THE USER BEFORE UPDATE
            $this->answer_model->update([
                // WHERE
                'answer_assessment_id' => $assessment_id,
                'answer_question_id' => $question_id,
                'answer_user_id' => $this->session->userdata('user_id'),
            ],
            [
                // UPDATE VALUE
                'answer' => $answer,
                'answer_date_added' => date("Y-m-d H:i:s"),
            ]); 
        }

        $this->output->set_content_type('application_json');
        $this->output->set_output(json_encode(['result' => $value]));
    }

    public function submit($assessment_id)
    {
        $this->load->model('public/Answer_model','answer_log_model');
        $this->load->model('public/Assessment_model','assessment_model');

        // $assessment_log = $this->assessment_model->get(['assessment_id' => $assessment_id]);
        $assessment_log = $this->assessment_model->join_multiple(
            ['school_course' => 'course_id'],
            'assessment_course',
            ['assessment_id' => $assessment_id]
        );

        $answer_log = $this->answer_log_model->get([
            'answer_log_user_id' => $this->session->userdata('user_id'),
            'answer_assessment_id' => $assessment_id,],1);

        if($answer_log){
            $this->answer_log_model->update(['answer_id' => $answer_log[0]['answer_id']],
            ['answer_status' => 1]);
        }else{
            $answer_log = $this->answer_log_model->insert_return_field([
                'answer_assessment_id' => $assessment_id,
                'answer_log_user_id' => $this->session->userdata('user_id'),
                'answer_question_type' => $assessment_log[0]['assessment_id'],
                'answer_status' => 1,
                ]);
        } 
        
        // TO MARK OBJ ANSWERS
        if ($assessment_log[0]['question_type'] == 1){
            $this->load->model('public/Obj_answer_model','obj_answer_model');
            $this->load->model('public/Obj_model','obj_model');

            $obj_answer = $this->obj_answer_model->get(['answer_log_id' => $answer_log[0]['answer_id']],1);
            $obj_question = $this->obj_model->get(['assessment_obj_id' => $assessment_id]);

            // TO CHECK AVERAGE MARK
            $no_question = $assessment_log[0]['no_question'];
            $total_mark = $assessment_log[0]['total_mark'];
            
            if(($no_question == 0 OR null) OR ($total_mark == 0 OR null)){
                return;
            }

            $average_mark = $total_mark/$no_question;

            // var_dump($average_mark);

            $this->answer_log_model->update(['answer_id' => $answer_log[0]['answer_id']],
            ['answer_result' => 0]);

            foreach ($obj_answer as $row){

                // CHECK THE QUESTION FOR THE ANSWER
                foreach ($obj_question as $value){
                    if(($row['answer_question_id'] == $value['obj_question_id'])
                     AND ($row['answer'] == $value['obj_question_ans'])){
                        // IF THE ANSWER IS CORRECT
                        $this->answer_log_model->increment_by('answer_result',$average_mark,['answer_id' => $answer_log[0]['answer_id']]);
                    }
                }
            }

            $this->answer_log_model->update(['answer_id' =>  $answer_log[0]['answer_id']],['mark_status' => 1]);

            $this->send_notification_user($answer_log[0]['answer_log_user_id'],$assessment_log);
        }

        $this->output->set_content_type('application_json');
        $this->output->set_output(json_encode(['result' => 1]));
    }

    public function submited()
    {
        /* Title Page :: Common */
        $this->page_title->push('<i class="fa fa-book"></i>Submited');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Submited', 'public/evaluation/submited');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('public/Assessment_model','ast_model');
        $this->load->model('public/Course_reg_model','course_reg_model');
        $this->load->model('public/Answer_model','answer_log_model');
        $this->load->model('admin/Ses_model','ses_model');

        // GET CURRENT SEMESTER ID
        $current_sem = $this->ses_model->get(['sem_status' => 0]);
        $semester_id = $current_sem[0]['sem_id'];

        $assessment = $this->ast_model->join_multiple_order([
            'reg_course'=>'reg_course_id',
            'school_course'=>'course_id',
        ],'assessment_course','assessment_date_added','A',
        ['reg_user_id' => $this->session->userdata('user_id'),
        'assessment_access' => 1]);

        $my_assessment = [];

        foreach($assessment as $row){
            if($answer_log = $this->answer_log_model->get([
                'answer_log_user_id' => $this->session->userdata('user_id'),
                'answer_assessment_id' => $row['assessment_id'],
                'answer_status' => 1,
                ])){
                array_push($my_assessment,$row);
            };
        }

        $this->data['assessment'] = $my_assessment;

        $this->data['submited'] = true;

        $this->template->public_render('public/evaluation/index',$this->data);

    }

    public function submited_view($assessment_id)
    {
        $this->load->model('public/Assessment_model','ast_model');

        $assessment_log = $this->ast_model->join_multiple_order(['school_course' => 'course_id'],'assessment_course','assessment_id','R',['assessment_id' => $assessment_id]);

        $this->data['assessment'] = $assessment_log;
        $this->data['question_type'] = $assessment_log[0]['question_type'];
        $this->data['assessment_id'] = $assessment_log[0]['assessment_id'];

        // FOR QUESTION LINKS
        switch ($assessment_log[0]['question_type']) {
            case 2:
                $this->load->model('public/Essay_model','essay_model');
                $question = $this->essay_model->order('essay_question_date','R',['assessment_essay_id' => $assessment_id]);
                
                break;
            
            case 1:
                $this->load->model('public/Obj_model','obj_model');
                $question = $this->obj_model->order('obj_question_date','R',['assessment_obj_id' => $assessment_id]);

                $no_question = $assessment_log[0]['no_question'];
                $total_mark = $assessment_log[0]['total_mark'];
                $this->data['total_num_question'] = $assessment_log[0]['no_question'];

                
                $this->data['average_mark'] = number_format($total_mark/$no_question,0);
                break;

            default:
                # code...
                break;
        }

        $this->data['submited'] = true;

        $this->data['question_link'] = $question;

        // IF JAVASCRIPT AND JQUERY SCRIPT HAS ALREADY BEEN CALLED IN THE VIEW THIS 
        // $this->data['js'] = FALSE; SHOULD DE SET TO AVOID CALLING IT TWICE
        $this->data['js'] = FALSE;
        // END

        $this->template->public_render('public/evaluation/view',$this->data);
    }

    public function result()
    {
        /* Title Page :: Common */
        $this->page_title->push('<i class="fa fa-check"></i> Results');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Results', 'evaluation/reult');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('public/Assessment_model','assessment_model');
        $this->load->model('public/Answer_model','answer_log_model');
        $this->load->model('admin/Course_model','course_model');

        $result = $this->answer_log_model->join_multiple_order(
            ['assessment_log' => 'assessment_id'],
            'answer_assessment_id',
            'answer_date_added',
            'D',
            ['answer_log_user_id' => $this->session->userdata('user_id'),
            'answer_status' => 1,
            'mark_status' => 1]
        );

        foreach($result as &$row){
            $course = $this->course_model->get(['course_id' => $row['assessment_course']]);
            // array_push($row,['course_title' => $course[0]['course_title']]);
            $row['course_code'] = $course[0]['course_code'];
            $row['course_title'] = $course[0]['course_title'];
        }

        $this->data['result'] = $result;

        $this->template->public_render('public/evaluation/result',$this->data);
    }

    public function test()
    {
        $this->load->model('public/Obj_answer_model','answer_model');
        $new = $value = $this->answer_model->get(['answer_assessment_id' => 1],1);

        if(!$new){
            $data['new'] = "ok";
        }

        $this->load->view('test',$data);
    }
}