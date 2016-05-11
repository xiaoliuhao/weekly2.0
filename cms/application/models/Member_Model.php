<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/9
 * Time: 20:37
 * Version: weekly
 */
class Member_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    public function profile($uid){
        $data = $this->base->select('*','user','uid',$uid);
        return 1;
    }


}