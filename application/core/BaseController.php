<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class BaseController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($this->session->userdata['logged_in'])) {
            redirect('');
        }
    }
}