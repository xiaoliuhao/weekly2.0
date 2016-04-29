<?php
/**
 * Created by PhpStorm.
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/1
 * Time: 18:56
 * Version: weekly
 */
class User extends CI_Controller{
    /**
     * User constructor.
     */
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_Model','user'); //引入
    }

    

    public function detail(){
        $detail = $this->user->detail();

    }

    public function add_photo(){

    }

    /**
     * update 修改个人信息
     * @access public
     */
    public function update(){
        $uid = $this->input->post('uid');
        //需要修改的种类
        $type = $this->input->post('type');
        $password = $this->input->psot('password');
    }
    
    public function find_password(){
        $this->user->find_password();
    }

}