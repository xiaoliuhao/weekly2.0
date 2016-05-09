<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/8
 * Time: 17:40
 * Version: weekly
 */
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Login_Model','login');
        $this->load->model('Base_Model','base');
    }

}