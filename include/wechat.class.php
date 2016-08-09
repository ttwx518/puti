<?php

if (!defined('IN_PHPMYWIND'))
    exit('Request Error!');

class wechat {

    const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
    const QRCODE_CREATE_URL='/qrcode/create?';
    const AUTH_URL = '/token?grant_type=client_credential&';
    const QRCODE_IMG_URL='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
    
    private $token;
    private $appid;
    private $appsecret;
    private $access_token;
    public $debug = false;

    public function __construct($options) {
        $this->token = isset($options['token']) ? $options['token'] : '';
        $this->appid = isset($options['appid']) ? $options['appid'] : '';
        $this->appsecret = isset($options['appsecret']) ? $options['appsecret'] : '';
        $this->debug = isset($options['debug']) ? $options['debug'] : false;
    }

    /**
     * 用于接入验证
     * @return boolean
     */
    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $tmpArr = array($this->token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 回复消息
     */
    public function responseMsg() {
        global $dosql;
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $MsgType = $postObj->MsgType;
            $key = $keyword = $Event = '';
            $time = time();

            switch ($MsgType) {
                case 'text':
                    $key = $keyword = trim($postObj->Content);
                    break;
                case 'image':
                    $keyword = "<a href='{$postObj->PicUrl}' target='_blank'><img src='{$postObj->PicUrl}' /></a>";
                    break;
                case 'voice':
                    $keyword = $postObj->MediaId;
                    break;
                case 'video':
                    $keyword = $postObj->MediaId;
                    break;
                case 'location':
                    $arr = array();
                    $arr['Location_X'] = $postObj->Location_X;
                    $arr['Location_Y'] = $postObj->Location_Y;
                    $arr['Scale'] = $postObj->Scale;
                    $arr['Label'] = $postObj->Label;
                    $keyword = json_encode($arr);
                    break;
                case 'link':
                    $arr = array();
                    $arr['Title'] = $postObj->Title;
                    $arr['Description'] = $postObj->Description;
                    $arr['Url'] = $postObj->Url;
                    $keyword = json_encode($arr);
                    break;
                case 'event':
                    $Event = $postObj->Event;
                    break;
            }

            //关注
            if ($MsgType == 'event' && $Event == 'subscribe') {
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";

                $wechat_userinfo = $this->_userinfo($fromUsername);
                
                // 写入数据库
                $user_sql = "SELECT * FROM `#@__member` WHERE openid='{$fromUsername}'";
                $ret = $dosql->GetOne($user_sql);
                
                
                $privilege = '';//unserialize($wechat_userinfo['privilege']);
                $expires_in = '';//$time + $wechat_userinfo['expires_in'];
                $unionid = '';//$wechat_userinfo['unionid']
                $regtime = $logintime = time();
                $regip = $logip = GetIP();
                Writef(PHPMYWIND_ROOT . '/auth.log', $wechat_userinfo['nickname']);
                $wechat_userinfo['nickname'] = htmlspecialchars($wechat_userinfo['nickname']);
                $wechat_userinfo['nickname'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $wechat_userinfo['nickname']);
                $wechat_userinfo['nickname'] = replace_specialChar($wechat_userinfo['nickname']);
                $wechat_userinfo['city'] = str_replace("'", "\'", $wechat_userinfo['city']);
                Writef(PHPMYWIND_ROOT . '/auth.log', $wechat_userinfo['nickname']);
                
                if (!empty($ret)) {
                    $sql = "UPDATE `#@__member` SET
                    logintime='{$logintime}',
                    loginip='{$logip}',
                    wechat_nickname='{$wechat_userinfo['nickname']}',
                    wechat_sex='{$wechat_userinfo['sex']}',
                    wechat_province='{$wechat_userinfo['province']}',
                    wechat_city='{$wechat_userinfo['city']}',
                    wechat_country='{$wechat_userinfo['country']}',
                    wechat_headimgurl='{$wechat_userinfo['headimgurl']}',
                    wechat_privilege='{$privilege}',
                    wechat_unionid='{$unionid}',
                    wechat_expires_in='{$expires_in}'
                    WHERE openid='{$fromUsername}'";
                } else {
                    $recUid = 0;
                    $recUid2 = 0;
                    $EventKey = $postObj->EventKey;
                    $key_arr = explode('_',$EventKey, 2);
                    $count = count($key_arr);
                    if ($count == 2) {
                        // 扫描推荐二维码的情况
                        $sceneid = $key_arr[1];
                        $pmember = $dosql->GetOne("SELECT * FROM `#@__member` WHERE `openid`='{$sceneid}'");
                        $popenid = '';
                        if(isset($pmember) && is_array($pmember)){
                            $recUid = $pmember['id'];
                            $recUid2 = $pmember['recUid'];
                        }
                    }
                    
                    $sql = "INSERT INTO `#@__member`
                    (group_id,recUid,recUid2,regtime,regip,logintime,loginip,openid,wechat_nickname,wechat_sex,wechat_province,wechat_city,
                    wechat_country,wechat_headimgurl,wechat_privilege,wechat_unionid,wechat_expires_in)
                        VALUES
                        (1,$recUid,$recUid2,$regtime,'$regip',$logintime,'$logip','{$fromUsername}','{$wechat_userinfo['nickname']}','{$wechat_userinfo['sex']}',
                            '{$wechat_userinfo['province']}','{$wechat_userinfo['city']}','{$wechat_userinfo['country']}',
                    '{$wechat_userinfo['headimgurl']}','{$privilege}','{$unionid}','{$expires_in}')";
                }
                
                $dosql->ExecNoneQuery($sql);
                $msgType = "text";
                $contentStr = "感谢关注“奕生缘 种子梦”平台，关注健康、亲近自然、保护地球、构建人与自然的和谐，让我们共同传递种子的力量，实现“一粒种子  一片森林”的梦想。";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } elseif ($MsgType == 'event' && $Event == 'CLICK') {
                if ((int) $postObj->EventKey > 0) {
                    $EventKey = (int) $postObj->EventKey;
                }
            }

            if (!empty($keyword)) {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }
        } else {
            echo "";
            exit;
        }
    }

