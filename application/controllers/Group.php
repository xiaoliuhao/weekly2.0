<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/28
 * Time: 16:02
 * Version: weekly
 */
class Group extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        
    }

    public function add(){
        $uid = $this->input->post('uid');
    }

    public function delete(){
        
    }


    public function test(){
        echo 'liu';
        echo 'hao';
    }
}