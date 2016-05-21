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
        $data = $this->select_array_needs('*','user_message',$arr);
        return $data;
    }

    public function detail($id){
        $data = $this->base->select('*','user_message','id',$id);
        //将消息标记为已读
        $this->db->update('user_message',array('status'=>2),array('id'=>$id));
        return $data;
    }
}