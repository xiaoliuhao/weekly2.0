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
        $datas = $this->base->select_array('*','weekly','uid',$uid);
        $i = 0;
        foreach ($datas as $data){
            $weekly[$i]['id']      = $data['id'];
            $weekly[$i]['user']    = $this->base->select('uid,name,photo','user','uid',$data['uid']);
            $weekly[$i]['title']   = $data['title'];
            $weekly[$i]['content'] = $data['content'];
            $weekly[$i]['hits']    = $data['hits'];
            $weekly[$i]['agrees']  = $data['agrees'];
            $weekly[$i]['time']    = $data['update_time'];
            $weekly[$i]['comment'] = $this->comment($data['w_id']);
                $i++;
        }
        return $weekly;
    }

    public function comment($w_id){
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