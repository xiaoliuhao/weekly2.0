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
    }


    /**
     * get_admin_list 获取管理员列表
     * @access public
     */
    public function get_admin_list(){
        $this->input->get('gid');
        $admins = $this->admin->get_admin_list($gid);
        var_dump($admins);
    }

    /**
     * delete_admin 删除管理员
     * @access public
     */
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

    /**
     * change_level 更改管理员权限
     * @access public
     */
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

    public function check_members(){
        $user['uid'] = $this->log->is_log();
        $gid = $this->input->post('gid');
        $user['level'] = $this->user->get_group_level($gid,$user['uid']);

        if($user['level'] <= 1){
            $data = $this->admin->get_apply_members($gid);
            MyJSON::show(200,'ok',$data);
        }
    }

    /**
     * get_apply 获取被操作申请人的信息
     * @access public
     * @return int
     */
    public function get_apply(){
        $data['uid']        = $this->log->is_log();
        $data['apply_id']   = $this->input->post('applyid');
        $data['gid']        = $this->input->post('gid');
        $level              = $this->input->get_group_level($gid,$uid);

        if($level <=1 ){
            return $data;
        }else{
            //权限不足，无法审核通过
            return 2;
        }
    }

    /**
     * add_member
     * @access public
     */
    public function add_member(){
        $data = $this->get_apply();
        $this->admin->add_member($data['gid'],$data['apply_id']);
//        应在加上通知此人管理员已经同意审核 加入该群
    }
    
    public function refuse(){
        $data = $this->get_apply();
        $this->admin->refuse($data['gid'],$data['apply_id']);
//        通知此人 管理员拒绝其加入
    }
    
    

}