    /**
     * 接入验证
     */
    public function valid() {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    /**
     * 获取本次请求中的参数，不区分大小
     * @param  string $param 参数名，默认为无参
     * @return mixed
     */
    public function getRequest($param = FALSE) {
        if ($param === FALSE) {
            return $this->request;
        }
        $param = strtolower($param);
        if (isset($this->request[$param])) {
            return $this->request[$param];
        }
        return NULL;
    }

    /**
     * 获取用户信息
     * @return string
     */
    public function _userinfo($openid) {
        $this->access_token = $this->_access_token();
        $access = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->access_token . "&openid=" . $openid . "&lang=zh_CN");
        $result = json_decode($access, true);
        return $result;
    }

    /**
     * 创建分组
     * @return string
     */
    public function _creat_user_group($name) {
        
    }

    /**
     * 获取所有分组
     * @return string
     */
    public function _get_group_list() {
        $this->access_token = $this->_access_token();
        $access = file_get_contents("https://api.weixin.qq.com/cgi-bin/groups/get?access_token=" . $this->access_token);
        $result = json_decode($access, true);
        return $result;
    }

    /**
     * 查询用户所在分组
     * @param   string  $openid
     * @return  string
     */
    public function _get_group_byid($openid) {
        $this->access_token = $this->_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/groups/getid?access_token=" . $this->access_token;
        $post_data = json_encode(array("openid" => $openid));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_encode($output, true);
        return $output;
    }

