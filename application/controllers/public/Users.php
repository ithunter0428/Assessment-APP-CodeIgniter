<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Public_Controller{

	public function __construct()
	{
		parent::__construct();

		// TO CHECK IF USER HAS REGISTERED COURES FOR THAT SEMESTER
		if (! $this->check_reg() ){
			redirect('public/course_reg/register_course', 'refresh');
		}
	}

    public function profile($id)
	{
		/* Data */
		$id = (int) $id;

		/* Load model */
		$this->load->model('admin/Department_model','dept_model');

		$this->data['user_info'] = $this->ion_auth->user($id)->result();
		foreach ($this->data['user_info'] as $k => $user)
		{
			$this->data['user_info'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}

		$department = $this->dept_model->get(['department_id' => $user->department]);
		$this->data['department'] = $department[0]['department_name'];

		/* Load Template */
		$this->template->public_render('admin/users/profile', $this->data);
	}
	
	public function lecturers()
    {
		/* Title Page :: Common */
		$this->page_title->push('Lecturers');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Coursemates', 'public/lecturers');

		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->load->model('admin/Users_model','users_model');
		$this->load->model('admin/Ses_model','ses_model');
		$this->load->model('public/Course_reg_model','course_reg_model');
		$this->load->model('admin/Course_model','course_model');
		$this->load->model('admin/Department_model','department_model');

		
        $semester = $this->ses_model->get(['sem_status' => 0]);
		$current_sem = $semester[0]['sem_id'];

		$user_course = $this->course_reg_model->get(['reg_sem_id' => $current_sem,'reg_user_id' => $this->session->userdata('user_id')]);

		$users = [];

		foreach($user_course as $course){
			$lecturers = $this->course_reg_model->join_multiple([
				'users' => 'id',
				'users_groups' => 'user_id'
			],
			'reg_user_id',
			['reg_sem_id' => $current_sem,
			'reg_course_id' => $course['reg_course_id'],
			'group_id' => 2
			]);
		}

		foreach($lecturers as &$row){
			$course_log = $this->course_model->get(['course_id' => $row['reg_course_id']]);
			$deparment_log = $this->department_model->get(['department_id' => $row['department']]);
			$row['course_code'] = $course_log[0]['course_code'];
			$row['department'] = $deparment_log[0]['department_name'];
		}

		// $data['users'] = $lecturers;
		// $this->load->view('test',$data);	

        $this->data['contact'] = $lecturers;
        $this->data['lecturer_list'] = true;

        $this->template->public_render('public/users/index',$this->data);
    }
	
	public function students()
    {
		/* Title Page :: Common */
		$this->page_title->push('Coursemates');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Coursemates', 'public/students');

		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->load->model('admin/Users_model','users_model');
		$this->load->model('admin/Ses_model','ses_model');
		$this->load->model('public/Course_reg_model','course_reg_model');
		$this->load->model('admin/Course_model','course_model');
		$this->load->model('admin/Department_model','department_model');
		$this->load->model('admin/Student_level_model','level_model');
		
        $semester = $this->ses_model->get(['sem_status' => 0]);
		$current_sem = $semester[0]['sem_id'];

		$user_course = $this->course_reg_model->get(['reg_sem_id' => $current_sem,'reg_user_id' => $this->session->userdata('user_id')]);

		$users = [];

		foreach($user_course as $course){
			$lecturers = $this->course_reg_model->join_multiple_order([
				'users' => 'id',
				'users_groups' => 'user_id'
			],
			'reg_user_id',
			'username',
			'A',
			['reg_sem_id' => $current_sem,
			'reg_course_id' => $course['reg_course_id'],
			'group_id' => 3
			]);
		}

		foreach($lecturers as &$row){
			$course_log = $this->course_model->get(['course_id' => $row['reg_course_id']]);
			$deparment_log = $this->department_model->get(['department_id' => $row['department']]);
			$level_log = $this->level_model->get(['level_id' => $row['user_level']]);

			$row['course_code'] = $course_log[0]['course_code'];
			$row['department'] = $deparment_log[0]['department_name'];
			$row['level'] = $level_log[0]['level_name'];
		}

		// $data['users'] = $lecturers;
		// $this->load->view('test',$data);	

        $this->data['contact'] = $lecturers;

        $this->template->public_render('public/users/index',$this->data);
	}

	public function lecturer_students()
    {
		/* Title Page :: Common */
		$this->page_title->push('Students');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Students', 'public/users');

		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->load->model('admin/Users_model','users_model');
		$this->load->model('admin/Ses_model','ses_model');
		$this->load->model('public/Course_reg_model','course_reg_model');
		$this->load->model('admin/Course_model','course_model');
		$this->load->model('admin/Department_model','department_model');
		$this->load->model('admin/Student_level_model','level_model');

		
        $semester = $this->ses_model->get(['sem_status' => 0]);
		$current_sem = $semester[0]['sem_id'];

		$user_course = $this->course_reg_model->get(['reg_sem_id' => $current_sem,'reg_user_id' => $this->session->userdata('user_id')]);

		$users = [];

		foreach($user_course as $course){
			$lecturers = $this->course_reg_model->join_multiple_order([
				'users' => 'id',
				'users_groups' => 'user_id',
			],
			'reg_user_id',
			'username',
			'A',
			['reg_sem_id' => $current_sem,
			'reg_course_id' => $course['reg_course_id'],
			'group_id' => 3
			]);
		}
		
		foreach($lecturers as &$row){
			$course_log = $this->course_model->get(['course_id' => $row['reg_course_id']]);
			$deparment_log = $this->department_model->get(['department_id' => $row['department']]);
			$level_log = $this->level_model->get(['level_id' => $row['user_level']]);

			$row['course_code'] = $course_log[0]['course_code'];
			$row['department'] = $deparment_log[0]['department_name'];
			$row['level'] = $level_log[0]['level_name'];
		}

        $this->data['contact'] = $lecturers;
        $this->template->public_render('public/users/lecturer_students',$this->data);
	}
}