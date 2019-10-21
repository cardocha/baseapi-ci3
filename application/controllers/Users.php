<?php
require_once(CONTROLLERS_DIR . 'BaseController.php');

class Users extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
    }

    public function index()
    {
        if (parent::is_get()) {
            $response = $this->user->get_all();
            echo parent::json_response(TRUE, "OK", $response);
        }
    }

    public function persist()
    {
        $this->user->persist(parent::get_data());
    }

    public function remove()
    {
        $this->user->remove(parent::get_data());
    }
}
