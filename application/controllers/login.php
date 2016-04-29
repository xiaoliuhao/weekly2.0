<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/29
 * Time: 11:09
 * Version: weekly
 */
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('User_Model','user');
        $this->load->model('Base_Model','base');
    }

    public function index(){

    }

    public function check_login(){
        $uid = $this->input->post('uid');
        $password = $this->input->post('password');
        $user = $this->user->info($uid);

        if($password == $user['password']){
            //验证成功密码正确
            echo 1;
        }else{
            echo 2;
        }

    }

    public function register(){
        $uid = $this->input->post('uid');
        //先判断是否注册过
        $data = $this->user->info($uid);
        if($data){
            //已经被注册过
            echo 1;
            exit(0);
        }
        

    }

    public function logout(){

    }

}