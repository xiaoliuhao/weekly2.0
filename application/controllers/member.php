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
class Member extends class{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Member_Model','member');
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