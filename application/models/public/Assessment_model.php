<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_model extends Base_model
{
    protected $table = 'assessment_log';

    public function __construct()
    {
        parent::__construct();
    }
}