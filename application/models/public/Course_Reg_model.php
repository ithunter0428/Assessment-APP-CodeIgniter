<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_Reg_model extends Base_model
{
    protected $table = 'reg_course';

    public function __construct()
    {
        parent::__construct();
    }
}