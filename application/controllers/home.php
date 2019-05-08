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
    class home extends CI_Controller
    {
        private $path = './';
        public function __construct() {
            parent::__construct();
        }

        public function index(){
            $data['copy'] = "创作于2019年5月8日";
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

        public function search(){
            $data = $_POST['path'];
            var_dump($data);
        }
    }