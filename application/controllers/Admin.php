<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/1
 * Time: 18:39
 * Version: weekly
 */
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class Admin extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Admin_Model','admin');
        $this->load->model('Base_Model','base');
        $this->load->model('User_Model','user');
        $this->load->model('Member_Model','member');
        $this->load->model('Group_Model','group');
        $this->load->model('Message_Model','group');
    }

    public function get_message(){
        $data['uid'] = $this->login->is_log();
        $data['gid'] = $this->input->post('gid');
        $level = $this->member->get_level($data['gid'],$data['uid']);
        if($level != 0 ) {
            //权限不足
            MyJSON::show(203, '权限不足');
            exit(0);
        }else{
            return $data;
        }
    }

    public function add(){
        $data = $this->get_message();
        $uid  = $this->input->post('member_id');
        $this->admin->add($data['gid'],$uid);
    }

    /**
     * delete   取消管理员身份
     * @access public
     */
    public function delete(){
        $data = $this->get_message();
        $admin_id = $this->input->post('admin_id');
        $this->admin->delete($data['gid'],$admin_id);
    }

    /**
     * check_members 获取申请成员列表
     * @access public
     */
    public function check_members(){
        $user['uid'] = $this->log->is_log();
        $gid = $this->input->post('gid');
        $user['level'] = $this->user->get_group_level($gid,$user['uid']);

        if($user['level'] <= 1){
            $data = $this->admin->get_apply_members($gid);
//            写入日志
            $this->base->write_group_log($gid,$user['uid'],'查看所有申请加入的成员列表');
            $this->base->write_user_log($user['uid'],'查看'.$gid.'所有申请加入的成员列表');
            MyJSON::show(200,'ok',$data);
        }else{
            MyJSON::show(203,'权限不足');
        }
    }

    /**
     * add_member
     * @access public
     */
    public function add_member(){
        $data = $this->get_apply();
        if($data == 2) {
            MyJSON::show(203,'权限不足');
        }
        $this->admin->add_member($data['gid'],$data['apply_id']);
        //应在加上通知此人管理员已经同意审核 加入该群
        $group_info = $this->group->detail($data['gid']);
        $this->message->add($data['apply_id'],'您申请的 '.$group_info['g_name'].' 已经通过管理员的审核,欢迎您的加入！');
        //管理员操作写入日志
        $this->base->write_group_log($data['gid'],$data['uid'],'同意 '.$data['apply_id'].' 加入');
        $this->base->write_user_log($data['uid'],'同意'.$group_info['g_name'].'中'.$data['apply_id'].'加入');
        MyJSON::show(200,'ok');
    }

    /**
     * refuse
     * @access public
     */
    public function refuse(){
        $data = $this->get_apply();
        $this->admin->refuse($data['gid'],$data['apply_id']);
        //通知此人 管理员拒绝其加入
        $group_info = $this->group->detail($data['gid']);
        $this->message->add($data['apply_id'],'管理员拒绝您加入 '.$group_info['g_name']);
        //管理员操作写入日志
        $this->base->write_group_log($data['gid'],$data['uid'],'拒绝 '.$data['apply_id'].' 加入');
        $this->base->write_user_log($data['uid'],'拒绝'.$group_info['g_name'].'中'.$data['apply_id'].'加入');
        MyJSON::show(200,'ok');
    }
    
    

}