<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/8
 * Time: 17:40
 * Version: weekly
 */
class Login_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    public function check_login($name,$password){
        $admin = $this->base->select('*','admin','admin',$name);

        if($admin['password'] == sha1(sha1(md5($password)))){
            return $admin;
        }else{
            return 0;
        }
    }
}