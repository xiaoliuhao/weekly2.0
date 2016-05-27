<?php
/**
 * Create by PhpStorm
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/29
 * Time: 13:34
 * Version: weekly
 */
class Login_Model extends CI_Model{
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
        $user['last_time'] = $user['register_time'];

        $this->db->insert('user',$user);
        return $this->db->affected_rows();
    }

    /**
     * check_user 检查用户是否注册过
     * @access public
     * @param $uid
     * @return mixed
     */
    public function check_user($uid){
        $data = $this->base->select('*','user','uid',$uid);
        return $data;
    }

    /**
     * check_login  检查登陆 ， 成功后返回token
     * @access public
     * @param $uid
     * @param $password
     * @return int|string
     */
    public function check_login($uid,$password){
        $data = $this->base->select('*','user','uid',$uid);
        if( (!$data) || ($data['password'] != $password)){
            //用户不存在 或者 密码错误 返回2
            return 2;
        }else{
            $data['token'] = sha1(md5($uid.$password.time()));
            //向数据库中更新token
            $data['last_time']  = date('Y-m-d H:i:s');
            $data['last_ip']    = $_SERVER['REMOTE_ADDR'];
            $this->db->update('user_login',$data,array('uid'=>$uid));
            $user_info = array('token'=>$data['token'],'uid'=>$uid,'name'=>$data['name'],'photo'=>$data['photo']);
            return $user_info;
        }
    }

    /**
     * get_photo    获取用户头像
     * @access public
     * @param $uid
     * @return mixed
     */
    public function get_photo($uid){
        $data = $this->base->select('*','user','uid',$uid);
        return $data?$data['photo']:null;
    }

    /**
     * is_login 判断用户是否登录 获取用户名信息
     * @access public
     * @return mixed
     */
    public function is_login(){
        $token = $this->input->post('token');
        $data  = $this->select('uid','user','token',$token);
        return $data['uid'];
    }

}