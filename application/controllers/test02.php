<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/10
 * Time: 13:01
 * Version: weekly
 */
header('Access-Control-Allow-Origin:*');
class Test02 extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->helper('cookie');
    }
    public function index(){
        echo 'test02';
    }

    public function getCookie(){
        $data = get_cookie('userid');
//
        var_dump($data);
    }

    public function getSession(){
        $user = $this->session->userdata('userid');

        var_dump($user);
    }



}