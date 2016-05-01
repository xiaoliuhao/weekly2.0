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
        $this->load->model('Group_Model','group');
    }

    public function index(){
        
    }

    public function add(){
        //小组的创建人就是超级管理员
        $g_name = $this->input->post('uid');
        $g_register_time = date('Y-m-d H:i:s');
        $this->group->add($uid,$g_name,$g_register_time);


        //先创建小组 然后再向祖管理员中和加小组的表中加入数据
        $this->base->insert('group',$group);

        //向管理员中加入数据
        $uid = $this->input->post('uid');

    }

    public function update(){
        $g_id = $this->input->post('gid');
        $uid  = $this->input->post('uid');
        $name = $input('name');
        
    }

    public function delete(){
        
    }


    public function test(){
        echo 'liu';
        echo 'hao';
    }
}