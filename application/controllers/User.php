<?php
/**
 * Created by PhpStorm.
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/1
 * Time: 18:56
 */
class User extends CI_Controller{
    /**
     * User constructor.
     */
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model','user'); //引入
        $this->load->library('session');
        $this->load->library('form_validation');
    }


    public function login($id){
        $bool=true;
        $this->user->login();
        return $bool;
    }

}