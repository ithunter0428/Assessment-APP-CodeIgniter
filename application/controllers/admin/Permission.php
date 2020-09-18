<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends Admin_controller 
{
    public function __construct()
    {
        parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }

        /* Title Page :: Common */
		$this->page_title->push('Permissions');
		$this->data['pagetitle'] = $this->page_title->show();

		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, 'Permissions', 'admin/users');
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->load->model('admin/Links_model','links_model');
        $this->load->model('admin/Permission_model','permission_model');
        $this->load->model('public/Group_model','group_model');

    }

    public function index($group_id,$save = NULL)
    {
        $this->data['group'] = $this->group_model->get(['id' => $group_id]);

        // $this->data['permission'] = $this->permission_model->join('links','link_id','page_id',['group_id' => $group_id]);

        $this->data['permission'] = $this->permission_model->get(['group_id' => $group_id]);

        $all_links = $this->links_model->get();

        $this->data['all_links'] = $all_links;

        if ($save == NULL){
            $this->template->Admin_render('admin/permission/index',$this->data);
            return;
        }

        // validates the checkbox
        $i = 0;

        foreach ($all_links as $row){
            $name_checkbox = $row['link_name'].$row['link_id'];
            if ($this->input->post($name_checkbox)){                 
                $i++;
            }
        }

        $form_result = TRUE;

        if($i < 1){
            $form_result = FALSE;
        }

        if($form_result == TRUE){
            // TO CHECK IS IF LINK WAS SELECTED(POSTED) AND DOES NOT EXIST IN THE DATABASE THEN INSERT
            foreach($all_links as $row) {
               if ($row['link_id'] == $this->input->post($row['link_name'].$row['link_id'])){
                   $this->permission_model->insert([
                       'page_id' => $row['link_id'],
                       'group_id'=> $group_id,
                   ]);
               }
            }

            foreach($all_links as $row) {
                $per = $this->permission_model->get(['page_id' => $row['link_id'],
                'group_id'=> $group_id,],1);

                if (! $this->input->post($row['link_name'].$row['link_id']) AND $per){
                    $this->permission_model->delete([
                        'page_id' => $row['link_id'],
                        'group_id'=> $group_id,
                    ]);
                }
            }
            
            redirect('admin/permission/index/'.$group_id,'refresh');
            
        }else {
            $this->session->set_flashdata('error','You must give this group atleate one permission');
            redirect('admin/permission/index/'.$group_id,'refresh');
            return;
        }
    }

}