<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/4
 * Time: 21:02
 * Version: weekly
 */
class Weekly_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    public function all($uid,$orderby){
        if($uid) {
            $datas = $this->base->select_array('*', 'v_all_weekly', 'uid', $uid);
        }else{
            //分页 按时间排序
            $res   = $this->db->select('*')->from($this->db->dbprefix('v_all_weekly'))->order_by($orderby.' desc')->get();
            $datas = $res->result_array();
        }
        $i = 0;
        foreach ($datas as $data) {
            $weekly[$i] = $data;
            $weekly[$i]['comments'] = $this->get_comment($data['id']);
            $i++;
        }
        return $weekly;
    }

    public function getall($uid,$orderby){
        $res = $this->db->select('*')->from('v_all_weekly')->limit()->order_by('update_time desc')->get();
        $data = $res->result_array();
        return $data;
    }

    public function get_comment($w_id){
        $comments = $this->base->select_array('*','v_comments','w_id',$w_id);
        return $comments?$comments:null;
    }

    public function detail($wid){
        $data = $this->base->select('*','v_all_weekly','id',$wid);
        $data['comments'] = $this->get_comment($wid);
        return $data;
    }

    public function agree($uid,$wid){
        $this->db->insert('weekly_agree',array('w_id'=>$wid,'uid'=>$uid,'time'=>date('Y-m-d H:i:s')));
        return $this->db->affected_rows();
    }
    
}