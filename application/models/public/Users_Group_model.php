<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Group_model extends Base_model
{
    protected $table = 'users_groups';

    public function __construct()
    {
        parent::__construct();
    }
}