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

    public function list($uid){
        if($uid) {
            $datas = $this->base->select_array('*', 'weekly', 'uid', $uid);
        }else{
            //分页 按时间排序
            $res   = $this->db->select('*')->from($this->db->dbprefix('weekly'))->limit(1,1)->order_by('time desc')->get();
            $datas = $res->result_array();
        }
        $i = 0;
        foreach ($datas as $data){
            $weekly[$i]['id']      = $data['id'];
            $weekly[$i]['user']    = $this->base->select('uid,name,photo','user','uid',$data['uid']);
            $weekly[$i]['title']   = $data['title'];
            $weekly[$i]['content'] = $data['content'];
            $weekly[$i]['hits']    = $data['hits'];
            $weekly[$i]['agrees']  = $data['agrees'];
            $weekly[$i]['time']    = $data['update_time'];
            $weekly[$i]['comment'] = $this->get_comment($data['w_id']);
                $i++;
        }
        return $weekly;
    }

    public function get_comment($w_id){
        $datas = $this->base->select_array('*','comment','w_id',$w_id);
        $i = 0;
        foreach($datas as $data){
            $comments[$i]['id']   = $data['id'];
            $comments[$i]['commenter'] = $this->base->select('uid,name,photo','user','uid',$data['c_uid']);
            $comments[$i]['originer']  = $this->base->select('uid,name,photo','user','uid',$data['o_uid']);
            $comments[$i]['content']   = $data['content'];
            $comments[$i]['time']      = $data['time'];
            $i++;
        }

        return $comments;
    }
    
}