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
        $this->load->model('Log_Model','log');
    }

    /**
     * index    加载登陆界面
     * @access public
     */
    public function index(){

    }

    /**
     * check_login  登陆
     * @access public
     */
    public function check_login(){
        $uid = $this->input->post('uid');
        $password = $this->input->post('password');
        $user = $this->user->info($uid);

        if($password == $user['password']){
            //验证成功密码正确
            $this->log->add('user_log',$uid,'login');
            echo 1;
        }else{
            echo 2;
        }

    }

    public function register(){
        $user['uid'] = $this->input->post('uid');
        //先判断是否注册过
        $data = $this->user->info($user['uid']);
        if($data){
            //已经被注册过
            echo 2;
            exit(0);
        }
        $user['name']     = $this->input->post('name');
        $user['password'] = $this->input->post('password');
        $user['email']    = $this->input->post('email');

        $affect = $this->user->register($user);
        if($affect){
            //注册成功
            $this->log->add('user_log',$user['uid'],'register');
            echo 1;
        }
    }

    public function logout(){

    }

}