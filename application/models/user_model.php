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

    

    /**
     * info 查看用户详细信息
     * @access public
     * @param $uid
     * @return mixed
     */
    public function info($uid){
        $data = $this->base->select('*','user','uid',$uid);
        return $data;
    }

    /**
     * update  修改用户信息
     * @access public
     * @param $uid
     * @param $type
     * @param $value
     * @return mixed
     */
    public function update($uid,$type,$value){
        $bool = $this->db->update('user',array($type=>$value),array('uid'=>$uid));
        return $bool;
    }

    public function find_password($uid,$email){
        
    }

    /**
     * change_password  修改密码
     * @access public
     * @param $uid
     * @param $new_password
     */
    public function change_password($uid,$new_password){
        $this->db->update('user',array('password'=>$new_password),array('uid'=>$uid));
    }
  
    
}
