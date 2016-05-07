<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/6
 * Time: 22:34
 * Version: weekly
 */
class Comment_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    /**
     * add  添加评论
     * @access public
     * @param $comment
     * @return mixed
     */
    public function add($comment){
        $this->db->insert('comment',$comment);
        return $this->db->affected_rows();
    }

    /**
     * delete 删除评论
     * @access public
     * @param $cid
     * @return mixed
     */
    public function delete($cid,$uid){
        $this->db->delete('comment',array('id'=>$cid));
        return $this->db->affected_rows();
    }
}