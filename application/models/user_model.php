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

    /**
     * add_message  添加用户信息
     * @access public
     * @param $uid
     * @param $message
     * @return mixed
     */
    public function add_message($uid,$message){
        $time = date('Y-m-d H:i:s');
        $this->db->insert('user_message',array('uid'=>$uid,'message'=>$message,'time'=>$time));
        return $this->db->affected_rows();
    }

    /**
     * get_notice_list  获取未读信息
     * @access public
     * @param $uid
     * @return mixed
     */
    public function get_notice_list($uid){
        $res = $this->db->select('*')->from('user_message')->where(array('uid'=>$uid,'status'=>1)))->order_by('id desc')->get();
        $data = $res->result_array();
//        $data = $this->base->select_array_needs('*','user_message',array('uid'=>$uid,'status'=>1));
        return $data;
    }

    /**
     * get_notice_all 获取全部消息
     * @access public
     * @return mixed
     */
    public function get_notice_all(){
        $res = $this->db->select('*')->from('user_message')->where('uid',$uid)->order_by('id desc')->get();
        $data = $res->result_array();
        return $data;
    }
}
