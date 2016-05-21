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

    public function get(){
        $uid  = $this->login->is_log();
        $type = $this->input->post('type');
        $arr = $type == 'all'?array('uid'=>$uid):array('uid'=>$uid,'status'=>1);
        $data = $this->message->get($arr);
        MyJSON::show(200,'ok',$data);
    }
    
    public function detail(){
        $id = $this->input->get('id');
        $data = $this->message->detail($id);
        MyJSON::show(200,'ok',$data);
    }
}