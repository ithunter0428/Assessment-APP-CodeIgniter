<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');

        /* Model */
        $this->load->model('admin/Ses_model','ses_model');
        
    }


	public function index()
	{
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Load Model */
            $this->load->model('admin/Users_model','users_model');

            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users']       = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');
            $this->data['count_lecturers']   = count($this->users_model->join_multiple(['users_groups' => 'user_id'],'id',['group_id'=>2]));
            $this->data['count_students']   = count($this->users_model->join_multiple(['users_groups' => 'user_id'],'id',['group_id'=>3]));
            $this->data['disk_totalspace']   = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
            $this->data['disk_freespace']    = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
            $this->data['disk_usespace']     = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
            $this->data['disk_usepercent']   = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, FALSE);
            $this->data['memory_usage']      = $this->dashboard_model->memory_usage();
            $this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(TRUE);
            $this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(TRUE, FALSE);

            // SCHOOL SESSION 
            $this->data['list_ses'] = $this->ses_model->get();

            $sem_status = $this->ses_model->count(['sem_status' => 0]);
            $this->data['sem_status'] = $sem_status;
            
            // $this->template->admin_render('admin/index', $this->data);

            /* Load Template */
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
    }
    
    public function start_sem()
    {
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }

        

        $this->form_validation->set_rules('ses_name','Timeline', 'required');

        if ($this->form_validation->run() == TRUE)
        {   
            $this->ses_model->insert([
                'ses_name' => $this->input->post('ses_name'),
                'sem_name' => $this->input->post('sem_name'),
                'sem_begin_date' => date('y-m-d'),
            ]);

            redirect('admin/dashboard','auto');

        }else{
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
    }

    public function end_sem($sem_id)
    {
        // LOAD MODELS
        $this->load->model('public/Users_Group_model','users_group_model');
        $this->load->model('admin/Users_model','users_model');
        $this->load->model('admin/Department_model','department_model');

        $unfinished_sem = $this->ses_model->get(['sem_status' => 0],1);
        $old_ses_name = $unfinished_sem[0]['ses_name'];

        $no_sem_ses = $this->ses_model->count(['ses_name' => $old_ses_name]);

        // END THE SEMESTER
        $this->ses_model->update(['sem_id' => $sem_id],
        [
            'sem_status' => 1,
            'sem_end_date' => date('y-m-d'),
        ]);


        // TO GET HOW MANY SEMSTER IS THE ENDED SESSION IF IT IS TWO IT WILL INCREESE ALL STUDENT LEVEL
        if ($no_sem_ses == 2):

            // GET ALL STUDENTS
            $all_students = $this->users_group_model->get(['group_id' => 3]);
           
            foreach ($all_students as $row){
                $student = $this->users_model->get(['id' => $row['user_id']],1);
                $max_year = $this->department_model->get(['department_id' => $student[0]['department']],1);

                if ($student[0]['user_level'] < $max_year[0]['department_year']){
                    // $this->users_model->increment('user_level',['id' => $student[0]['user_id'],]);
                    $user = $this->users_model->get(['id' => $row['user_id'],]);
                    $user_level = $user[0]['user_level'];
                    $new_user_level = $user_level+1;

                    $user = $this->users_model->update(['id' => $row['user_id'],],['user_level' => $new_user_level]);
                }
            }

        endif;


        redirect('admin/dashboard','auto');
    }

}
