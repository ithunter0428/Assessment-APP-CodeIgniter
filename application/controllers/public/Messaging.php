<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messaging extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('public/Messaging_model','messaging_model');

        // TO CHECK IF USER HAS REGISTERED COURES FOR THAT SEMESTER
        if (! $this->check_reg() ){
            redirect('public/course_reg/register_course', 'refresh');
        }
    }

    function get_timeago( $ptime )
    {
        $estimate_time = time() - $ptime;
    
        if( $estimate_time < 1 )
        {
            return 'less than 1 second ago';
        }
    
        $condition = array(
                    12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );
    
        foreach( $condition as $secs => $str )
        {
            $d = $estimate_time / $secs;
    
            if( $d >= 1 )
            {
                $r = round( $d );
                return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

    public function index()
    {
        /* Title Page */
        $this->page_title->push('<i class="fa fa-envelope"></i> Messaging');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Messaging', 'public/messaging');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $message_to = $this->messaging_model->get(['messaging_to' => $this->session->userdata('user_id')]);
        $message_from = $this->messaging_model->get(['messaging_from' => $this->session->userdata('user_id')]);

        $all_id = [];

        foreach ($message_to as $row){
            array_push($all_id,'A'.$row['messaging_from']);
        }
        foreach ($message_from as $row){
            array_push($all_id,'B'.$row['messaging_to']);
        }

        $data['all'] = $all_id;

        $selected_id = [];

        foreach ($all_id as $ids){
            if(( !in_array('A'.substr($ids,1),$selected_id)) AND
            ( !in_array('B'.substr($ids,1),$selected_id)) ){
                array_push($selected_id,$ids);
            }
        }

        $conversation_from = [];
        $conversation_to = [];

        foreach($selected_id as $id){
            if(substr($id,0,1) == 'A'){
                $from = $this->messaging_model->join_multiple_order(
                    ['users' => 'id'],
                    'messaging_from',
                    'messaging_date_added',
                    'D',
                    ['messaging_from' => substr($id,1),
                    'messaging_to' => $this->session->userdata('user_id')]);

                    array_push($conversation_from,$from[0]);
            }elseif(substr($all_id[0],0,1) == 'B'){
                $to = $this->messaging_model->join_multiple_order(
                    ['users' => 'id'],
                    'messaging_to',
                    'messaging_date_added',
                    'D',
                    ['messaging_to' => substr($id,1),
                    'messaging_from' => $this->session->userdata('user_id')]);

                // $to[0]['messaging_added_date'] = $this->get_timeago(strtotime($to[0]['messaging_added_date']));

                    array_push($conversation_to,$to[0]);
            }
        }

        $conversation = [];

        if($conversation_from){
            foreach($conversation_from as $row_from){
                array_push($conversation,$row_from);
            }
        }
        
        if($conversation_to){
            foreach($conversation_to as $row_to){
            array_push($conversation,$row_to);
            }
        }

        usort($conversation, function($a, $b) {
            return $b['messaging_date_added'] <=> $a['messaging_date_added'];
        });

        $this->data['conversation'] = $conversation;

        $this->template->public_render('public/messaging/index',$this->data);
    }

    public function create()
    {
        $this->load->model('admin/Users_model','users_model');
        // $course = $this->users_model->get(['department' => $this->session->userdata('department')]);

        $this->load->model('admin/Ses_model','ses_model');

        $semester = $this->ses_model->get(['sem_status' => 0]);
        $current_sem = $semester[0]['sem_id'];

        $this->load->model('public/Course_Reg_model','course_reg_model');
        $user_course = $this->course_reg_model->get(['reg_user_id' => $this->session->userdata('user_id'),'reg_sem_id' => $current_sem]);

        $course_mate_id = [];

        foreach($user_course as $user){

            $course = $this->course_reg_model->get(['reg_course_id' => $user['reg_course_id']]);

            foreach($course as $other){
                if (! in_array($other['reg_user_id'],$course_mate_id) && $other['reg_user_id'] != $this->session->userdata('user_id') ){
                    array_push($course_mate_id,$other['reg_user_id']);
                }
            }
        }

        $course_mate = [];

        foreach($course_mate_id as $key){
            $course_mate_row = $this->users_model->join_multiple(
                ['school_department' => 'department_id',],
                'department',
                ['id' => $key]
            );

            foreach($course_mate_row as $row){
                array_push($course_mate,$row);
            }
        }

        $this->data['course_mate'] = $course_mate;

        // IF JAVASCRIPT AND JQUERY SCRIPT HAS ALREADY BEEN CALLED IN THE VIEW THIS 
        // $this->data['js'] = FALSE; SHOULD DE SET TO AVOID CALLING IT TWICE
        $this->data['js'] = FALSE;
        // END

        $this->template->public_render('public/messaging/create',$this->data);
    }

    public function send($user_id)
    {
        $this->output->set_content_type('application_json');

        $this->form_validation->set_rules('message','Message', 'required');
        
        if ($this->form_validation->run() == TRUE){

           $this->messaging_model->insert([
            'messaging_to' => $user_id,
            'messaging_body' => $this->input->post('message'),
            'messaging_from' => $this->session->userdata('user_id'),
            'messaging_date_added' => date('Y-m-d H:i:s'),
            'view_status' => 0,
        ]);

            $this->output->set_output(json_encode(['result' => true,'url'=>'/public/messaging/open/'.$user_id,'message'=>'Message Sent'] ));
        }else{
            $this->output->set_output(json_encode(['result' => 'error','error' => $this->form_validation->error_array()]));
        }

        
    }

    public function inbox()
    {
        $this->data['message'] = $this->messaging_model->join_multiple(
            ['users' => 'id'],
            'messaging_from',
            ['messaging_to' => $this->session->userdata('user_id')]);

        // IF JAVASCRIPT AND JQUERY SCRIPT HAS ALREADY BEEN CALLED IN THE VIEW THIS 
        // $this->data['js'] = FALSE; SHOULD DE SET TO AVOID CALLING IT TWICE
        $this->data['js'] = FALSE;
        // END

        $this->template->public_render('public/messaging/inbox',$this->data);
    }

    public function open($messaging_id)
    {
        $chat_from = $this->messaging_model->join_multiple(['users' => 'id','users_groups' => 'user_id'],
            'messaging_from',
            ['messaging_from' => $messaging_id,
            'messaging_to' => $this->session->userdata('user_id')]);

        $this->messaging_model->update(['messaging_from' => $messaging_id,
        'messaging_to' => $this->session->userdata('user_id'),
        'view_status' => 0],
        ['view_status' => 1]);

        $chat_to = $this->messaging_model->join_multiple(['users' => 'id','users_groups' => 'user_id'],
            'messaging_from',
            ['messaging_to' => $messaging_id,
            'messaging_from' => $this->session->userdata('user_id')]);

        $this->messaging_model->update(['messaging_to' => $messaging_id,
            'messaging_from' => $this->session->userdata('user_id'),
            'view_status' => 0],
            ['view_status' => 1]);

        $chat = [];

        foreach($chat_from as $row_from){
            array_push($chat,$row_from);
        }

        
        foreach($chat_to as $row_to){
            array_push($chat,$row_to);
        }
        
        usort($chat, function($a, $b){
            return $b['messaging_date_added'] <=> $a['messaging_date_added'];
        });
        
        foreach ($chat as &$key) {
            $key['messaging_date_added'] = $this->get_timeago(strtotime($key['messaging_date_added']));
        }

        $this->data['val'] = $key;
        
        $this->load->model('admin/Users_model','users_model');
        $this->data['conversation_user'] = $this->users_model->get(['id' => $messaging_id]);

        $this->data['conversation_message'] = $chat;

        // IF JAVASCRIPT AND JQUERY SCRIPT HAS ALREADY BEEN CALLED IN THE VIEW THIS 
        // $this->data['js'] = FALSE; SHOULD DE SET TO AVOID CALLING IT TWICE
        $this->data['js'] = FALSE;
        // END

        $this->template->public_render('public/messaging/open',$this->data);

        // $data['conversation'] = $chat;
        // $data['all'] = $user_info[0];

        // $this->load->view('test',$data);
    }


    public function _open($message_id)
    {
        $message = $this->messaging_model->get(['messaging_id' => $message_id]);

        $this->output->set_content_type(['application_json']);
        $this->output->set_output(json_encode([
            'message' => $message[0]['messaging_body'],
            'from' => $message[0]['messaging_from'],
        ]));
    }

    public function test()
    {
        $message_to = $this->messaging_model->get(['messaging_to' => $this->session->userdata('user_id')]);
        $message_from = $this->messaging_model->get(['messaging_from' => $this->session->userdata('user_id')]);

        $all_id = [];

        foreach ($message_to as $row){
            array_push($all_id,'A'.$row['messaging_from']);
        }
        foreach ($message_from as $row){
            array_push($all_id,'B'.$row['messaging_to']);
        }

        $data['all'] = $all_id;

        $selected_id = [];

        foreach ($all_id as $ids){
            if(( !in_array('A'.substr($ids,1),$selected_id)) AND
            ( !in_array('B'.substr($ids,1),$selected_id)) ){
                array_push($selected_id,$ids);
            }
        }

        $conversation_from = [];
        $conversation_to = [];

        foreach($selected_id as $id){
            if(substr($id,0,1) == 'A'){
                $from = $this->messaging_model->join_multiple_order(
                    ['users' => 'id'],
                    'messaging_from',
                    'messaging_date_added',
                    'D',
                    ['messaging_from' => substr($id,1),
                    'messaging_to' => $this->session->userdata('user_id')]);

                    array_push($conversation_from,$from[0]);
            }elseif(substr($all_id[0],0,1) == 'B'){
                $to = $this->messaging_model->join_multiple_order(
                    ['users' => 'id'],
                    'messaging_to',
                    'messaging_date_added',
                    'D',
                    ['messaging_to' => substr($id,1),
                    'messaging_from' => $this->session->userdata('user_id')]);

                    array_push($conversation_to,$to[0]);
            }
        }

        $conversation = [];

        if($conversation_from){
            foreach($conversation_from as $row_from){
                array_push($conversation,$row_from);
            }
        }
        
        if($conversation_to){
            foreach($conversation_to as $row_to){
            array_push($conversation,$row_to);
            }
        }

        usort($conversation, function($a, $b) {
            return $b['messaging_date_added'] <=> $a['messaging_date_added'];
        });

        $data['selected'] = $selected_id;

        $data['conversation'] = $conversation;

        $this->load->view('test',$data);
    }
}