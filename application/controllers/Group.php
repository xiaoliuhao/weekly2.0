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
    }

    public function index(){
        
    }

    public function add(){
        //小组的创建人就是超级管理员
        $uid = $this->input->post('uid');
        $g_info['g_name'] = $this->input->post('name');
        $g_info['g_introduce'] = $this->input->post('introduce');
        $g_info['g_create_uid'] = $uid;
        $g_info['g_create_time'] = date('Y-m-d H:i:s');
        $g_id = $this->group->add($uid,$g_info);

        //写入日志
        $this->base->write_user_log($uid,'create a group');
        $this->base->write_group_log($g_id,$uid,'create');

        //创建小组成功
        echo 1;
    }
    
    public function invite(){
        //邀请别人应该产生一个随机
        
    }

    public function members(){
        $gid = $this->input->get('gid');
        $data = $this->group->get_all_members($gid);
        MyJSON::show(200,'ok',$data);
    }

    public function all(){
        $data = $this->group->get_group_list();
        var_dump($data);
    }

    public function detail(){
        $gid  = $this->input->get('gid');
        $data = $this->group->detail($gid);
        MyJSON::show(200,'ok',$data);
    }

    public function update(){
        $uid = $this->input->post('uid');
        $groupInfo['g_id']        = $this->input->post('gid');
        $groupInfo['g_name']      = $this->input->post('name');
        $groupInfo['g_introduce'] = $this->input->post('introduce');
        $level = $this->member->get_level($groupInfo['g_id'],$uid);
        if($level > 1){
            //权限不足
        }else{
            $rows = $this->group->update($groupInfo);
            echo $rows==1?true:false;
        }

    }

    public function delete(){
        $uid    = $this->input->post('uid');
        $gid    = $this->input->post('gid');
        $result = $this->group->delete($uid,$gid);
        switch ($result){
            case 1:
                //删除成功
                break;
            case 2:
                //权限不足 删除失败
                break;
        }
    }
    
}