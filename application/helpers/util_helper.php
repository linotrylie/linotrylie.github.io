<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * 带状态的json数据
     * @see json2List
     * @param mixed $data 返回数据
     * @param mixed $flag true 成功；false 失败
     * @param $is_die bool 终止信号
     * @param $error_code int 返回的错误码
     * @param $ex array
     * @param $msg string 返回给客户端的数据
     */
    function _ars($data, $flag = true, $is_die = true, $error_code = 0, $ex = array(), $msg = '')
    {
        if (!$data) $data	= array();
        if($flag === true)
        {
            $output	= array('state'=>'success', 'result'=>$data);
        }
        else
        {
            $output	= array('state'=>'fail', 'result'=>$data);
            if (is_numeric($error_code) && $error_code > 0)
            {
                $output['code']	= (int)$error_code;
            }
        }
        if (is_array($ex) && !empty($ex))
        {
            $output['ex']	= $ex;
        }
        if ($msg) {
            $output['message'] = $msg;
        }
        json2List($output);
        if ($is_die === true)
        {
            die();
        }
        else
        {
            fastcgi_finish_request();
        }
    }

    /**
     * 针对需要及时反馈的ajax请求，返回json数据
     *
     * @param mixed $data
     */
    function json2List($data, $nocache = false)
    {
        if (!$nocache)
        {
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
            header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
            header("Cache-Control: no-cache, must-revalidate" );
            header("Pragma: no-cache" );
        }
        //header("Content-type: text/html; charset=utf-8");
        header('Content-Type: application/json; charset=utf-8');        // 返回数据为json
        //header("Content-type: text/x-json");
        $str	= json_encode($data);
//        switch (ENVIRONMENT)
//        {
//            case 'development':
//            case 'testing'://
//                //$str	= preg_replace_callback('#[a-z0-9]+\.douguo\.(com|net)\\\\/([\d\w_\-\.\\\\/]+)#is', 'test_url_replace', $str);
//        }
        echo $str;
    }