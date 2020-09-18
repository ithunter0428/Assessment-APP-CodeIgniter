<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obj_model extends Base_model
{
    protected $table = 'obj_question';

    public function __construct()
    {
        parent::__construct();
    }
}