<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/29
 * Time: 18:16
 * Version: weekly
 */
class Weekly extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->model('Weekly_Mode','weekly');
    }
    
    public function index(){
        
    }
    
    public function add(){
        $article['uid'] = $this->input->post('uid');
        $article['title'] = $this->input->post('title');
        $article['content'] = $this->input->post('content');
        $article['update_time'] = date('Y-m-d H:i:s');
        $this->base->insert('weekly',$article);
    }
    
    public function delete(){
        $id = $this->input->get('id');
        $this->weekly->delete($id);
    }

    public function update(){
        $id = $this->input->get('id');
        $article['title'] = $this->input->post('title');
        $article['content'] = $this->input->post('content');
        $article['update_time'] = date('Y-m-d H:i:s');

        $this->base->update('weekly',$article,array('id'=>$id))
    }


}