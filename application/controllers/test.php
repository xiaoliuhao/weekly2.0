<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/5/4
 * Time: 19:51
 * Version: weekly
 */
header('Access-Control-Allow-Origin:*');
class Test extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
        $this->load->helper('cookie');
    }

    public function index(){
        echo 'mmp';
    }

    public function getName(){

    }

    public function select(){
        $res=$this->db->select('*')->from('jion_group')->where(array('level >='=>1,))->get();
        $data = $res->result();
        echo $this->db->last_query();
        var_dump($data);
    }


    public function insert(){
        $this->db->insert('group',array('g_name'=>'test','g_introduce'=>'123'));
        echo $this->db->insert_id();
    }



}