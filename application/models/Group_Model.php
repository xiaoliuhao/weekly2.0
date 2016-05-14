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

    /**
     * get_group_list   获取小组列表
     * @access public
     * @return mixed
     */
    public function get_group_list(){
        $datas = $this->base->select_any('*','group');
        return $datas;
    }

    public function get_member_numbers($gid){
        
    }

    public function get_group_detail($gid){
        $data = $this->base->select('*','group','g_id',$gid);
        $data['member'] = $this->base->select_array('uid','jion_group','g_id',$gid);
        return $data;
    }
    
    public function add($uid,$g_info){
        $this->db->insert('group',$g_info);
        //先创建组，再获取自增的id
        $gid = $this->db->insert_id();
        //创建小组的人即为管理员
        $this->db->insert('jion_group',array('g_id'=>$gid,'uid'=>$uid,'level'=>0));

        return $gid;
    }
    
    public function delete($uid,$gid){
        $data = $this->db->select('*')->get_where('group_admin',array('uid'=>$uid,'gid'=>$gid));
        if($data['level'] != 0){
            //权限不足删除失败
            return 2;
        }else{
//            $this->base->delete('')
        }
    }

    public function update($uid,$groupInfo){
//        $admin = $this->base->select('*','group_admin','g_id',$groupInfo['g_id']);
        $admin = $this->db->select('*')->get_where($this->db->dbprefix('group_admin'),array('g_id'=>$groupInfo['g_id'],'uid'=>$uid));
        if($admin['level'] >= 2){
            //权限不足
            return 2;
        }else {
            $this->base->update('group', $groupInfo, array('g_id' => $groupInfo['g_id']));
            return 1;
        }
    }
}