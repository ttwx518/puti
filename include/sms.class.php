<?php

if (!defined('IN_PHPMYWIND'))
    exit('Request Error!');

$dosms = new sms('sandboxapp.cloopen.com', '8883', '2013-12-26');

class sms extends REST {

    private $identifyArr = array(
        'code' => '27428', //验证码模板
    );
    //主帐号
    private $accountSid = 'aaf98f894979d7be01497ea4bd2b03ad';//aaf98f894f2efdde014f39768379051c
    //主帐号Token
    private $accountToken = '367b3424e7c946c7ad7f63327e2da04e';//14f6df2fc041466a807db71ba0f76a4f
    //应用Id
    private $appId = '8a48b5514979e0910149800c0e3a04d5';//8a48b5514f2b46d0014f39837be411f6

    function __construct($ServerIP, $ServerPort, $SoftVersion) {
        $this->Init($ServerIP, $ServerPort, $SoftVersion);
    }

    function sms($ServerIP, $ServerPort, $SoftVersion) {
        $this->__construct($ServerIP, $ServerPort, $SoftVersion);
    }

    /**
     * 初始化类
     * @param string $ServerIP 请求地址，格式如下，不需要写https://
     * @param string $ServerPort 请求端口 
     * @param string $SoftVersion REST版本号
     */
    function Init($ServerIP, $ServerPort, $SoftVersion) {
        parent::__construct($ServerIP, $ServerPort, $SoftVersion);
        $this->setAccount($this->accountSid, $this->accountToken);
        $this->setAppId($this->appId);
    }

    /**
     * 发送模板短信
     * @param string $identify 调用标识
     * @param string $mobile 手机号码
     * @param array $datas 内容数据
     * @return array
     */
    public function mSendSms($identify, $mobile, $datas) {
        global $dosql;
        if ($identify == 'reg') {
            $tempId = $this->identifyArr['code'];
        }
        // 发送模板短信
        $result = $this->sendTemplateSMS($mobile, $datas, $tempId);
        if ($result == NULL) {
            return false;
        }
        if ($result->statusCode != 0) {
            return false;
        } else {
            $sendtime = time();
            $validtime = $sendtime + 600;
            $content = serialize($datas);
            $dosql->ExecNoneQuery("INSERT INTO `#@__sms_record` (type,mobile,code,content,sendtime,validtime) VALUES 
                                  ('{$identify}','{$mobile}','{$datas[0]}','{$content}','{$sendtime}','{$validtime}')");
            return true;
        }
    }

}
