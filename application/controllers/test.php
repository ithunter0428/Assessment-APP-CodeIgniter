<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{

    }

    public function index(){
        // UPLOAD
        /* Conf */
        $config['upload_path']      = './upload/passport/';
        $config['allowed_types']    = 'jpg|jpeg|png|gif';
        $config['max_size']         = 2048;
        $config['max_width']        = 1024;
        $config['max_height']       = 1024;
        $config['file_ext_tolower'] = TRUE;
    
        $img_name = date('YmdHis') . $this->input->post('matric_no') . $this->input->post('first_name');
        $config['file_name'] = $img_name;
        
        $this->load->library('upload', $config);

        if($this->upload->do_upload('passport')){
            $this->output->set_output(json_encode([
				'result' => true,
				'message' => 'Registered successfully',
				'url' => '/auth',
			]));
        }else{
            $this->output->set_output(json_encode([
                'result' => 'message',
                'error' =>  $this->upload->display_errors(),
                'value' =>  $this->upload->do_upload('passport')
            ]));
        }
    }

}