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
     * check_login  登陆
     * @access public
     */
    public function check_login(){
        $uid = $this->input->post('uid');
        $password = $this->input->post('password');

        $data = $this->login->check_login($uid,sha1(md5($password)));
        if($data == 2){
            //密码错误
            echo 2;
        }else{
            var_dump($data);
        }
        
    }

    /**
     * register  用户注册
     * @access public
     */
    public function register(){
        $user['uid'] = $this->input->post('uid');
        //先判断是否注册过
        $data = $this->log->check_user($user['uid']);
//        $data = $this->user->info($user['uid']);
        if($data){
            //已经被注册过
            echo 2;
            exit(0);
        }
        $user['name']     = $this->input->post('name');
        $user['password'] = $this->input->post('password');

        $affect = $this->log->register($user);
        if($affect){
            //注册成功
            $this->base->write_user_log($user['uid'],'register');
            echo 1;
        }
    }

    public function get_photo(){
        $uid = $this->input->post('uid');
        $data = $this->log->get_photo($uid);
        
        var_dump($data);
    }

    /**
     * logout   用户退出登录
     * @access public
     */
    public function logout(){
        $uid = $this->input->post('uid');
        $this->base->write_user_log->($uid,'logout');
    }

}