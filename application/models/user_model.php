<?php
/**
 * Created by PhpStorm.
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/1
 * Time: 19:10
 */
class User_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Base_Model','base');
        $this->load->helper('url');
    }

    public function reguster(){
        $user['uid'] = $this->input->post('uid');
        $data = $this->base->select('uid','user','uid',$user['uid']);
        if($data){
            return 3;
        }
        $user['name'] = $this->input->post('name');
        $user['password'] = $this->input->post('password');
        $password2 = $this->input->post('password2');
        $user['register_tiem'] = date('Y-m-d H:i:s');
        $user['last_time'] = date('Y-m-d H:i:s');
        $user['ip'] = $_SERVER["REMOTE_ADDR"];

        if($password2 != $user['password']){
            //两次密码不相同
            return 2;
        }else{
            $user['password'] = sha1(md5($password2));
            $this->db->insert('user',$user);
        }
    }
    
    public function check_login(){
        $uid = $this->input->post('uid');
        $password = $this->inpit->post('password');
        $data = $this->base->select('*','user','uid',$uid);
        if($data['password'] != $password){
            //密码错误登陆失败
            return 2;
        }else{
            //密码正缺 登陆成功返回1
            return 1;
        }

    }

  
}
