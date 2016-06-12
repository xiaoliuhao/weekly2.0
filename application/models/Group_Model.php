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
        $res = $this->db->select('*')->from('v_group_detail')->order_by('g_id desc')->get();
        $datas = $res->result_array();
//        $datas = $this->base->select_any('*','group');
        return $datas;
    }

    /**
     * get_all_admins   获取全部管理员
     * @access public
     * @param $gid
     * @return mixed
     */
    public function get_all_admins($gid){
        $res = $this->db->select('*')->from('v_all_members')->where(array('g_id'=>$gid,'level <='=>1))->order_by('level asc')->get();
        $data =$res->result_array();
        return $data;
    }

    /**
     * get_all_members 获取所有成员
     * @access public
     * @param $gid
     * @return mixed
     */
    public function get_all_members($gid){
        $data = $this->base->select_array('*','v_all_members','g_id',$gid);
        return $data;
    }

    /**
     * get_group_detail  获取小组详细信息
     * @access public
     * @param $gid
     * @return mixed
     */
    public function detail($gid){
        $data = $this->base->select('*','v_group_detail','g_id',$gid);
//        $data['members_info'] = $this->get_all_members($gid);
        return $data;
    }

    /**
     * add 创建小组
     * @access public
     * @param $uid
     * @param $g_info
     * @return mixed
     */
    public function add($uid,$g_info){
        $this->db->insert('group',$g_info);
        //先创建组，再获取自增的id
        $gid = $this->db->insert_id();
        //创建小组的人即为管理员
        $this->db->insert('jion_group',array('g_id'=>$gid,'uid'=>$uid,'level'=>0));

        return $gid;
    }

    /**
     * delete   删除小组
     * @access public
     * @param $gid
     * @return mixed
     */
    public function delete($gid){
        $this->db->delete('group',array('g_id'=>$gid));
        return $this->db->affected_rows();
    }

    /**
     * update
     * @access public
     * @param $groupInfo
     * @return mixed
     */
    public function update($groupInfo){
        $this->base->update('group', $groupInfo, array('g_id' => $groupInfo['g_id']));
        return $this->db->affected_rows();
    }

    /**
     * add_comment  像小组添加留言
     * @access public
     * @param $g_id
     * @param $uid
     * @param $content
     * @param $time
     * @return mixed
     */
    public function add_comment($g_id,$uid,$content,$time){
        $this->db->insert('group_comment',array('g_id'=>$g_id,'uid'=>$uid,'content'=>$content,'time'=>$time));
        return $this->db->affected_rows();
    }

    /**
     * get_comments 获取小组全部的留言内容
     * @access public
     * @param $g_id
     * @return mixed
     */
    public function get_comments($g_id){
        $data = $this->base->select('*','group_comment','g_id',$g_id);
        return $data;
    }
}