<?php
/**
 * Created by PhpStorm.
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/1
 * Time: 18:56
 * Version: weekly
 */
class User extends CI_Controller{
    /**
     * User constructor.
     */
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('User_Model','user'); //引入
        $this->load->database();
        $this->load->library('session');
    }

    public function check_login(){
        
    }

    public function register(){
        


    }

    public function logout(){

    }

    public function detail(){

    }

    public function add_photo(){

    }

    public function update(){

    }

}