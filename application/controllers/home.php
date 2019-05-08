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
        private $path = './';
        public function __construct() {
            parent::__construct();
            $this->load->library('session');
        }

        public function index(){
            $data['copy'] = "创作于2019年5月8日";
            if(!isset($this->session->rsf)){
                $rsf = md5(time());
                $rsf = md5('rsf_test'.$rsf);
                $this->session->set_userdata('rsf',$rsf);
            }
            $data['rsf'] = $this->session->rsf;
            $dir = opendir($this->path);
            while(($item = readdir($dir)) !== false){
                if($item != '.' && $item != '..'){
                    if(is_dir($item)){
                        $mulu[] = $item;
                    }
                }
            }
            closedir($dir);
            $data['mulu'] = $mulu;
            $this->load->view("index/index",$data);
        }

        public function searchfile(){
            if($this->session->rsf !== $_GET['passport']) return false;
            $data = $_GET['path'];

            var_dump($data);
        }
    }