<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

    protected $CI;

    public function __construct()
    {	
		$this->CI =& get_instance();
    }


    public function admin_render($content, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->template['header']          = $this->CI->load->view('admin/_templates/header', $data, TRUE);
            $this->template['main_header']     = $this->CI->load->view('admin/_templates/main_header', $data, TRUE);
            $this->template['main_sidebar']    = $this->CI->load->view('admin/_templates/main_sidebar', $data, TRUE);
            $this->template['content']         = $this->CI->load->view($content, $data, TRUE);
            $this->template['control_sidebar'] = $this->CI->load->view('admin/_templates/control_sidebar', $data, TRUE);
            $this->template['footer']          = $this->CI->load->view('admin/_templates/footer', $data, TRUE);

            return $this->CI->load->view('admin/_templates/template', $this->template);
        }
	}


    public function auth_render($content, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->template['header']  = $this->CI->load->view('auth/_templates/header', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer']  = $this->CI->load->view('auth/_templates/footer', $data, TRUE);

            return $this->CI->load->view('auth/_templates/template', $this->template);
        }
    }

    public function get_timeago( $ptime )
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
    
    public function public_render($content, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            // MESSAGING MAIN HEADEDER
            $this->CI->load->model('public/Messaging_model','messaging_model');
            $data['no_unread'] = $this->CI->messaging_model->count(['messaging_to' => $this->CI->session->userdata('user_id'),'view_status' => 0]);
            $recieved_msg = $this->CI->messaging_model->join_multiple_order(
                ['users' => 'id',
                'users_groups' => 'user_id'],
                'messaging_from',
                'messaging_date_added',
                'D',
                ['messaging_to' => $this->CI->session->userdata('user_id')],                
                1);
           
            foreach($recieved_msg as &$recieved){
                $recieved['date_added'] = $recieved['messaging_date_added'];
                $recieved['type'] = 'message';
                $recieved['messaging_date_added'] = $this->get_timeago(strtotime($recieved['messaging_date_added']));
                $recieved['date_ago'] = $this->get_timeago(strtotime($recieved['messaging_date_added']));
            }

            $data['recieved_msg'] = array_slice($recieved_msg,0,5);
            // MESSAGING MAIN HEADEDER END
           
            // NOTIFICATION MAIN HEADEDER
            $this->CI->load->model('public/Notification_model','notification_model');
            $data['no_notification'] = $this->CI->notification_model->count(['notification_to' => $this->CI->session->userdata('user_id'),'notification_view' => 0]);
            $recieved_notification = $this->CI->notification_model->join_multiple_order(
                ['school_course' => 'course_id',],
                'notification_course',
                'notification_date_added',
                'D',
                ['notification_to' => $this->CI->session->userdata('user_id')],5);

            foreach($recieved_notification as &$notifications){
                $notifications['date_added'] = $notifications['notification_date_added'];
                $notifications['type'] = 'notification';
                $notifications['notification_date_added'] = $this->get_timeago(strtotime($notifications['notification_date_added']));
                $notifications['date_ago'] = $this->get_timeago(strtotime($notifications['notification_date_added']));
            }

            $data['recieved_notification'] = array_slice($recieved_notification,0,5);
            // NOTIFICATION MAIN HEADEDER END

            // USER PROFILE
            // LOAD MODEL
            $this->CI->load->model('public/Course_Reg_model','course_reg_model');
            $this->CI->load->model('admin/Users_model','users_model');
            $this->CI->load->model('admin/Ses_model','ses_model');
            $this->CI->load->model('public/Assessment_model','assessment_model');

            $semester = $this->CI->ses_model->get(['sem_status' => 0]);
            $current_sem = $semester[0]['sem_id'];

            $user_course = $this->CI->course_reg_model->get(['reg_sem_id' => $current_sem,'reg_user_id' => $this->CI->session->userdata('user_id')]);
            $assessment_count = $this->CI->assessment_model->count(['assessment_user_id' => $this->CI->session->userdata('user_id'), 'assessment_sem' => $current_sem]);

            $count_students = 0;
            $students = null;
            
            $count_lecturers = 0;
            $lecturers = null;
            
            foreach($user_course as $course){
                $students = $this->CI->course_reg_model->join_multiple([
                    'users_groups' => 'user_id',
                ],
                'reg_user_id'
                ,
                ['reg_sem_id' => $current_sem,
                'reg_course_id' => $course['reg_course_id'],
                'group_id' => 3
                ]);
            }
            
            foreach($user_course as $course){
                $lecturers = $this->CI->course_reg_model->join_multiple([
                    'users_groups' => 'user_id',
                ],
                'reg_user_id'
                ,
                ['reg_sem_id' => $current_sem,
                'reg_course_id' => $course['reg_course_id'],
                'group_id' => 2
                ]);
            }

            if(is_array($students)){
                $count_students = count($students);
            }
            
            if(is_array($lecturers)){
                $count_lecturers = count($students);
            }

            $data['user_students_count'] = $count_students;
            $data['user_lecturers_count'] = $count_lecturers;
            $data['user_courses_count'] = count($user_course);
            $data['user_assessment_count'] = $assessment_count;
            // USER PROFILE END
            
            $data['timeline_log'] = $this->timeline($recieved_notification,$recieved_msg);
            
            $data['user_group'] = $this->CI->session->userdata('group_value');
            $data['session_user_id'] = $this->CI->session->userdata('user_id');

            $this->template['header']          = $this->CI->load->view('public/_templates/header', $data, TRUE);
            $this->template['main_header']     = $this->CI->load->view('public/_templates/main_header', $data, TRUE);
            $this->template['main_sidebar']    = $this->CI->load->view('public/_templates/main_sidebar', $data, TRUE);
            $this->template['content']         = $this->CI->load->view($content, $data, TRUE);
            $this->template['control_sidebar'] = $this->CI->load->view('public/_templates/control_sidebar', $data, TRUE);
            $this->template['footer']          = $this->CI->load->view('public/_templates/footer', $data, TRUE);

            return $this->CI->load->view('public/_templates/template', $this->template);
        }
    }
    
    public function timeline($notification_log,$message_log){
        $timeline = [];

        if($notification_log){
            foreach($notification_log as $row){
                // $row['date_added'] = $row['notification_date_added'];
                array_push($timeline,$row);
            }
        }
        
        if($message_log){
            foreach($message_log as $row){
                // $row['date_added'] = $row['messaging_date_added'];
                array_push($timeline,$row);
            }
        }

        usort($timeline, function($a, $b) {
            return $b['date_added'] <=> $a['date_added'];
        });

        $timeline_group = [];
        $current_date_added = null;
        foreach ($timeline as $row){
            if(date('Y/m/d',strtotime($row['date_added'])) == $current_date_added){
                array_push($timeline_group[$current_date_added],$row);
            }else{
                $current_date_added = date('Y/m/d',strtotime($row['date_added']));
                $timeline_group[$current_date_added][0] = $row;
            }
        }

        return array_slice($timeline_group,0,5);
    }

}