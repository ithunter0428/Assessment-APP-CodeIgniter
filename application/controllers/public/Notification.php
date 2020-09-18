<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();

        // TO CHECK IF USER HAS REGISTERED COURES FOR THAT SEMESTER
        if (! $this->check_reg() ){
            redirect('public/course_reg/register_course', 'refresh');
        }

        $this->load->model('public/Notification_model','notification_model');
    }

    public function index()
    {
        /* Title Page :: Common */
        $this->page_title->push('<i class="fa fa-bell"></i> Notifications');
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Notifications', 'public/notification');

        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->notification_model->update(['notification_to' => $this->session->userdata('user_id')],
        ['notification_view' => 1]);

        $notification = $this->notification_model->join_multiple_order(
            ['school_course' => 'course_id',],
            'notification_course',
            'notification_date_added',
            'D',
            ['notification_to' => $this->session->userdata('user_id')]
        );

        foreach($notification as &$row){
            $row['notification_date_added'] = $this->template->get_timeago(strtotime($row['notification_date_added']));
        }

        $this->data['notification'] = $notification;

        // IF JAVASCRIPT AND JQUERY SCRIPT HAS ALREADY BEEN CALLED IN THE VIEW THIS 
        // $this->data['js'] = FALSE; SHOULD DE SET TO AVOID CALLING IT TWICE
        $this->data['js'] = FALSE;
        // END

        $this->template->public_render('public/notification/index',$this->data);

    }

    public function test()
    {
        $this->send_notification(7,'YES');
    }
}