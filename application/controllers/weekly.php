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
        
    }
    
    public function delete(){
        
    }
}