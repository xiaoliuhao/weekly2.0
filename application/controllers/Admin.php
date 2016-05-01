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

    

    public function get_admin_list(){
        $this->input->get('gid');
        $admins = $this->admin->get_member_list($gid);
        var_dump($admins);
    }

    public function delete_admin(){
        $g_id     = $this->inpit->post('gid');
        $admin_id = $this->input->post('admin_id');  //当前管理员id
        $delete_id= $this->input->post('delete_id'); //需要被删除的管理员id
        $result   = $this->admin->delete_admin($g_id,$admin_id,$delete_id);
        if($result == 1){
            //删除成功
        }else{
            //权限不足删除失败
        }
    }

    public function change_level(){
        $g_id     = $this->input->post('gid');
        $admin_id = $this->input->post('admin_id'); //当前管理员uid
        $change_id= $this->input->post('uid');
        $new_level= $this->input->post('level');

        $result   = $this->admin->change_level($g_id,$admin_id,$change_id,$new_level);
        if($result == 1){
            //修改成功 将行为写入日志
            $this->base->write_group_log($g_id,$admin_id,'change'.$change_id.'level as'.$new_level);
        }else{
            //权限不足修改失败
        }
    }

}