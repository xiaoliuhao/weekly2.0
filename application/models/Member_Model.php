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

    /**
     * get_member_list 获取成员列表
     * @access public
     * @param $gid
     * @return mixed
     */
    public function get_member_list($gid){
        $datas = $this->base->select_array('uid','jion_group','g_id',$gid);
        $i = 0;
        foreach($datas as $data){
            $member[$i] = $this->base->select('uid,name,photo,register_time,last_time,last_ip','user','uid',$data['uid']);
            $i++;
        }
        return $member;
    }

    /**
     * member_detail 获取用户的详细信息
     * @access public
     * @param $gid
     * @return mixed
     */
    public function member_detail($gid){
        $member_detail = $this->base->select('*','user','uid',$gid);
        return $member_detail;
    }

    public function delete_member($g_id,$admin_id,$member_id){
        $admin_info = $this->base->select('level','group_admin','uid',$admin_id);
        if($admin_info['level'] >= 2){
            //权限不足 删除失败
            return 2;
        }else{
            //判断需要删除的人是不是管理员
            $is_admin = $this->base->select('*','group_admin','uid',$member_id);
            if(!$is_admin){
                //如果不是管理员 直接删除w_jion_group 小组中的用户id就好
                $this->db->delete('jion_group',array('g_id'=>$g_id,'uid'=>$member_id));
                return 1;
            }elseif($is_admin['level'] > $admin_info['level']){
                //如果是管理员  比较一下权限
                $this->db->delete('jion_group',array('g_id'=>$g_id,'uid'=>$member_id));
                $this->db->delete('group_admin',array('g_id'=>$g_id,'uid'=>$member_id));
                return 1;
            }else{
                //权限不足 无法将与自己等级相同 以及 比自己权限高的管理员踢出小组
                return 2;
            }
        }
    }
    
    public function jion_group($gid,$uid){
        $this->db->insert('jion_group',array('g_id' => $gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }

    public function apply($uid,$gid){

    }

    public function quit($gid,$uid){
//        --------------------------是否要通知小组的管理员
        $this->db->delete('jion_group',array('g_id'=>$gid,'uid'=>$uid));
        return $this->db->affected_rows();
    }

}