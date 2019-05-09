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
        header('Content-Type: application/json; charset=utf-8');        // 返回数据为json
        $str	= json_encode($data);
        echo $str;
    }
    if (!function_exists("checkHex")) {
        /**
         * 检测是否包含图片木马
         *
         * @param string $image
         * @return bool
         */
        function checkHex($image = '')
        {
            if (file_exists($image)) {
                $resource = fopen($image, 'rb');
                $fileSize = filesize($image);
                fseek($resource, 0);
                if ($fileSize > 512) { // 取头和尾
                    $hexCode = bin2hex(fread($resource, 512));
                    fseek($resource, $fileSize - 512);
                    $hexCode .= bin2hex(fread($resource, 512));
                } else { // 取全部
                    $hexCode = bin2hex(fread($resource, $fileSize));
                }
                fclose($resource);
                /* 匹配16进制中的 <% ( ) %> */
                /* 匹配16进制中的 <? ( ) ?> */
                /* 匹配16进制中的 <script | /script> 大小写亦可*/
                if (preg_match("/(3c25.*?28.*?29.*?253e)|(3c3f.*?28.*?29.*?3f3e)|(3C534352495054)|(2F5343524950543E)|(3C736372697074)|(2F7363726970743E)/is", $hexCode)) {
                    error_log("ERROR_UPLOAD:$image \n", 3, "/tmp/ERR_UPLoad.log");

                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

    }
    if ( ! function_exists('curl_get_contents'))
    {
        function curl_get_contents($url, $return = true, $timeout = 2,$post = false)
        {
            $curlHandle = curl_init();
            curl_setopt( $curlHandle, CURLOPT_URL, $url );
            curl_setopt( $curlHandle, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $curlHandle, CURLOPT_TIMEOUT, $timeout );
            if ($post) {
                curl_setopt($curlHandle, CURLOPT_POST, 1);
            }
            $result = curl_exec( $curlHandle );
            curl_close( $curlHandle );
            return $return === true ? $result : '';
        }
    }
