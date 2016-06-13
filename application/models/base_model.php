<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/28
 * Time: 16:02
 * Version: weekly
 */
class Base_Model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->base_url = $this->config->item('base_url');
    }

    /**
     * select 单条查询 ， 返回单条记录 ， 默认最后一条
     * @access public
     * @param $needs    需要查询的字段
     * @param $table    需要查询的表
     * @param $key      查询字段约束条件
     * @param $value    字段约束的值
     * @return mixed    返回查询的数据 一个数组
     */
    public function select($needs,$table,$key,$value){
        $data = $this->db->select($needs)->get_where($this->db->dbprefix($table),array($key=>$value))->row_array();
        return $data;
    }

    /**
     * select_needs
     * @access public
     * @param $needs
     * @param $table
     * @param $array
     * @return mixed
     */
    public function select_needs($needs,$table,$array){
        $data = $this->db->select($needs)->get_where($this->db->dbprefix($table),$array)->row_array();
        return $data;
    }

    public function select_any($needs,$table){
        $res  = $this->db->select($needs)->from($table)->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * select_array 多条查询 返回多条记录
     * @access public
     * @param $needs    需要查询的字段
     * @param $table    需要查询的表
     * @param $key      查询字段约束条件
     * @param $value    字段约束的值
     * @return mixed    返回查询的数据 一个多维数组
     */
    public function select_array($needs,$table,$key,$value){
        $res  = $this->db->select($needs)->from($table)->where($key,$value)->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * select_array_needs
     * @access public
     * @param $needs
     * @param $table
     * @param $array
     * @return mixed
     */
    public function select_array_needs($needs,$table,$array){
        $res  = $this->db->select($needs)->from($table)->where($array)->get();
        $data = $res->result_array();
        return $data;
    }

    /**
     * insert  插入数据
     * @access public
     * @param $table    需要插入的数据库表名
     * @param $data     需要插入的值
     * @return mixed    返回影响的行数 一般为1
     */
    public function insert($table,$data){
        $this->db->insert($this->db->dbprefix($table),$data);
        return $this->db->affected_rows();
    }

    /**
     * update   更新数据库中的数据
     * @access public
     * @param $table    需要更新的表名
     * @param $data     需要更新的数据
     * @param $where    更新条件
     * @return mixed    返回影响的行数 一般为1
     */
    public function update($table,$data,$where){
        $this->db->update($table,$data,$where);
        return $this->db->affected_rows();
    }

    /**
     * delete 删除数据
     * @access public
     * @param $table    需要删除的表明
     * @param $data     删除条件
     * @return mixed    返回删除的行数
     */
    public function delete($table,$where){
        $this->db->delete($table,$where);
        return $this->dn->affected_rows();
    }

    /**
     * write_user_log
     * @access public
     * @param $uid
     * @param $action
     * @param $ip
     */
    public function write_user_log($uid,$action){
        $ip = $_SERVER["REMOTE_ADDR"];
        $this->db->insert('user_log',array('uid'=>$uid,'action'=>$action,'ip'=>$ip,'time'=>date('Y-m-d H:i:s')));
    }

    /**
     * write_group_log 写入群组日志
     * @access public
     * @param $gid
     * @param $uid
     * @param $action
     */
    public function write_group_log($gid,$uid,$action){
        $ip = $_SERVER["REMOTE_ADDR"];
        $this->db->insert('group_log',array('g_id'=>$gid,'uid'=>$uid,'action'=>$action,'ip'=>$ip,'time'=>date('Y-m-d H:i:s')));
    }
}