<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/21
 * Time: 20:41
 * Version: weekly
 */
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class Message extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Login_Model','login');
        $this->load->model('Message_Model','message');
    }

    /**
     * get
     * @access public
     */
    public function get(){
        $uid  = $this->login->is_log();
        $type = $this->input->post('type');
        $arr = $type == 'all'?array('uid'=>$uid):array('uid'=>$uid,'status'=>1);
        $data = $this->message->get($arr);
        MyJSON::show(200,'ok',$data);
    }

    /**
     * detail
     * @access public
     */
    public function detail(){
        $id = $this->input->get('id');
        $data = $this->message->detail($id);
        MyJSON::show(200,'ok',$data);
    }

    /**
     * add  添加新消息
     * @access public
     */
    public function add(){
        $uid = $this->input->post('uid');
        $message = $this->input->post('message');
        $this->message->add($uid,$message);
    }

    /**
     * delete   删除消息
     * @access public
     */
    public function delete(){
        $id     = $this->input->post('id');
        $uid    = $this->login->is_log();

        $rows   = $this->message->delete($id,$uid);
        if($rows){
            MyJSON::show(200,'ok');
        }else{
            MyJSON::show(203,'删除失败');
        }
    }

    /**
     * update   标记消息为已读
     * @access public
     */
    public function update(){
        $id     = $this->input->get('id');
        $rows   = $this->message->update($id);
        if($rows) {
            MyJSON::show(200, 'ok');
        }else{
            MyJSON::show(203,'标记已读失败');
        }
    }
}