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
    
    public function add($uid,$name,$time){
        $this->db->insert('group',array('g_name'=>$name,'g_register_tiem'=>$time));
        //先创建组，再获取自增的id
        $groupdata = $this->base->select('g_id','g_name'=>$name);
        //向组管理员中加入管理员信息，权限为超级管理员
        //再向选组(w_jion_group)中加入选组情况
        $this->db->insert('group_admin',array('g_id'=>$groupdata['g_id'],'uid'=>$uid,'level'=>0));
        $this->db->insert('jion_group',array('g_id'=>$groupdata['g_id'],'uid'=>$uid));
        //将用户行为写入日志
    }
    
    public function update($uid,$gid,$name){
        
    }
}