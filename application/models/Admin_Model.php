<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/1
 * Time: 19:03
 * Version: weekly
 */
class Admin_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    /**
     * add  设置管理员
     * @access public
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public function add($gid,$uid){
        $this->db->update('jion_group',array('level'=>1),array('g_id'=>$gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }

    /**
     * delete
     * @access public
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public function delete($gid,$uid){
        $this->db->update('jion_group',array('level'=>2),array('g_id'=>$gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }

    public function get_group_level($gid,$uid){
        $data = $this->base->select_needs('*','jion_group',array('g_id'=>$gid,'uid'=>$uid));
        return $data['level'];
    }

    /**
     * get_apply_members
     * @access public
     * @param $gid
     * @return mixed
     */
    public function get_apply_members($gid){
        $data = $this->base->select_array('*','v_apply_members','g_id',$gid);
        return $data;
    }

    /**
     * add_member
     * @access public
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public function add_member($gid,$uid){
        $this->db->delete('group_apply',array('uid'=>$uid,'g_id'=>$gid));
        $this->db->insert('jion_group',array('g_id'=>$gid,'uid'=>$uid,'level'=>2,'jion_time'=>date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }

    /**
     * refuse_member
     * @access public
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public function refuse_member($gid,$uid){
        $this->db->delete('group_apply',array('uid'=>$uid,'g_id'=>$gid));
        return $this->db->affected_rows();
    }
    
    
}