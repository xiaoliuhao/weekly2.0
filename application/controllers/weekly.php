<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/29
 * Time: 18:16
 * Version: weekly
 */
require 'my_json.php';
header('Access-Control-Allow-Origin:*');
class Weekly extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Weekly_Model','weekly');
        $this->load->model('Comment_Model','comment');
        $this->load->model('Login_Model','login');
    }
    
    public function index(){
        echo 'weekly.php';
    }

    /**
     * get_weekly
     * @access public
     * @return mixed
     */
    public function get_weekly(){
        $article['uid'] = $this->login->is_log();
        $article['title'] = $this->input->post('title');
        $article['content'] = $this->input->post('content');
        $article['update_time'] = date('Y-m-d H:i:s');

        return $article;
    }

    /**
     * add
     * @access public
     */
    public function add(){
        $article = $this->get_weekly();
        $rows = $this->base->insert('weekly',$article);
        if($rows == 1){
            MyJSON::show(200,'ok');
        }
    }

    /**
     * delete
     * @access public
     */
    public function delete(){
        $uid = $this->login->is_log();
        $id = $this->input->post('id');
        $this->weekly->delete($id);
    }

    /**
     * update
     * @access public
     */
    public function update(){
        $id = $this->input->post('id');
        $article = $this->get_weekly();
        $rows = $this->base->update('weekly',$article,array('id'=>$id));
        if ($rows == 1){
            MyJSON::show(200,'ok');
        }
    }

    public function all(){
        $orderby = $this->input->get('orderby');
        $uid = $this->input->get('uid');

        if(!$orderby) {
            $orderby = 'update_time';
        }
        
        $data = $this->weekly->all($uid,$orderby);
        MyJSON::show(200,'ok',$data);
    }

    public function agree(){
        $uid = $this->login->is_log();
        $w_id = $this->input->post('wid');
        $data = $this->base->select_needs('*','weekly_agree',array('w_id'=>$w_id,'uid'=>$uid));
        if($data){
            //已经赞过 不能再赞
            MyJSON::show(199,'已经赞过');
        }else{
            $rows = $this->weekly->agree($uid,$w_id);
            if($rows){
                MyJSON::show(200,'ok');
            }
        }

    }

    public function detail(){
        $w_id = $this->input->get('wid');
        $data = $this->weekly->detail($w_id);
        MyJSON::show(200,'ok',$data);
    }
    
    public function comment(){
        $comment['uid']     = $this->input->post('w_id');
        $comment['c_uid']   = $this->input->post('c_uid');
        //这个可以通过 w_id 然后再数据库中查询得到
//        $comment['o_uid']   = $this->input->psot('o_uid');
        $comment['content'] = $this->input->post('content');
        $comment['time']    = date('Y-m-d H:i:s');
        $rows = $this->comment->add($comment);
        if($rows){
            MyJSON::show(200,'ok');
        }
    }

    public function delete_comment(){
        $cid = $this->input->post('c_id');
        $this->comment->delete($cid);
    }


}