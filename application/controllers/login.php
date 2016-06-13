<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/29
 * Time: 11:09
 * Version: weekly
 */
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('User_Model','user');
        $this->load->model('Base_Model','base');
        $this->load->model('Login_Model','login');
    }

    public function index(){
        echo 'login.php';
    }

    /**
     * check_login  登录
     * @access public
     */
    public function check_login(){
        $uid = $this->input->post('uid');
        $password = $this->input->post('password');
        $data = $this->login->check_login($uid,$password);
        if($data == 2){
            //账号或密码错误
            MyJSON::show(203,'账号或密码错误',array('flag'=>'登录'));
        }else{
            $data['flag'] = '登录';
            $this->base->write_user_log($uid,'登录');
            MyJSON::show(200,'ok',$data);
        }
    }

    /**
     * register  用户注册
     * @access public
     */
    public function register(){
        $user['uid'] = $this->input->post('uid');
        //先判断是否注册过
        $data = $this->login->check_user($user['uid']);
//        $data = $this->user->info($user['uid']);
        if($data){
            //已经被注册过
            MyJSON::show(203,'此账号已经被注册');
            exit(0);
        }
        //随机生成一个用户名
        $user['name']     = mb_substr('用户'.md5(uniqid(time())), 0, 8);
        $user['password'] = $this->input->post('password');
        $password2        = $this->input->post('password2');
        //判断参数
        if( (!$user['uid'])||(!$user['name'])||(!$user['password'])||(!$password2)){
            MyJSON::show(400,'请求参数错误');
            exit(0);
        }

        if($password2 != $user['password']){
            MyJSON::show(202,'两次密码不一致',array('flag'=>'注册'));
            exit(0);
        }

        $affect = $this->login->register($user);
        if($affect){
            //注册成功
            $this->base->write_user_log($user['uid'],'用户注册');
            MyJSON::show(200,'ok',array('flag'=>'注册'));
        }else{
            MyJSON::show(203,'注册失败',array('flag'=>'注册'));
        }
    }

    /**
     * get_photo 获取头像
     * @access public
     */
    public function get_photo(){
        $uid = $this->input->post('uid');
        $data['photo'] = $this->login->get_photo($uid);
        if($data) {
            $data['flag'] = '获取头像';
            MyJSON::show(200,'ok',$data);
        }else{
            MyJSON::show(202,'头像不存在',$data);
        }
    }

    /**
     * logout   用户退出登录
     * @access public
     */
    public function logout(){
        $uid = $this->input->post('uid');
        $this->base->write_user_log($uid,'logout');
    }

}