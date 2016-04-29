<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/29
 * Time: 13:34
 * Version: weekly
 */
class Ulog_Model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    /**
     * write_log 写入日志
     * @access public
     * @param $table    用户日志还是小组日志
     * @param $uid      用户账号
     * @param $action   行为
     */
    public function add($table,$uid,$action){
        $ip = $_SERVER["REMOTE_ADDR"];
        $time = date('Y-m-d H:i:s');
        $this->db->insert($table,array('uid'=>$uid,'action'=>$action,'ip'=>$ip,'time'=>date('Y-m-d H:i:s')));
    }
}