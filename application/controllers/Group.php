<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/28
 * Time: 16:02
 * Version: weekly
 */
class Group extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        
    }

    public function add(){
        //小组的创建人就是超级管理员
        $uid = $this->input->post('uid');
        $group['g_name'] = $this->input->post('uid');
        $group['g_register_time'] = date('Y-m-d H:i:s');
        $this->base->insert('');
    }

    public function delete(){
        
    }


    public function test(){
        echo 'liu';
        echo 'hao';
    }
}