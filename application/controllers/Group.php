<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/28
 * Time: 16:02
 * Version: weekly
 */
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class Group extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Group_Model','group');
        $this->load->model('Member_Model','member');
        $this->load->model('Login_Model','login');
    }

    public function index(){
        echo '当前位置：group.php';
    }

    public function add(){
        //小组的创建人就是超级管理员
        $uid = $this->login->is_log();
        $g_info['g_name'] = $this->input->post('name');
        $g_info['g_introduce'] = $this->input->post('introduce');
        $g_info['g_create_uid'] = $uid;
        $g_info['g_create_time'] = date('Y-m-d H:i:s');
        $g_id = $this->group->add($uid,$g_info);

        //写入日志
        $message = '创建了一个组id:'.$g_id.'name：'.$g_info['g_name'];
        $this->base->write_user_log($uid,$message);
        $this->base->write_group_log($g_id,$uid,$message);

        //创建小组成功
        MyJSON::show(200,'ok');
    }

    public function admins(){
        $gid = $this->input->get('gid');
        $data = $this->group->get_all_admins($gid);

        MyJSON::show(200,'ok',$data);
    }
    
    public function members(){
        $gid = $this->input->get('gid');
        $data = $this->group->get_all_members($gid);
        MyJSON::show(200,'ok',$data);
    }

    public function all(){
        $data = $this->group->get_group_list();
        MyJSON::show(200,'ok',$data);
    }

    public function detail(){
        $gid  = $this->input->get('gid');
        $data = $this->group->detail($gid);
        MyJSON::show(200,'ok',$data);
    }

    /**
     * update
     * @access public
     */
    public function update(){
        $uid = $this->input->post('uid');
        $groupInfo['g_id']        = $this->input->post('gid');
        $groupInfo['g_name']      = $this->input->post('name');
        $groupInfo['g_introduce'] = $this->input->post('introduce');
        $level = $this->member->get_level($groupInfo['g_id'],$uid);
        if($level > 1){
            //权限不足
            MyJSON::show(203,'权限不足');
        }else{
            $rows = $this->group->update($groupInfo);
            if($rows == 1){
                //删除成功
                MyJSON::show(200,'ok');
            }
        }
    }

    public function delete(){
        $uid    = $this->login->is_log();
        $gid    = $this->input->post('gid');
        $level  = $this->member->get_level($gid,$uid);
        //只有创建人才可以删除小组
        if($level != 0){
            //权限不足
            MyJSON::show(203,'权限不足');
        }else {
            $rows = $this->group->delete($gid);
            if($rows == 1){
                //删除成功
                MyJSON::show(200,'ok');
            }
        }
    }
    
}