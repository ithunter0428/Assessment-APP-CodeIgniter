<?php

// namespace Name\Space;
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load */
        $this->load->config('admin/dp_config');
        $this->load->config('common/dp_config');

        /* Data */
        $this->data['title'] = $this->config->item('title');
    }

    public function index()
	{
        /* Title Page */
        $this->page_title->push('<i class="fa fa-home"></i> Home');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        // Get function name 
        $func_name = __FUNCTION__;
        
        // Get class name
        $path = explode('\\', __CLASS__);
        $class_name = array_pop($path);
        $link = $class_name.'/'.$func_name;
        
        // CHECK IF USER HAS PERMISSION TO THIS FUNCTION
        if ( ! $this->ion_auth->logged_in() OR ! $this->get_permission($link))
		{
			redirect('auth/login', 'refresh');
		}

        // TO CHECK IF USER HAS REGISTERED COURES FOR THAT SEMESTER
        if (! $this->check_reg() ){
            redirect('public/course_reg/register_course', 'refresh');
        }

        $this->template->public_render('public/index',$this->data);
    }
    
}
