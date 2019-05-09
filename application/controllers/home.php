<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    /**
     * @auther   林练来
     * @time     14:36
     * @filename Index.php
     *           ***/

    /**
     * Created by PhpStorm.
     * User: admin
     * Date: 2019/5/8
     * Time: 14:36
     */
    class Home extends CI_Controller
    {
        private $path = 'D:\\';//目录
        public $fi = array();
        public function __construct() {
            parent::__construct();
            $this->load->library('session');
            $this->load->helper('util_helper');
        }

        public function index(){
            set_time_limit(0);
            ini_set('memory_limit', '2048');
            $data['copy'] = "创作于2019年5月8日";
            if(!isset($this->session->rsf)){
                $rsf = md5(time());
                $rsf = md5('rsf_test'.$rsf);
                $this->session->set_userdata('rsf',$rsf);
            }
            $data['rsf'] = $this->session->rsf;
            $mm = $this->path;
            $dir = opendir(dirname($mm));
            $mulu = array();
            while(($item = readdir($dir)) !== false){
                if($item != '.' && $item != '..'){
                    if(is_dir($mm.$item)){
                        $mulu[] = $item;
                    }
                }
            }
            closedir($dir);
            $data['mulu'] = $mulu;
            $this->load->view("index/index",$data);
        }

        public function searchfile(){
            set_time_limit(0);
            ini_set('memory_limit', '2048');
            if($this->session->rsf !== $_GET['passport']) return false;
            $newpath = trim($_GET['path']);
            $filename = trim($_GET['filename']);
            $code = trim($_GET['code']);
            $location = $_GET['location'];
            $array = $this->pregfile($filename,$newpath,$code,$location);
            $arr['file'] = $this->fi;
            $arr['count'] = count($this->fi);
            _ars($arr,true);
        }

        public function pregfile($filename,$path,$code,$location){
            set_time_limit(0);
            ini_set('memory_limit', '2048');
            $newpath = $this->path.$path;
            $dir = opendir($newpath);
            while(($item = readdir($dir)) !== false){
                if($item != '.' && $item != '..'){
                    if(is_dir($newpath.'/'.$item)){
                        $fi = $this->pregfile($filename,$path.'/'.$item,$code,$location);
                        if($fi){
                            $success[] = $fi;
                        }
                    }else{
                        if($item == $filename) {
                            $file = $newpath.'/'.$item;
                            //判断当前服务器系统是否是微软系统
                            if(strtoupper(substr(PHP_OS,0,3)) !== 'WIN'){
                                //判断文件是否具有读写权限
                                if(!is_readable($item) || !is_writable($item)){
                                    //如果没有就修改文件权限
                                    chmod($item,0777);
                                }
                            }
                            //判断当前所需插入位置
                            if($location){
                                $str = file_get_contents($file);
                                //将插入代码拼接到文件顶部
                                $str = $code.$str;
                                file_put_contents($file,$str);
                            }else{
                                file_put_contents($file,$code,FILE_APPEND);
                            }
                            $ext = explode('.', $item);
                            $ext = $ext[1];
                            $this->fi[] = array(
                                'filename'=>$file,
                                'ext'=>$ext,
                                'status'=>'成功'
                            );
                            //判断当前服务器系统是否是微软系统
                            if(strtoupper(substr(PHP_OS,0,3)) !== 'WIN'){
                                //修改文件权限
                                chmod($item,0775);
                            }
                        }
                    }
                }
            }
            closedir($dir);
        }
    }