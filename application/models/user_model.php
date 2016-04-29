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

    public function register($user){
        $user['ip'] = $_SERVER["REMOTE_ADDR"];
        $user['register_time'] = date('Y-m-d H:i:s');

        $this->db->insert('user',$user);
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
  
    
}
