<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_reg extends Public_Controller
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
        
        /* Title Page :: Common */
		$this->page_title->push('Course Registration');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Course Registration', 'public/course_reg');
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('public/Course_Reg_model','course_reg_model');
        $this->load->model('admin/Ses_model','ses_model');
        $this->load->model('admin/Course_model','course_model');

       
    }

    public function index()
    {
        // TO CHECK IF USER HAS REGISTERED COURES FOR THAT SEMESTER
        if (! $this->check_reg() ){
            redirect('public/course_reg/register_course', 'refresh');
        }
        
        // GET CURRENT SEMESTER
        $semester = $this->ses_model->get(['sem_status' => 0],1);
        $semester_id = $semester[0]['sem_id'];
        
        $this->data['my_course'] = $this->course_reg_model->join('school_course','course_id','reg_course_id',[
            'reg_user_id' => $this->session->userdata('user_id'),
            'reg_sem_id' => $semester_id,
        ]);

        $this->data['semester_info'] = $semester;

        $this->template->public_render('public/course_reg/index',$this->data);
    }

    public function register_course()
    {
        $semester = $this->ses_model->get(['sem_status' => 0]);
        $current_sem = $semester[0]['sem_name'];

        $user_course = $this->course_model->get([
            'course_dept_id' => $this->session->userdata('department'),
            'course_sem' => $current_sem,
            ]);

        $this->data['user_course'] = $user_course;

        // validates the checkbox
        $i = 0;
        $max_unit = 0;

        foreach ($user_course as $row){
            $name_checkbox = $row['course_id'];
            if ($this->input->post($name_checkbox) != null ){    
                if ($this->session->userdata('group_value') != 2){
                    $max_unit = $max_unit + $row['course_unit'];
                }

                $i++;
            }
        }

        $form_result = TRUE;

        if($i == 0){
            $form_result = FALSE;
            $message = 'You must register atleast one course to continue';
        }

        if($max_unit > 24){
            $form_result = FALSE;
            $message = 'Exceeds maximum credit unit';
        }

        if($form_result == TRUE){
            
            $semester = $this->ses_model->get(['sem_status' => 0],1);
            $semester_id = $semester[0]['sem_id'];
            
            foreach($user_course as $row) {
                
                if ($this->session->userdata('group_value') == 2){
                    $course_level = NULL;
                }else{
                    $course_level = $row['course_level_id'];
                }
             
                $this->course_reg_model->insert([
                    'reg_course_id' => $this->input->post($row['course_id']),
                    'reg_user_id' => $this->session->userdata('user_id'),
                    'reg_sem_id' => $semester_id,
                    'reg_level_id' => $course_level,
                    'reg_department_id' => $this->session->userdata('department'),
                ]);
                
            }

            redirect('public/course_reg','refresh');
        }
        
        $this->session->set_flashdata('error',$message);
        $this->template->public_render('public/course_reg/register_course',$this->data);
    }

    public function get_course()
    {
        // AJAX CALL
        $semester = $this->ses_model->get(['sem_status' => 0],1);
        $semester_id = $semester[0]['sem_id'];
        
        $my_course = $this->course_reg_model->join('school_course','course_id','reg_course_id',[
            'reg_user_id' => $this->session->userdata('user_id'),
            'reg_sem_id' => $semester_id,
        ]);

        $course = [];

        foreach($my_course as $row){
            $option = ['courseId' => $row['course_id'],'courseCode' => $row['course_code']];
            array_push($course,$option);
        }

       $this->output->set_content_type('application_json');
       $this->output->set_output(json_encode(['course' => $course]));
    }
}