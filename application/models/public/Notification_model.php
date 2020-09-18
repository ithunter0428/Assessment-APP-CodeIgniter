<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends Base_model
{
    protected $table = 'notification';

    public function __construct()
    {
        parent::__construct();
    }
}