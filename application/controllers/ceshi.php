<?php
    /**
     * @auther   林练来
     * @time     10:35
     * @filename ceshi.php
     *           ***/

    /**
     * Created by PhpStorm.
     * User: admin
     * Date: 2019/5/9
     * Time: 10:35
     */
    class Ceshi extends CI_Controller
    {
        public $fa = array();
        public $child = array();
        public function __construct() {
            parent::__construct();
            $this->load->helper('util_helper');
        }

        public function index()
        {
            $arr = array(
                array(
                    'id'=>1,
                    'label'=>'菜单',
                    'value'=>'menu',
                    'pid'=>0
                ),
                array(
                    'id'=>2,
                    'label'=>'肉',
                    'value'=>'meat',
                    'pid'=>1
                ),
                array(
                    'id'=>3,
                    'label'=>'水果',
                    'value'=>'fruit',
                    'pid'=>1
                ),array(
                    'id'=>4,
                    'label'=>'猪肉',
                    'value'=>'pig',
                    'pid'=>2
                ),array(
                    'id'=>5,
                    'label'=>'羊肉',
                    'value'=>'sheep',
                    'pid'=>2
                ),array(
                    'id'=>6,
                    'label'=>'无籽西瓜',
                    'value'=>'watermelon',
                    'pid'=>3
                ),array(
                    'id'=>7,
                    'label'=>'油',
                    'value'=>'oil',
                    'pid'=>0
                ),array(
                    'id'=>8,
                    'label'=>'菜油',
                    'value'=>'rapeoil',
                    'pid'=>7
                ),
            );
            $array = $this->arr_sort(0,$arr);
            $json = json_encode($array);
            var_dump($json);die;
            _ars($array,true);
//            var_dump($array);die;
        }

        public function arr_sort($pid=0,$arr)
        {
            $fa = array();
            foreach ($arr as $k=>$v){
                if($v['pid'] == $pid){
                    unset($arr[$k]);
                    if($this->arr_sort($v['id'],$arr)){
                        $fa[] = array(
                            'value'=>$v['value'],
                            'label'=>$v['label'],
                            'children'=>$this->arr_sort($v['id'],$arr)
                            );
                    }else{
                        $fa[] = array(
                            'value'=>$v['value'],
                            'label'=>$v['label'],
                        );
                    }
                }
            }
            return $fa;
        }
    }