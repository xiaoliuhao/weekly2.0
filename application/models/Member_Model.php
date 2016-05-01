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
    
    public function jion_group($gid,$uid){
        $this->db->insert('jion_group',array('g_id' => $gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }

    public function quit($gid,$uid){
//        --------------------------是否要通知小组的管理员
        $this->db->delete('jion_group',array('g_id'=$gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }
}