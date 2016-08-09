<?php
/**
  * wechat php test
  * update time: 20141008
  */

require_once(dirname(__FILE__).'/../../include/config.inc.php');



//define your token
define("TOKEN", "chelianwang");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	/**
	 * 接入验证
	 */
	public function valid() {
	   $echoStr = $_GET["echostr"];
       echo $echoStr;
       exit;
	}

    public function responseMsg()
    {
        global $dosql;
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $MsgType = $postObj->MsgType;
                $Event = $postObj->Event;
                $time = time();
                // 关注动作， 1，发送欢迎消息 2，写入关联消息
				if($MsgType == 'event' && $Event == 'subscribe')
                {
                    // 处理关联消息
                    $EventKey = $postObj->EventKey;
                    if(isset($EventKey)){
                        $parentid = 0;
                        $key_arr = explode('_',$EventKey, 2);
                        $count = count($key_arr);
                        if ($count == 2) {
                            $sceneid = $key_arr[1];
                            $pmember = $dosql->GetOne("SELECT * FROM `#@__member` WHERE `openid`='{$sceneid}'");
                            $popenid = '';
                            if(isset($pmember) && is_array($pmember)){
                                $popenid = $pmember['openid'];
                            }
                            
                            $member = $dosql->GetOne("SELECT * FROM `#@__member` WHERE `openid`='{$fromUsername}'");
                            if(empty($member) && empty($member['popenid'])){
                                $regtime = $logintime = time();
                                $regip = $logip = GetIP();
                                $sql = "INSERT INTO `#@__member`
                                (group_id,username,regtime,regip,logintime,loginip,openid,cnname,sex,avatar, qrurl,ticket,popenid,ex_name,ex_fcode,ex_status,ex_A,ex_B,ex_C,ex_D)
                                VALUES
                                (1,'{$fromUsername}',$regtime,'$regip',$logintime,'$logip','{$fromUsername}','','', '', '','','$popenid','{$fromUsername}','{$pmember['id']}',3,'{$pmember['ex_A']}','{$pmember['ex_B']}','{$pmember['ex_C']}',5)";
                                $dosql->ExecNoneQuery($sql);
                                $member_after = $dosql->GetOne("SELECT * FROM `#@__member` WHERE `openid`='{$fromUsername}'");
                                $dosql->ExecNoneQuery("UPDATE `#@__member` SET `ex_code`='{$member_after['id']}',`ex_date`=".time()." WHERE `id`='{$member_after['id']}'");
                            }
                        }
                    }
                    
                    $textTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
    							<FromUserName><![CDATA[%s]]></FromUserName>
    							<CreateTime>%s</CreateTime>
    							<MsgType><![CDATA[%s]]></MsgType>
    							<Content><![CDATA[%s]]></Content>
    							<FuncFlag>0</FuncFlag>
                                </xml>";
                    $msgType = "text";
                    $contentStr = "欢迎关注车联网！";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                
                    exit();
                }else{
                	echo "";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>