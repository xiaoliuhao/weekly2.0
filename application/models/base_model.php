<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/28
 * Time: 16:02
 * Version: weekly
 */
class Base_Model extends CI_Mdel{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->base_url = $this->config->item('base_url');
    }

    public function select($needs,$table,$key,$value){
        $data = $this->db->select($needs)->get_where($this->db->dbprefix($table),array($key=>$value))->row_array();
        return $data;
    }

    public function select_array($needs,$table,$key,$value){
        $res  = $this->db->select($needs)->from($table)->where($key,$value)->get();
        $data = $res->result_array();
        return $data;
    }

    public function write_user_log($uid,$action,$ip){
        $this->db->insert('log',array('uid'=>$uid,'action'=>$action,'ip'=>$ip,'time'=>date('Y-m-d H:i:s')));
    }
    
    public function write_group_log($gid,$uid,$action,$ip){
        $this->db->insert('group_log',array('g_id'=>$gid,'uid'=>$uid,'action'=>$action,'ip'=>$ip,'time'=>date('Y-m-d H:i:s')));
    }
}