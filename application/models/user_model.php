<?php
/**
 * Created by PhpStorm.
 * Author: Liu  <470401911@qq.com>
 * Date: 2016/4/1
 * Time: 19:10
 */
class User_Model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->model('Base_Model','base');
    }

    

    /**
     * info 查看用户详细信息
     * @access public
     * @param $uid
     * @return mixed
     */
    public function info($uid){
        $data = $this->base->select('*','v_user_info','uid',$uid);
        $data['label'] = $this->base->select_array('label','user_label','uid',$uid);
        return $data;
    }

    /**
     * update  修改用户信息
     * @access public
     * @param $uid
     * @param $type
     * @param $value
     * @return mixed
     */
    public function update($uid,$type,$value){
        switch ($type){
            case 'name':
            case 'privacy':
                $table = 'user';
                break;
            default:
                $table = 'user_detail';
                break;
        }
        //先判断是否存在
        $uid = $this->base->select('uid',$table,'uid',$uid);
        if(!$uid){
            $this->db->insert($table,array('uid'=>$uid));
        }
        $bool = $this->db->update($table,array($type=>$value),array('uid'=>$uid));
        return $bool;
    }

    public function find_password($uid,$email){
        
    }
    
    public function get_password($uid){
        $data = $this->base->select('password','user','uid',$uid);
        return $data?$data['password']:null;
    }

    /**
     * change_password  修改密码
     * @access public
     * @param $uid
     * @param $new_password
     */
    public function change_password($uid,$new_password){
        $this->db->update('user',array('password'=>$new_password),array('uid'=>$uid));
        return $this->db->affected_rows();
    }

    /**
     * add_message  添加用户信息
     * @access public
     * @param $uid
     * @param $message
     * @return mixed
     */
    public function add_message($uid,$message){
        $time = date('Y-m-d H:i:s');
        $this->db->insert('user_message',array('uid'=>$uid,'message'=>$message,'time'=>$time));
        return $this->db->affected_rows();
    }

    /**
     * get_notice_list  获取未读信息
     * @access public
     * @param $uid
     * @return mixed
     */
    public function get_notice_list($uid){
        $res = $this->db->select('*')->from('user_message')->where(array('uid'=>$uid,'status'=>1))->order_by('id desc')->get();
        $data = $res->result_array();
//        $data = $this->base->select_array_needs('*','user_message',array('uid'=>$uid,'status'=>1));
        return $data;
    }

    /**
     * get_notice_all 获取全部消息
     * @access public
     * @return mixed
     */
    public function get_notice_all(){
        $res = $this->db->select('*')->from('user_message')->where('uid',$uid)->order_by('id desc')->get();
        $data = $res->result_array();
        return $data;
    }

}
