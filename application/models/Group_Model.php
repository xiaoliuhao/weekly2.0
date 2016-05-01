<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/30
 * Time: 19:59
 * Version: weekly
 */
class Group_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }
    
    public function add($uid,$g_info){
        $this->db->insert('group',$g_info);
        //先创建组，再获取自增的id
        $groupdata = $this->base->select('g_id','g_name'=>$g_info['name']);
        //向组管理员中加入管理员信息，权限为超级管理员
        //再向选组(w_jion_group)中加入选组情况
        $this->db->insert('group_admin',array('g_id'=>$groupdata['g_id'],'uid'=>$uid,'level'=>0));
        $this->db->insert('jion_group',array('g_id'=>$groupdata['g_id'],'uid'=>$uid));

        return $groupdata['g_id'];
    }
    
    public function delete($uid,$gid){
        $data = $this->db->select('*')->get_where('group_admin',array('uid'=>$uid,'gid'=>$gid));
        if($data['level'] != 0){
            //权限不足删除失败
            return 2;
        }else{
            $this->base->delete('')
        }
    }

    public function update($uid,$groupInfo){
        $admin = $this->base->select('*','group_admin','g_id',$groupInfo['g_id']);
        if($admin['level'] >= 2){
            //权限不足
            return 2;
        }else {
            $this->base->update('group', $groupInfo, array('g_id' => $groupInfo['g_id']));
            return 1;
        }
    }
}