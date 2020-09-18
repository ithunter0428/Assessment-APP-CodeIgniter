<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_level extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }

        /* Title Page :: Common */
		$this->page_title->push('Levels');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Levels', 'admin/student_level');
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('admin/Student_level_model','level_model');
    }

    public function index()
    {  
        $this->data['list_level'] = $this->level_model->get();
        $this->template->admin_render('admin/student_level/student_level_view',$this->data);
    }

    public function add_level()
    { 
        $this->template->admin_render('admin/student_level/add_level_view',$this->data);
    }

    public function add_level_data()
    {
        $this->output->set_content_type('application_json');
        $this->form_validation->set_rules('level_name','level Name', 'required|is_unique[student_level.level_name]');

        if ($this->form_validation->run() == TRUE)
        {
            $level_name = $this->input->post('level_name');

            $this->level_model->insert([
                'level_name' => $level_name,
            ]);
            $this->output->set_output(json_encode([
				'result' => 'success',
				'message' => 'Level created successfully',
				'url' => '/admin/student_level',
			]));
            // redirect(site_url('admin/student_level'));

        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }

    public function delete_level($level_id)
    {
        $query = $this->level_model->delete([
            'level_id' => $level_id
        ]);

        if ($query){
            redirect(site_url('admin/student_level'));
        }
    }

    public function edit_level($level_id)
    {
        $query = $this->level_model->get(['level_id' => $level_id]);
        $this->data['level_id'] = $level_id;
        $this->data['level_name'] = $query[0]['level_name'];

        $this->template->admin_render('admin/student_level/add_level_view',$this->data);
    }

    public function edit_level_data($level_id)
    {
        $query = $this->level_model->get(['level_id' => $level_id]);
        $this->output->set_content_type('application_json');
        $this->form_validation->set_rules('level_name', 'level Name', 'required');

        $form_status = $this->form_validation->run();

        $level_name = $this->input->post('level_name');

        if ($level_name == $query[0]['level_name']){
            $form_status = TRUE;
        }

        if ($form_status == TRUE){
            $this->level_model->update(['level_id' => $level_id],[
                'level_name' => $level_name,
                ]);
            $this->output->set_output(json_encode([
                'result' => 'success',
                'message' => 'Level edited successfully',
                'url' => '/admin/student_level',
            ]));
                // redirect(site_url('admin/student_level'));
        }else{
            $this->output->set_output(json_encode([
				'result' => 'error',
				'error' => $this->form_validation->error_array(),
			]));
        }
    }
}
