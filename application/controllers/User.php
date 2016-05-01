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
        $this->load->model('Base_Model','base');
        $this->load->model('User_Model','user'); //引入
    }

    /**
     * index
     * @access public
     */
    public function index(){
//        $data = $this->input->info();
    }

    /**
     * detail 查看详细信息
     * @access public
     */
    public function detail(){
//        ---------------------------------------session还是post传输
        $uid = $this->input->post('uid');
        $detail = $this->user->info($uid);

    }

    /**
     * upload_photo  上传头像
     * @access public
     */
    public function upload_photo(){
        $uid = $this->input->post('uid');

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

    /**
     * change_pass 修改密码
     * @access public
     */
    public function change_pass(){
        $uid      = $this->input->post('uid');
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $user     = $this->user->info($uid);
        if($user['password'] != $old_pass){
            //旧密码不正确  无法修改密码
            echo 2;
        }else {
            $this->user->change_password($uid,$new_pass);
        }
    }

    /**
     * find_password    找回密码
     * @access public
     */
    public function find_password(){
        $uid    = $this->input->post('uid');
        $email  = $this->input->post('email');

        $data   = $this->base->select('email','user','uid',$uid);
        if($data['email'] != $email){
            //上传的邮箱和保存的不相同
            echo 2;
        }else {
            $this->user->find_password($uid, $email);
        }
    }

}