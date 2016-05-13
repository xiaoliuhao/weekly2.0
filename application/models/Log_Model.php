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
        $this->load->model('Base_Model','base');
    }

    /**
     * register 注册
     * @access public
     * @param $user
     */
    public function register($user){
        $user['last_ip'] = $_SERVER["REMOTE_ADDR"];
        $user['register_time'] = date('Y-m-d H:i:s');
        $user['last_time'] = $user['register_time']

        $this->db->insert('user',$user);
    }
    
    public function check_login($uid,$password){
        $data = $this->base->select('*','user_login','uid',$uid);
        if($data['password'] != $password){
            //密码错误 返回2
            return 2;
        }else{
            $token = sha1(uniqid($uid.$password));
        }
    }

    /**
     * login    用户登录成功。更新数据库信息
     * @access public
     * @param $uid
     */
    public function login($uid){
        $time = date('Y-m-d H:i:s');
        $ip   = $_SERVER["REMOTE_ADDR"];
        $this->db->update('user',array('last_time'=>$time,'last_ip'=>$ip),array('uid'=>$uid));
    }
}