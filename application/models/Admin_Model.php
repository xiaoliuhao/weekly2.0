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

    public function get_admin_list($gid){
        $datas = $this->base->select_array('*','group_admin','g_id',$gid);
        $i = 0;
        foreach($datas as $data){
            $admins[$i] = $this->base->select('*','user','uid',$data['uid']);
            $admins[$i]['level'] = $data['level'];
            $i++;
        }
        return $admins;
    }

    public function delete_admin($gid,$admin_id,$delete_id){
        $admin_info = $this->db->select('*')->get_where($this->db->dbprefix('group_admin'),array('uid'=>$admin_id,'g_id'=>$gid));
        $delete_info = $this->db->select('*')->get_where($this->db->dbprefix('group_admin'),array('uid'=>$delete_id,'g_id'=>$gid));

        if($admin_info['level'] < $delete_info['level']){
            //如果当前管理员权限大于需要被删除的管理员权限
            $this->db->delete('group_admin',array('uid'=>$delete_id));
            return 1;
        }else{
            return 2;   //权限不足
        }
    }
    
    public function change_level($gid,$admin_id,$change_id,$level){
        $admin_info = $this->db->select('*')->get_where($this->db->dbprefix('group_admin'),array('uid'=>$admin_id,'g_id'=>$gid));
        $change_info = $this->db->select('*')->get_where($this->db->dbprefix('group_admin'),array('uid'=>$change_id,'g_id'=>$gid));
        if($admin_info['level'] < $delete_info['level']){
            //如果当前管理员权限大于需要被删除的管理员权限
            $this->db->update('group_admin',array('level'=>$level),array('uid'=>$delete_id));
            return 1;
        }else{
            return 2;   //权限不足
        }
    }
    
    
}