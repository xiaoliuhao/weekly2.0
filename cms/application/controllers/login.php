<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/8
 * Time: 17:40
 * Version: weekly
 */
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Login_Model','login');
        $this->load->model('Base_Model','base');
    }
    
    public function index(){
        $this->load->view('login');
    }

    public function check_login(){
        $name = $this->input->post('name');
        $password = $this->input->post('password');

        $adminInfo = $this->login->check_login($name,$password);
        if($adminInfo){
            $this->session->set_userdata('admin',$adminInfo);
            $this->base->alert('欢迎你',$this->session->userdata('admin')['name']);
        }else{
            $this->base->alert('密码错误');
        }
    }

    public function logout(){
        $this->session->unset_userdata('admin');
        $this->session->sess_destroy();
        $this->base->alert('再见');
        redirect('');
    }

}