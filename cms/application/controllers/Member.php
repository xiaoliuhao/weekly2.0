<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/9
 * Time: 20:21
 * Version: weekly
 */
class Member extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Member_Model','member');
    }

    public function index(){
        $res = $this->db->select('*')->from('user')->get();
        $data = $res->result_array();
        var_dump($data);
        $this->load->view('contacts');
    }

    public function profile(){
//        $memberUid = $this->input->get('uid');
        $memberUid = 123;
        $data = $this->member->profile($memberUid);
        $this->load->view('profile',$data);
    }
}