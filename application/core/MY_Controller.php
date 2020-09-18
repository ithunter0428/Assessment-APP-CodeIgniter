<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

        /* COMMON :: ADMIN & PUBLIC */
        /* Load */
        $this->load->database();

        /* Data */
        $this->data['lang'] = element($this->config->item('language'), $this->config->item('language_abbr'));
        $this->data['charset'] = $this->config->item('charset');
        $this->data['frameworks_dir'] = $this->config->item('frameworks_dir');
        $this->data['plugins_dir'] = $this->config->item('plugins_dir');
        $this->data['avatar_dir'] = $this->config->item('avatar_dir');
        $this->data['dist_dir'] = $this->config->item('dist_dir');
        $this->data['build_dir'] = $this->config->item('build_dir');

        /* Any mobile device (phones or tablets) */
        if ($this->mobile_detect->isMobile())
        {
            $this->data['mobile'] = TRUE;

            if ($this->mobile_detect->isiOS()){
                $this->data['ios'] = TRUE;
                $this->data['android'] = FALSE;
            }
            elseif ($this->mobile_detect->isAndroidOS())
            {
                $this->data['ios'] = FALSE;
                $this->data['android'] = TRUE;
            }
            else
            {
                $this->data['ios'] = FALSE;
                $this->data['android'] = FALSE;
            }

            if ($this->mobile_detect->getBrowsers('IE')){
                $this->data['mobile_ie'] = TRUE;
            }
            else
            {
                $this->data['mobile_ie'] = FALSE;
            }
        }
        else
        {
            $this->data['mobile'] = FALSE;
            $this->data['ios'] = FALSE;
            $this->data['android'] = FALSE;
            $this->data['mobile_ie'] = FALSE;
        }
	}
}


class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Load */
            $this->load->config('admin/dp_config');
            $this->load->library(['admin/breadcrumbs', 'admin/page_title']);
            $this->load->model('admin/core_model');
            $this->load->helper('menu');
            $this->lang->load(['admin/main_header', 'admin/main_sidebar', 'admin/footer', 'admin/actions']);

            /* Load library function  */
            $this->breadcrumbs->unshift(0, $this->lang->line('menu_dashboard'), 'admin/dashboard');

            /* Data */
            $this->data['title'] = $this->config->item('title');
            $this->data['title_lg'] = $this->config->item('title_lg');
            $this->data['title_mini'] = $this->config->item('title_mini');
            $this->data['admin_prefs'] = $this->prefs_model->admin_prefs();
            $this->data['user_login'] = $this->prefs_model->user_info_login($this->ion_auth->user()->row()->id);

            if ($this->router->fetch_class() == 'dashboard')
            {
                $this->data['dashboard_alert_file_install'] = $this->core_model->get_file_install();
                $this->data['header_alert_file_install'] = NULL;
            }
            else
            {
                $this->data['dashboard_alert_file_install'] = NULL;
                $this->data['header_alert_file_install'] = NULL; /* << A MODIFIER !!! */
            }
        }
    }
}



class Public_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ( ! $this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Load */
            $this->load->config('admin/dp_config');
            $this->load->library(['admin/breadcrumbs', 'admin/page_title']);
            $this->load->model('admin/core_model');
            $this->load->helper('menu');
            $this->lang->load(['admin/main_header', 'admin/main_sidebar', 'admin/footer', 'admin/actions']);

            /* Load library function  */
            $this->breadcrumbs->unshift(0, 'Home', 'admin/dashboard');

            /* Data */
            $this->data['title'] = $this->config->item('title');
            $this->data['title_lg'] = $this->config->item('title_lg');
            $this->data['title_mini'] = $this->config->item('title_mini');
            $this->data['admin_prefs'] = $this->prefs_model->admin_prefs();
            $this->data['user_login'] = $this->prefs_model->user_info_login($this->ion_auth->user()->row()->id);
        }
    }

    public function send_notification($course_id,$assessment_id,$notification)
    {
        // NOTIFICATION FOR NEW ASSESSMENT
        $this->load->model('public/Notification_model','notification_model');
        $this->load->model('admin/Ses_model','ses_model');
        $this->load->model('public/Course_reg_model','course_reg_model');

        $semester = $this->ses_model->get(['sem_status' => 0]);
        $current_sem = $semester[0]['sem_id'];

        $student = $this->course_reg_model->join('users_groups','user_id','reg_user_id',
        ['reg_sem_id' => $current_sem,
        'reg_course_id' => $course_id,
        'group_id' => 3]);

        foreach($student as $row){
            $this->notification_model->insert([
                'notification_to' => $row['reg_user_id'],
                'notification_body' => $notification,
                'notification_course' => $course_id,
                'notification_assessment' => $assessment_id,
                'notification_type' => 1,
                'notification_date_added' => date('Y-m-d H:i:s'),]);
        }
    }

    public function send_notification_user($user_id,$assessment_log)
    {
        // NOTIFICATION FOR RESULT

        $notification = 'Your result for ' .$assessment_log[0]['course_title'].' is now available';

        $this->load->model('public/Notification_model','notification_model');
  
        $this->notification_model->insert([
            'notification_to' => $user_id,
            'notification_body' => $notification,
            'notification_course' => $assessment_log[0]['course_id'],
            'notification_assessment' => $assessment_log[0]['assessment_id'],
            'notification_type' => 2,
            'notification_date_added' => date('Y-m-d H:i:s'),]);
    }

    public function get_permission($links)
    {
        $this->load->model('admin/Permission_model','permission_model');
        $this->load->model('admin/links_model','links_model');

        $link = $this->links_model->get(['link_name' => $links],1);
        if (! $link){
            return FALSE;
        }

        $link_id = $link[0]['link_id'];

        $permission = $this->permission_model->get(['page_id' => $link_id, 'group_id' => $this->session->userdata('group_value')]);

        if ($permission){
            return TRUE;
        }else{
            return FALSE;
        }

        // $permission = $this->permission_model->join('links','link_id','permission_link_id',['link_name' => $links]);
    }

    public function check_reg()
    {
        $this->load->model('public/Course_Reg_model','course_reg_model');
        $this->load->model('admin/Ses_model','sem_model');

        $semester = $this->sem_model->get(['sem_status' => 0],1);
        $semester_id = $semester[0]['sem_id'];

        $course_reg = $this->course_reg_model->get([
            'reg_user_id' => $this->session->userdata('user_id'),
            'reg_sem_id' => $semester_id,
            'reg_department_id' => $this->session->userdata('department'),
            ]);

        if ($course_reg){
            return TRUE;
        }else{
            return FALSE;
        }

        // return $course_reg;
    }

}


// class Public_Controller extends MY_Controller
// {
// 	public function __construct()
// 	{
// 		parent::__construct();

//         if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
//         {
//             $this->data['admin_link'] = TRUE;
//         }
//         else
//         {
//             $this->data['admin_link'] = FALSE;
//         }

//         if ($this->ion_auth->logged_in())
//         {
//             $this->data['logout_link'] = TRUE;
//         }
//         else
//         {
//             $this->data['logout_link'] = FALSE;
//         }
// 	}
// }
