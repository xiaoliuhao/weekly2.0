<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/1
 * Time: 16:56
 * Version: weekly
 */

/**
 * Class Member 小组成员的类
 */
class Member extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Member_Model','member');
    }

    public function index(){
        
    }
    
    public function get_member_list(){
        $gid = $this->input->post('gid');
        $members = $this->member->get_member_list($gid);
        var_dump($members);
    }

    public function delete_member(){
        $admin_id  = $this->input->post('admin_id');
        $member_id = $this->input->post('member_id');
        $g_id      = $this->input->post('g_id');
        $result = $this->member->delete_member($g_id,$admin_id,$member_id);
        switch ($result){
            case 1:
                //删除成功
                break;
            case 2:
                //权限不足 删除失败
                break;
        }
    }

    public function jion_group(){
        $uid = $this->input->post('uid');
        $gid = $this->input->post('gid');

        $result = $this->member->jion_group($gid,$uid);
        if($result){
            //讲行为写入日志
            $this->base->write_user_log($uid,'jion a group which id is '.$gid);
            $this->base->write_group_log($gid,$uid,'jion in the group');
        }
    }

    public function quit(){
        $uid = $this->input->post('uid');
        $gid = $this->input->post('gid');

        $result = $this->member->quit($gid,$uid);
        if($result == 1){
            //退出小组成功 返回1
            echo 1;
        }
    }
}