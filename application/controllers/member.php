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
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class Member extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Member_Model','member');
        $this->load->model('Login_Model','login');
        $this->load->model('Message_Model','message');
    }

    /**
     * index
     * @access public
     */
    public function index(){
        echo 'member.php';
    }

    /**
     * delete_member 移除成员
     * @access public
     */
    public function delete(){
        $uid  = $this->login->is_log();
        $member_id = $this->input->post('member_id');
        $g_id      = $this->input->post('g_id');
        $result = $this->member->delete_member($g_id,$uid,$member_id);
        switch ($result){
            case 1:
                //删除成功
                echo 1;
                break;
            case 2:
                //权限不足 删除失败
                echo 2;
                break;
        }
    }

    /**
     * jion_group 加入小组
     * @access public
     */
    public function jion_group(){
        $user['uid']      = $this->login->is_log();
        $member_id        = $this->input->post('uid');
        $gid              = $this->input->post('gid');
        //判断操作的人是不是管理员
        $user['level']    = $this->member->get_level($gid,$user['uid']);
        if($user['level'] < 2) {
            $result = $this->member->jion_group($gid, $member_id);
            if ($result) {
                $group_info = $this->group->detail($gid);
                //通知该成员
                $this->message->add($member_id,'你申请的 '.$group_info['g_name'].' 已经通过管理员的审核,欢迎您的加入！');
                //将行为写入日志
                $this->base->write_user_log($uid, 'jion a group which id is ' . $gid);
                $this->base->write_group_log($gid, $uid, 'jion in the group');
            }
        }
    }

    /**
     * apply 申请加入小组
     * @access public
     */
    public function apply(){
//        $apply['uid']    = $this->input->post('uid');
        $apply['uid']    = $this->login->is_log();
        $apply['gid']    = $this->input->post('gid');
        $apply['reason'] = $this->input->post('reason');
        $bool   = $this->member->is_in_group($gid,$uid);
        if(!$bool){
            $this->member->apply($uid,$gid);
        }
    }

    /**
     * quit 退出小组
     * @access public
     */
    public function quit(){
        $uid = $this->input->post('uid');
        $gid = $this->input->post('gid');

        $result = $this->member->quit($gid,$uid);
        if($result == 1){
            //退出小组成功 返回1
            echo 1;
        }
    }


    /**
     * notice   获取未读消息
     * @access public
     */
    public function notice(){
        $data = $this->user->get_notice_list($uid);
        var_dump($data);
    }

    /**
     * notice_all   获取全部消息
     * @access public
     */
    public function notice_all(){
        $data = $this->user->get_notice_all($uid);
        var_dump($data);
    }
}