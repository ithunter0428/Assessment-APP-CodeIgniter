<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }

        /* Title Page :: Common */
		$this->page_title->push('Faculty');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Faculty', 'admin/users');
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('admin/Faculty_model','faculty_model');
        // $this->load->model('admin/User_model');

    }

    public function index()
    {  
        $this->data['list_faculty'] = $this->faculty_model->get();
        $this->template->admin_render('admin/faculty/faculty_view',$this->data);
    }

    public function add_faculty()
    { 
        $this->template->admin_render('admin/faculty/add_faculty_view',$this->data);
    }

    public function add_faculty_data()
    {
        $this->output->set_content_type('application_json');
        $this->form_validation->set_rules('faculty_name','Faculty Name', 'required|is_unique[school_faculty.faculty_name]');

        if ($this->form_validation->run() == TRUE)
        {
            $faculty_name = $this->input->post('faculty_name');
            $this->faculty_model->insert([
                'faculty_name' => $faculty_name,
            ]);
            $this->output->set_output(json_encode([
				'result' => 'success',
				'message' => 'Faculty created successfully',
				'url' => '/admin/faculty',
			]));
        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }

    public function delete_faculty($faculty_id)
    {
        $query = $this->faculty_model->delete([
            'faculty_id' => $faculty_id
        ]);

        if ($query){
            redirect(site_url('admin/faculty'));
        }
    }

    public function edit_faculty($faculty_id)
    {
        $query = $this->faculty_model->get(['faculty_id' => $faculty_id]);

        $this->data['faculty_id'] = $faculty_id;
        $this->data['faculty_name'] = $query[0]['faculty_name'];

        $this->template->admin_render('admin/faculty/add_faculty_view',$this->data);
    }

    public function edit_faculty_data($faculty_id)
    {
        $this->output->set_content_type('application_json');
        $query = $this->faculty_model->get(['faculty_id' => $faculty_id]);

        $this->form_validation->set_rules('faculty_name', 'Faculty Name', 'required');

        $form_status = $this->form_validation->run();

        $faculty_name = $this->input->post('faculty_name');

        if ($faculty_name == $query[0]['faculty_name']){
            $form_status = TRUE;
        }

        if ($form_status == TRUE){
            $this->faculty_model->update(['faculty_id' => $faculty_id],[
            'faculty_name' => $faculty_name,
            ]);

            $this->output->set_output(json_encode([
				'result' => 'success',
				'message' => 'Faculty edited successfully',
				'url' => '/admin/faculty',
			]));
        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }
}
