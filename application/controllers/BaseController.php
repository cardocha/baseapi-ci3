<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class BaseController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }

        $this->load->database();

        $this->persist_or_remove();
    }

    public function index(){
        echo 'Hello !';
    }

    public function get_data()
    {
        $json_str = file_get_contents('php://input');
        $data = json_decode($json_str);
        return $data;
    }

    public function persist_or_remove()
    {

        if ($this->is_delete()) {
            $this->remove();
        } elseif ($this->is_post()) {
            $this->persist();
        }
    }

    public function is_get()
    {
        return $_SERVER["REQUEST_METHOD"] === "GET";
    }

    public function is_post()
    {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    public function is_delete()
    {
        return $_SERVER["REQUEST_METHOD"] === "DELETE";
    }

    public function json_response($flag, $msg, $obj)
    {
        $res = (object) array(
            'flag' => $flag,
            'msg' => $msg,
            'obj' => $obj
        );

        return json_encode($res);
    }


    abstract protected function persist();
    abstract protected function remove();
}
