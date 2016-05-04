<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/4
 * Time: 19:51
 * Version: weekly
 */
header('Access-Control-Allow-Origin:*');
class Test extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->helper('cookie');
    }

    public function index(){
        echo 'hello';
    }

    public function test(){
        $user['uid'] = $this->input->post('uid');
        $user['password'] = $this->input->post('password');

        if($user['uid']  && $user['password'] ) {
            set_cookie('username', $user['uid'], 600);
            set_cookie('password', $user['password'], 600);
            redirect('test/home');
        }
//
//        $data = get_cookie('username');
//
//        var_dump($data);
    }

    public function home(){
        $data = get_cookie('username');
        var_dump($data);
    }
}