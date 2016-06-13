<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/21
 * Time: 20:46
 * Version: weekly
 */
class Message_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }
    
    public function get($arr){
        $data = $this->base->select_array_needs('*','user_message',$arr);
        // echo $this->db->last_query();
        return $data;
    }

    public function detail($id){
        $data = $this->base->select('*','user_message','id',$id);
        //将消息标记为已读
        $this->db->update('user_message',array('status'=>2),array('id'=>$id));
        return $data;
    }

    /**
     * add
     * @access public
     * @param $uid
     * @param $message
     */
    public function add($uid,$message){
        $time = date('Y-m-d H:i:s');
        //添加一条新消息 默认未读
        $this->db->insert('user_message',array('uid'=>$uid,'message'=>$message,'time'=>$time,'status'=>1));
        return $this->db->affected_rows();
    }

    /**
     * delete   删除一条消息
     * @access public
     * @param $id
     */
    public function delete($id,$uid){
        $this->db->delete('user_message',array('id'=>$id,'uid'=>$uid));
        return $this->db->affected_rows();
    }

    /**
     * update   标记已读消息
     * @access public
     * @param $id
     */
    public function update($id){
        $this->db->update('user_message',array('status'=>2),array('id'=>$id));
        return $this->db->affected_rows();
    }
}