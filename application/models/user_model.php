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
        $this->load->model('Base_Model','base');
        $this->load->helper('url');
    }

    public function register(){
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
    
    public function info($uid){
        $data = $this->base->select('*','user','uid',$uid);
        return $data;
    }

    public function update($uid,$type,$value){
        $bool = $this->db->update('user',array($type=>$value),array('uid'=>$uid));
        return $bool;
    }

    public function find_password(){

    }
  
    public function write_log($action){
        $ip = $_SERVER["REMOTE_ADDR"];
        $this->db->insert();
        $this->db->insert('log',array('uid'=>$uid,'action'=>$action,'ip'=>$ip,'time'=>date('Y-m-d H:i:s')));
        
    }
}
