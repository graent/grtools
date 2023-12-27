<?php
/**
 * Filename:Grtools.php
 * Date:2023/12/28 0028
 * Company:OUNUO欧诺网络
 * Site:www.ounuo.cc
 * Atuhor:Graent.Hu
 * Email:1466409@qq.com
 */

namespace Graent\Grtools;

class Grtools{
    public function __construct()
    {

    }

    /**
     * 时间友好显示
     * @param $sTime
     * @param string $type
     * @return false|string
     */
    public static function dateFormat($sTime,$type = 'ymd'){
        //sTime=源时间，cTime=当前时间，dTime=时间差
        if($sTime == 0){
            return '-';
        }
        $sTime = intval($sTime);
        $cTime          =    time();
        $dTime          =    $cTime - $sTime;
        $dDay           =    intval(date("z",$cTime)) - intval(date("z",$sTime));
        $dYear          =    intval(date("Y",$cTime)) - intval(date("Y",$sTime));
        //normal：n秒前，n分钟前，n小时前，日期
        if($type=='normal'){
            if( $dTime < 60 ){
                return intval($dTime)."秒前";
            }elseif( $dTime < 3600 ){
                return intval($dTime/60)."分钟前";
                //今天的数据.年份相同.日期相同.
            }elseif( $dYear==0 && $dDay == 0  ){
                //return intval($dTime/3600)."小时前";
                return '今天'.date('H:i',$sTime);
            }elseif($dYear==0){
                return date("m月d日 H:i",$sTime);
            }else{
                return date("Y-m-d H:i",$sTime);
            }
        }elseif($type=='mohu'){
            if( $dTime < 60 ){
                return intval($dTime)."秒前";
            }elseif( $dTime < 3600 ){
                return intval($dTime/60)."分钟前";
            }elseif( $dTime >= 3600 && $dDay == 0  ){
                return intval($dTime/3600)."小时前";
            }elseif( $dDay > 0 && $dDay<=7 ){
                return intval($dDay)."天前";
            }elseif( $dDay > 7 &&  $dDay <= 30 ){
                return intval($dDay/7) . '周前';
            }elseif( $dDay > 30 ){
                return intval($dDay/30) . '个月前';
            }
            //full: Y-m-d , H:i:s
        }elseif($type=='full'){
            return date("Y-m-d  H:i:s",$sTime);
        }elseif($type=='ymd'){
            return date("Y-m-d",$sTime);
        }elseif($type=='md'){
            return date("m-d",$sTime);
        }else{
            if( $dTime < 60 ){
                return intval($dTime)."秒前";
            }elseif( $dTime < 3600 ){
                return intval($dTime/60)."分钟前";
            }elseif( $dTime >= 3600 && $dDay == 0  ){
                return intval($dTime/3600)."小时前";
            }elseif($dYear==0){
                return date("Y-m-d H:i:s",$sTime);
            }else{
                return date("Y-m-d H:i:s",$sTime);
            }
        }
    }

