<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer_model extends Base_model
{
    protected $table = 'answer_log';

    public function __construct()
    {
        parent::__construct();
    }
}