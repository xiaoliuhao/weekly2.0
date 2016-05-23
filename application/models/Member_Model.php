<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/1
 * Time: 16:59
 * Version: weekly
 */
class Member_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    public function get_level($gid,$uid){
        $data = $this->base->select_needs('level','jion_group',array('g_id'=>$gid,'uid'=>$uid));
        return $data['level'];
    }

    /**
     * get_member_list 获取成员列表
     * @access public
     * @param $gid
     * @return mixed
     */
    public function get_member_list($gid){
        $datas = $this->base->select_array_needs('uid','jion_group',array('g_id'=>$gid,'level <'=>3));
        $datas = $this->base->select_array('uid','jion_group','g_id',$gid);

        $i = 0;
        foreach($datas as $data){
            $member[$i] = $this->base->select('uid,name,photo,register_time,last_time,last_ip','user','uid',$data['uid']);
            $member[$i]['level'] = $data['level'];
            $i++;
        }
        return $member;
    }


    /**
     * is_in_group  判断用户是否在组中
     * @access public
     * @param $gid
     * @param $uid
     * @return bool
     */
    public function is_in_group($gid,$uid){
        $data = $this->base->select_needs('*','jion_group',array('g_id'=>$gid,'uid'=>$uid));
        return $data?true:flase;
    }

    /**
     * delete_member    删除组内成员
     * @access public
     * @param $g_id
     * @param $uid
     * @param $member_id
     * @return int
     */
    public function delete_member($g_id,$uid,$member_id){
        $userInfo = $this->base->select_needs('level','jion_group',array('uid'=>$uid,'g_id'=>$g_id));
        $memberInfo = $this->base->select_needs('level','jion_group',array('g_id'=>$g_id,'uid'=>$member_id));
        if($userInfo['level'] > 1 || $userInfo['level'] <= $memberInfo['level']) {
            //权限不足 不是管理员 或者 不如对方权限高
            return 2;
        }else{
            $this->db->delete('jion_group',array('g_id'=>$g_id,'uid'=>$member_id));
//            是否要通知 被删除的 人 以及 被删除的人的同组的人员----
            return 1;
        }


    }

    /**
     * jion_group 加入小组
     * @access public
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public function jion_group($gid,$uid){
        $this->db->insert('jion_group',array('g_id' => $gid,'uid'=>$uid,'jion_time'=>date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    /**
     * apply    申请
     * @access public
     * @param $uid
     * @param $gid
     * @return mixed
     */
    public function apply($gid,$uid){
        $this->db->insert('group_apply',array('g_id'=>$gid,'uid'=>$uid,'status'=>1));
        return $this->db->affected_rows();
    }

    /**
     * quit 退出小组
     * @access public
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public function quit($gid,$uid){
//        --------------------------是否要通知小组的管理员
        $this->db->delete('jion_group',array('g_id'=>$gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }

}