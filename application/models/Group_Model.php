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

    public function get_member_numbers($gid){
        
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
        $data['members'] = $this->get_all_members($gid);
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
    
    public function delete($uid,$gid){
        $data = $this->db->select('*')->get_where('group_admin',array('uid'=>$uid,'gid'=>$gid));
        if($data['level'] != 0){
            //权限不足删除失败
            return 2;
        }else{
//            $this->base->delete('')
        }
    }

    public function update($groupInfo){
        $this->base->update('group', $groupInfo, array('g_id' => $groupInfo['g_id']));
        return $this->db->affected_rows();
    }
}