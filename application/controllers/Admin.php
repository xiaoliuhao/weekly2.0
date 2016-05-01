<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/1
 * Time: 18:39
 * Version: weekly
 */
class Admin extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Amdin_Model','admin');
        $this->load->model('Base_Model','base');
    }

    

    public function get_member_list(){
        $this->input->get('gid');
        $this->input->post('uid');
        $members = $this->admin->get_member_list($gid);
    }

    

}