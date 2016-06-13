<?php
/**
 * Created by PhpStorm.
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/1
 * Time: 18:56
 * Version: weekly
 */
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class User extends CI_Controller{
    /**
     * User constructor.
     */
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('User_Model','user'); //引入
        $this->load->model('Login_Model','login');
    }

    /**
     * index
     * @access public
     */
    public function index(){
        echo 'User.php';
    }

    /**
     * detail 查看详细信息
     * @access public
     */
    public function detail(){
        $uid = $this->input->get('uid');
        $detail = $this->user->info($uid);
        MyJSON::show(200,'ok',$detail);
    }

    /**
     * upload_photo  上传头像
     * @access public
     */
    public function upload_photo(){
        $config = array(
            'upload_path'=>'./photos',
            'allowed_types'=>'gif|png|jpeg',
            //生成新的文件名
            'file_name'=>uniqid(),
            'max_size'=>'1000000',
        );
        //装载文件上传类
        $this->load->library('upload',$config);
        $bool = $this->upload->do_upload('pic');
        $uid  = $this->login->is_log();
        if($bool){
            $data = $this->upload->data();
            $rows = $this->user->upload_photo($uid,'photos/'.$data['orig_name']);
            if($rows){
                MyJSON::show(200,'ok');
            }
        }
    }

    /**
     * update 修改个人信息
     * @access public
     */
    public function update(){
        $uid    = $this->login->is_log();
        //需要修改的种类
        $type   = $this->input->post('type');
        $value  = $this->input->post('value');

        $bool = $this->user->update($uid,$type,$value);
        if($bool){
            MyJSON::show(200,'ok');
        }else{
            MyJSON::show(204,'修改失败');
        }
    }

    /**
     * change_pass 修改密码
     * @access public
     */
    public function change_pass(){
        // $data['uid']= '12';
        // echo json_encode($data);
        $uid       = $this->login->is_log();
        $old_pass  = $this->input->post('old_pass');
        $new_pass  = $this->input->post('new_pass');
        $real_pass = $this->user->get_password($uid);

        if($real_pass != $old_pass){
            MyJSON::show(203,'密码不正确');
        }else {
            $rows = $this->user->change_password($uid,sha1(md5($new_pass)));
            if($rows == 1){
                MyJSON::show(200,'ok');
            }
        }
    }

    /**
     * add_label    添加用户标签
     * @access public
     */
    public function add_label(){
        $uid    = $this->input->post('uid');
        $label  = $this->input->post('label');
        $rows   = $this->user->add_label($uid,$label);
        if($rows==1){
            MyJSON::show(200,'ok');
        }else{
            MyJSON::show(203,'添加标签失败');
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