<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Essay_answer_model extends Base_model
{
    protected $table = 'answer_essay_log';

    public function __construct()
    {
        parent::__construct();
    }
}