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

    public function login(){
        $user['uid'] = $this->input->post('uid');


        if($user) {
            set_cookie('userid', $user['uid'], 600);
            $this->session->set_userdata('userid', $user['uid']);
        }

//        echo 'session';
//
        var_dump($this->session->userdata('userid'));
//
        $data = get_cookie('userid');
//
        var_dump($data);
    }




}