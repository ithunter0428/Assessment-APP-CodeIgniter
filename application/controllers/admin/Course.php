<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }

        /* Title Page :: Common */
		$this->page_title->push('Courses');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Courses', 'admin/course');
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('admin/Course_model','course_model');
        $this->load->model('admin/Department_model','dept_model');
        $this->load->model('admin/student_level_model','level_model');

    }

    public function index()
    {
        
        // $list_department = $this->course_model->join('school_department','department_id','course_dept_id');
        // $faculty_id = $list_department[0]['department_faculty_id'];

        // JOINING FACULTY TABLE TO DEPT TABLE TO GET FACULTY AND DEPARTMENT NAME
        $this->data['list_dept'] = $this->dept_model->join('school_faculty','faculty_id','department_faculty_id');

        // JOINING LEVEL TABLE TO COURSE TABLE TO GET LEVEL NAMES AND COURSES
        $this->data['list_course'] = $this->course_model->join('student_level','level_id','course_level_id');

        $this->template->admin_render('admin/course/course_view',$this->data);
    }

    public function add_course()
    {
        // JOINING FACULTY TABLE TO DEPT TABLE TO GET FACULTY AND DEPARTMENT NAME
        $this->data['list_dept'] = $this->dept_model->join('school_faculty','faculty_id','department_faculty_id');

        $this->data['list_level'] = $this->level_model->get();

        // JOINING LEVEL TABLE TO COURSE TABLE TO GET LEVEL NAMES AND COURSES
        $this->data['list_course'] = $this->course_model->join('student_level','level_id','course_level_id');

        $this->template->admin_render('admin/course/add_course_view',$this->data);
    }

    public function add_course_data()
    {
        $this->output->set_content_type('application_json');

        // FORM VALIDATION
        $this->form_validation->set_rules('course_code','Course Code', 'required');
        $this->form_validation->set_rules('course_title','Course Tittle', 'required');
        $this->form_validation->set_rules('course_unit','Unit', 'required');
        $this->form_validation->set_rules('course_sem','Semester', 'required');
        $this->form_validation->set_rules('course_level_id','Level', 'required');
        $this->form_validation->set_rules('course_dept_id','Department', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $this->course_model->insert([
                'course_code' => $this->input->post('course_code'),
                'course_title' => $this->input->post('course_title'),
                'course_unit' => $this->input->post('course_unit'),
                'course_sem' => $this->input->post('course_sem'),
                'course_level_id' => $this->input->post('course_level_id'),        
                'course_dept_id' => $this->input->post('course_dept_id'),        
            ]);

            $this->output->set_output(json_encode([
				'result' => 'success',
				'message' => 'Course created successfully',
				'url' => '/admin/course',
			]));
            // redirect(site_url('admin/course'));

        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }

    public function delete_course($course_id)
    {
        $query = $this->course_model->delete([
            'course_id' => $course_id
        ]);

        if ($query){
            redirect(site_url('admin/course'));
        }
    }

    public function edit_course($course_id)
    {
        $query = $this->course_model->get(['course_id' => $course_id]);

        // JOINING FACULTY TABLE TO DEPT TABLE TO GET FACULTY AND DEPARTMENT NAME
        $this->data['list_dept'] = $this->dept_model->join('school_faculty','faculty_id','department_faculty_id');

        $this->data['list_level'] = $this->level_model->get();

        // JOINING LEVEL TABLE TO COURSE TABLE TO GET LEVEL NAMES AND COURSES
        $this->data['list_course'] = $this->course_model->join('student_level','level_id','course_level_id');

        $course_info = $this->course_model->get(['course_id' => $course_id]);
        
        $this->data['course_id'] = $course_info[0]['course_id'];
        $this->data['course_code'] = $course_info[0]['course_code'];
        $this->data['course_title'] = $course_info[0]['course_title'];
        $this->data['course_unit'] = $course_info[0]['course_unit'];
        $this->data['course_sem'] = $course_info[0]['course_sem'];
        $this->data['level_id'] = $course_info[0]['course_level_id'];
        $this->data['department_id'] = $course_info[0]['course_dept_id'];

        $this->template->admin_render('admin/course/add_course_view',$this->data);
    }

    public function edit_course_data($course_id)
    {
        $this->output->set_content_type('application_json');

        $query = $this->course_model->get(['course_id' => $course_id]);

        $this->form_validation->set_rules('course_code','Course Code', 'required');
        $this->form_validation->set_rules('course_title','Course Tittle', 'required');
        $this->form_validation->set_rules('course_unit','Unit', 'required');
        $this->form_validation->set_rules('course_sem','Semester', 'required');
        $this->form_validation->set_rules('course_level_id','Level', 'required');
        $this->form_validation->set_rules('course_dept_id','Department', 'required');

        $form_status = $this->form_validation->run();

        $course_code = $this->input->post('course_code');
        $course_title = $this->input->post('course_title');
        $course_unit = $this->input->post('course_unit');
        // $course_sem = $this->input->post('course_sem');
        // $course_level = $this->input->post('course_level_id');
        // $course_dept = $this->input->post('course_dept_id');

        if ($course_code == $query[0]['course_code']){
            $form_status = TRUE;
        }

        if ($course_title == $query[0]['course_title']){
            $form_status = TRUE;
        }

        if ($course_unit == $query[0]['course_unit']){
            $form_status = TRUE;
        }

        if ($form_status == TRUE){
            $this->course_model->update(['course_id' => $course_id],[
                'course_code' => $this->input->post('course_code'),
                'course_title' => $this->input->post('course_title'),
                'course_unit' => $this->input->post('course_unit'),
                'course_sem' => $this->input->post('course_sem'),
                'course_level_id' => $this->input->post('course_level_id'),        
                'course_dept_id' => $this->input->post('course_dept_id'),
                ]);
                
                $this->output->set_output(json_encode([
                    'result' => 'success',
                    'message' => 'Course edited successfully',
                    'url' => '/admin/course',
                ]));
                // redirect(site_url('admin/course'));
        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }
}