    /**
     * 移动用户到指定分组
     * @param string $openid
     * @param int $groupid 活动分组
     * @return boolean
     */
    public function _update_user_group($openid, $groupid) {
        $url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=" . $this->access_token;
        $post_data = json_encode(array("openid" => $openid, 'to_groupid' => $groupid));
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post_data))
        );
        $output = curl_exec($ch);
        $result = json_decode($output, true);
        curl_close($ch);
        if ($result['errmsg'] == "ok") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取access_token
     * @return string
     */
    public function _access_token() {
        $access = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appid . "&secret=" . $this->appsecret);
        $result = json_decode($access, true);
        if ($result['access_token']) {
            return $result['access_token'];
        } else {
            return NULL;
        }
    }

    /**
     * 获取网页授权url
     * @return string $oauth_url
     */
    public function get_oauth_url() {
        $scope = "snsapi_userinfo"; //snsapi_base || snsapi_userinfo
        $redirect_uri = "http://new.weixin66.net/puti/auth.php";
        $oauth_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->appid . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=" . $scope . "&state=1#wechat_redirect";
        return $oauth_url;
    }

    /**
     * 通过code换取网页授权access_token
     * @param string $code
     * @return array $result
     */
    public function get_oauth_access_token($code) {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->appid . "&secret=" . $this->appsecret . "&code=" . $code . "&grant_type=authorization_code";
        $access = $this->vita_get_url_content($url);
        $result = json_decode($access, true);
        return $result;
    }

    /**
     * 网页授权刷新access_token
     * @param string $refresh_token 通过网页授权获取到的refresh_token
     * @return array $result
     */
    public function refresh_access_token($refresh_token) {
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=" . $this->appid . "&grant_type=refresh_token&refresh_token=" . $refresh_token;
        $access = $this->vita_get_url_content($url);
        $result = json_decode($access, true);
        return $result;
    }

    /**
     * 网页授权拉取用户信息
     * @param string $token 网页授权access_token
     * @param string $openid 微信用户openid
     * @return array $result
     */
    public function get_userinfo($token, $openid) {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $token . "&openid=" . $openid . "&lang=zh_CN";
        $access = $this->vita_get_url_content($url);
        $result = json_decode($access, true);
        return $result;
    }

    /**
     * 发送客服消息
     * @param array $data 消息结构{"touser":"OPENID","msgtype":"news","news":{...}}
     * @return boolean|array
     */
    public function sendCustomMessage($data) {
        $this->access_token = $this->_access_token();
        $result = $this->http_post('https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 微信api不支持中文转义的json结构
     * @param array $arr
     */
    static function json_encode($arr) {
        $parts = array();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr) - 1;
        if (($keys [0] === 0) && ($keys [$max_length] === $max_length )) { //See if the first key is 0 and last key is length - 1
            $is_list = true;
            for ($i = 0; $i < count($keys); $i ++) { //See if each key correspondes to its position
                if ($i != $keys [$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) { //Custom handling for arrays
                if ($is_list)
                    $parts [] = self::json_encode($value); /* :RECURSION: */
                else
                    $parts [] = '"' . $key . '":' . self::json_encode($value); /* :RECURSION: */
            } else {
                $str = '';
                if (!$is_list)
                    $str = '"' . $key . '":';
                //Custom handling for multiple data types
                if (is_numeric($value) && $value < 2000000000)
                    $str .= $value; //Numbers
                elseif ($value === false)
                    $str .= 'false'; //The booleans
                elseif ($value === true)
                    $str .= 'true';
                else
                    $str .= '"' . addslashes($value) . '"'; //All other things
                    
                    // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
                $parts [] = $str;
            }
        }
        $json = implode(',', $parts);
        if ($is_list)
            return '[' . $json . ']'; //Return numerical JSON
        return '{' . $json . '}'; //Return associative JSON
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    private function http_post($url, $param, $post_file = false) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    private function vita_get_url_content($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $file_contents = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $file_contents;
    }

    /**
     * 创建二维码ticket
     * @param int|string $scene_id 自定义追踪id,临时二维码只能用数值型
     * @param int $type 0:临时二维码；1:永久二维码(此时expire参数无效)；2:永久二维码(此时expire参数无效)
     * @param int $expire 临时二维码有效期，最大为1800秒
     * @return array('ticket'=>'qrcode字串','expire_seconds'=>1800,'url'=>'二维码图片解析后的地址')
     */
    public function getQRCode($scene_id,$type=0,$expire=1800){
        if (!$this->access_token && !$this->checkAuth()) return false;
        $type = ($type && is_string($scene_id))?2:$type;
    
        $data = array(
            'action_name'=>$type?($type == 2?"QR_LIMIT_STR_SCENE":"QR_LIMIT_SCENE"):"QR_SCENE",
            'expire_seconds'=>$expire,
            'action_info'=>array('scene'=>($type == 2?array('scene_str'=>$scene_id):array('scene_id'=>$scene_id)))
        );
        if ($type == 1) {
            unset($data['expire_seconds']);
        }
        $result = $this->http_post(self::API_URL_PREFIX.self::QRCODE_CREATE_URL.'access_token='.$this->access_token,self::json_encode($data));
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }
    
    /**
     * 获取access_token
     * @param string $appid 如在类初始化时已提供，则可为空
     * @param string $appsecret 如在类初始化时已提供，则可为空
     * @param string $token 手动指定access_token，非必要情况不建议用
     */
    public function checkAuth($appid='',$appsecret='',$token=''){
        if (!$appid || !$appsecret) {
            $appid = $this->appid;
            $appsecret = $this->appsecret;
        }
        if ($token) { //手动指定token，优先使用
            $this->access_token=$token;
            return $this->access_token;
        }
    
        $authname = 'wechat_access_token'.$appid;
        if ($rs = $this->getCache($authname))  {
            $this->access_token = $rs;
            return $rs;
        }
    
        $result = $this->http_get(self::API_URL_PREFIX.self::AUTH_URL.'appid='.$appid.'&secret='.$appsecret);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->access_token = $json['access_token'];
            $expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
            $this->setCache($authname,$this->access_token,$expire);
            return $this->access_token;
        }
        return false;
    }
    
    /**
     * 获取缓存，按需重载
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename){
        //TODO: get cache implementation
        return false;
    }
    
    /**
     * 设置缓存，按需重载
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename,$value,$expired){
        //TODO: set cache implementation
        return false;
    }
    
    /**
     * GET 请求
     * @param string $url
     */
    private function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }
    
    /**
     * 获取二维码图片
     * @param string $ticket 传入由getQRCode方法生成的ticket参数
     * @return string url 返回http地址
     */
    public function getQRUrl($ticket) {
        return self::QRCODE_IMG_URL.urlencode($ticket);
    }
    
}