    /**
     * 随机字符串
     * @param int $len
     * @param int $type
     * @param string $addChars
     * @return false|string
     */
    public static function randStr($len = 6, $type = 4, $addChars = '') {
        switch ($type) {
            case 0 : //大小写字母
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1 : //纯数字
                $chars = '0123456789';
                break;
            case 2 : //大写字母
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3 : //小写字母
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4 : //默认字符串
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789' . $addChars;
                break;
            case 5 : //默认字符串
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = "!@#$%^&*()_+-=|<>,.?/~`;:{}[]" . $addChars;
                break;
            case 6:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=|<>,.?/~`;:{}[]' . $addChars;
                break;
            case 7:
                $chars = '123456789' . $addChars;
                break;
        }
        if ($len > 10) { //位数过长重复字符串一定次数
            $chars = ($type == 1 || $type == 5) ? str_repeat ( $chars, $len ) : str_repeat ( $chars, 5 );
        }

        $chars = str_shuffle ( $chars );
        $str = substr ( $chars, 0, $len );

        return $str;
    }

    /**
     * 手机号码验证
     * @param $mobile
     * @return false|int
     */
    public static function checkMobile($mobile) {
        return preg_match('/^1[3|4|5|6|7|8|9]\d{9}$/', $mobile);
    }

    /**
     * 邮箱验证
     * @param $test
     * @return mixed
     */
    public static function checkEmail($test){
        $zhengze = '/^[a-zA-Z0-9][a-zA-Z0-9._-]*\@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/A';
        preg_match($zhengze,$test,$result);
        return $result;
    }

    /**
     * 密码生成，含salt
     * @param string $pwd
     * @param string $salt
     * @param int $salt_len
     * @return array
     */
    public static function gPass($pwd = '',$salt = '', $salt_len = 8){
        $salt = $salt == '' ? self::randStr($salt_len) : $salt;
        return ['pwd' => md5(md5($salt).md5($pwd)),'salt' => $salt];
    }

    /**
     * 密码检查，含salt
     * @param string $pwd
     * @param string $salt
     * @param string $handle
     * @return bool
     */
    public static function gPassCk($pwd = '',$salt = '',$handle = ''){
        return $handle == md5(md5($salt).md5($pwd));
    }

    /**
     * 字符串加星
     * @param string $str
     * @param int $l
     * @param int $r
     * @param int $chr_len
     * @param string $chr
     * @return false|string
     */
    public static function gStar($str = '',$l = 3,$r = 3,$chr_len = 6,$chr = '*'){
        if(empty($str)){
            return false;
        }
        $len_min = $l + $r;
        if(mb_strlen($str,'utf-8') <= $len_min){
            return str_repeat($chr,$chr_len);
        }
        $new_str = mb_substr($str,0,$l,'utf-8') . str_repeat($chr,$chr_len) . mb_substr($str,mb_strlen($str,'utf-8') - $r,$r);
        return $new_str;
    }

    /**
     * 科学四则运算
     * @param $m
     * @param $n
     * @param $x
     * @param int $scale
     * @return false|string|null
     */
    public static function gCalc($m,$n,$x,$scale = 2){
        switch($x){
            case 'add':
                $t = bcadd($m,$n,$scale);
                break;
            case 'sub':
                $t = bcsub($m,$n,$scale);
                break;
            case 'mul':
                $t = bcmul($m,$n,$scale);
                break;
            case 'div':
                if($n!=0){
                    $t = bcdiv($m,$n,$scale);
                }else{
                    return false;
                }
                break;
            case 'pow':
                $t = bcpow($m,$n,$scale);
                break;
            case 'mod':
                if($n!=0){
                    $t = bcmod($m,$n);
                }else{
                    return false;
                }
                break;
            case 'sqrt':
                if($m>=0){
                    $t = bcsqrt($m,$scale);
                }else{
                    return false;
                }
                break;
        }
        return $t;
    }

    /**
     * uuid
     * @param string $hyphen
     * @return false|string
     */
    public static function gUuid($hyphen = '-'){
        if (function_exists('com_create_guid')){
            $uuid = com_create_guid();
            $uuid = substr($uuid, 1,  strlen($uuid)-2);
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charId = strtolower(md5(uniqid(rand(), true)));
//            $hyphen = "-";
            $uuid =  substr($charId, 0, 8).$hyphen
                .substr($charId, 8, 4).$hyphen
                .substr($charId,12, 4).$hyphen
                .substr($charId,16, 4).$hyphen
                .substr($charId,20,12);
        }
        return $uuid;
    }

    /**
     * 解决半子截取
     * @param $str
     * @param $len
     * @param string $last
     * @return string
     */
    public static function utf_substr($str,$len,$last = '..'){
        $old = $str = str_replace('&nbsp;', '', trim(strip_tags($str)));
        for($i=0;$i<$len;$i++){
            $temp_str=substr($str,0,1);
            if(ord($temp_str) > 127){
                $i++;
                if($i<$len){
                    $new_str[]=substr($str,0,3);
                    $str=substr($str,3);
                }
            }else{
                $new_str[]=substr($str,0,1);
                $str=substr($str,1);
            }
        }

        $newStr = join($new_str);
        if($newStr == $old){
            return $newStr;
        }  else {
            return $newStr.$last;
        }
    }

    /**
     * 图片转base64
     * @param $img_file
     * @return string
     */
    public static function imgToBase64($img_file){
        $img_base64 = '';
        if (file_exists($img_file)) {
            $app_img_file = $img_file; // 图片路径
            $img_info = getimagesize($app_img_file); // 取得图片的大小，类型等

            //echo '<pre>' . print_r($img_info, true) . '</pre><br>';
            $fp = fopen($app_img_file, "r"); // 图片是否可读权限

            if ($fp) {
                $fileSize = filesize($app_img_file);
                $content = fread($fp, $fileSize);
                $file_content = chunk_split(base64_encode($content)); // base64编码
                switch ($img_info[2]) {           //判读图片类型
                    case 1: $img_type = "gif";
                        break;
                    case 2: $img_type = "jpg";
                        break;
                    case 3: $img_type = "png";
                        break;
                }

                $img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content;//合成图片的base64编码
            }
            fclose($fp);
        }
        return $img_base64; //返回图片的base64
    }

    /**
     * 单号生成
     * @param string $prefix
     * @param int $randLen
     * @return string
     */
    public static function gSN($prefix = '',$randLen = 0){
        return $prefix.date('ymdHis').substr(microtime(),2,3).self::randStr($randLen,1);
    }

    /**
     * 文件大小格式化
     * @param int $num
     * @return string
     */
    public static function fmtSize($num = 0){
        $p = 0;
        $format='bytes';
        if($num>0 && $num<1024){
            $p = 0;
            return number_format($num).' '.$format;
        }
        if($num>=1024 && $num<pow(1024, 2)){
            $p = 1;
            $format = 'KB';
        }
        if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
            $p = 2;
            $format = 'MB';
        }
        if ($num>=pow(1024, 3) && $num<pow(1024, 4)) {
            $p = 3;
            $format = 'GB';
        }
        if ($num>=pow(1024, 4) && $num<pow(1024, 5)) {
            $p = 3;
            $format = 'TB';
        }
        $num /= pow(1024, $p);
        return number_format($num, 1).' '.$format;

    }

    /**
     * 求两个日期之间相差的天数
     * (针对1970年1月1日之后，求之前可以采用泰勒公式)
     * @param string $date1
     * @param string $date2
     * @return number
     */
    public static function diff_date($date1, $date2){
        if ($date1 > $date2) {
            $startTime = strtotime($date1);
            $endTime = strtotime($date2);
        } else {
            $startTime = strtotime($date2);
            $endTime = strtotime($date1);
        }
        $diff = $startTime - $endTime;
        $day = $diff / 86400;
        return ceil($day);
    }

    /**
     * 获取两经纬度直接的距离
     * @param float $lng1
     * @param float $lat1
     * @param float $lng2
     * @param float $lat2
     * @return float|int
     */
    public static function gDistance(float $lng1, float $lat1, float $lng2, float $lat2){
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;

        return $s;
    }

}