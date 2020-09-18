<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }

        /* Title Page :: Common */
		$this->page_title->push('Department');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Department', 'admin/department');
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('admin/Department_model','dept_model');
    }

    public function index()
    {
        // $list_department = $this->dept_model->get();
        // $faculty_id = $list_department[0]['department_faculty_id'];

        $this->data['list_department'] = $this->dept_model->join('school_faculty','faculty_id','department_faculty_id');

        // $this->data['list_department'] = $list_department;

        $this->template->admin_render('admin/department/department_view',$this->data);
    }

    public function add_department()
    {
        $this->load->model('admin/Faculty_model','faculty_model');
        $this->data['faculty_name'] = $this->faculty_model->get();
        $this->template->admin_render('admin/department/add_department_view',$this->data);
    }

    public function add_department_data()
    {
        $this->form_validation->set_rules('department_name','Dapartment Name', 'required|is_unique[school_department.department_name]');
        $this->form_validation->set_rules('department_faculty_id','Faculty Name', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $this->dept_model->insert([
                'department_name' => $this->input->post('department_name'),
                'department_faculty_id' => $this->input->post('department_faculty_id'),
            ]);
            $this->output->set_output(json_encode([
				'result' => 'success',
				'message' => 'Department created successfully',
				'url' => '/admin/department',
			]));
            // redirect(site_url('admin/department'));

        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }

    public function delete_department($department_id)
    {
        $query = $this->dept_model->delete([
            'department_id' => $department_id
        ]);

        if ($query){
            redirect(site_url('admin/department'));
        }
    }

    public function edit_department($department_id)
    {
        $query = $this->dept_model->get(['department_id' => $department_id]);

        $this->load->model('admin/Faculty_model','faculty_model');
        $this->data['faculty_name'] = $this->faculty_model->get();

        $this->data['department_id'] = $department_id;
        $this->data['department_name'] = $query[0]['department_name'];
        $this->data['faculty_id'] = $query[0]['department_faculty_id'];

        $this->template->admin_render('admin/department/add_department_view',$this->data);
    }

    public function edit_department_data($department_id)
    {
        $query = $this->dept_model->get(['department_id' => $department_id]);

        $this->form_validation->set_rules('department_name', 'Department Name', 'required');
        $this->form_validation->set_rules('department_faculty_id', 'Faculty', 'required');

        $form_status = $this->form_validation->run();

        $department_name = $this->input->post('department_name');
        $faculty_id = $this->input->post('department_faculty_id');

        if ($department_name == $query[0]['department_name']){
            $form_status = TRUE;
        }

        if ($form_status == TRUE){
            $this->dept_model->update(['department_id' => $department_id],[
                'department_name' => $department_name,
                'department_faculty_id' => $faculty_id,
                ]);
                $this->output->set_output(json_encode([
                    'result' => 'success',
                    'message' => 'Department edited successfully',
                    'url' => '/admin/department',
                ]));
        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }
}
