<?php

header("Content-Type:text/html;charset=utf-8");

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 12:57:19
  person: Feng
 * *************************
 */

define('PHPMYWIND_INC', preg_replace("/[\/\\\\]{1,}/", '/', dirname(__FILE__)));
define('PHPMYWIND_ROOT', preg_replace("/[\/\\\\]{1,}/", '/', substr(PHPMYWIND_INC, 0, -8)));
define('PHPMYWIND_DATA', PHPMYWIND_ROOT . '/data');
define('PHPMYWIND_TEMP', PHPMYWIND_ROOT . '/templates');
define('PHPMYWIND_UPLOAD', PHPMYWIND_ROOT . '/uploads');
define('PHPMYWIND_BACKUP', PHPMYWIND_DATA . '/backup');
define('IN_PHPMYWIND', TRUE);

define('TMPL_DIR', PHPMYWIND_TEMP . '/default/');
define('CONT_PATH', 'controllers/default/');
define('TMPL_PATH', 'templates/default/');
define('MOBILE_LIMIT', 10);

define('STATIC_PATH', 'html/');

//检查外部传递的值并转义
function _RunMagicQuotes(&$svar) {
    //PHP5.4已经将此函数移除
    if (@!get_magic_quotes_gpc()) {
        if (is_array($svar)) {
            foreach ($svar as $_k => $_v)
                $svar[$_k] = _RunMagicQuotes($_v);
        } else {
            if (strlen($svar) > 0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_SESSION|_COOKIE)#', $svar)) {
                exit('不允许请求的变量值!');
            }
            $svar = addslashes($svar);
        }
    }
    return $svar;
}

//直接应用变量名称替代
foreach (array('_GET', '_POST') as $_request) {
    foreach ($$_request as $_k => $_v) {
        if (strlen($_k) > 0 &&
                preg_match('#^(GLOBALS|_GET|_POST|_SESSION|_COOKIE)#', $_k)) {
            exit('不允许请求的变量名!');
        }
        ${$_k} = _RunMagicQuotes($_v);
    }
}

require_once(PHPMYWIND_INC . '/config.cache.php'); //全局配置文件
require_once(PHPMYWIND_INC . '/common.func.php');  //全局常用函数
require_once(PHPMYWIND_INC . '/public.func.php');  //公用常用函数
require_once(PHPMYWIND_INC . '/conn.inc.php');     //引入数据库类
require_once(PHPMYWIND_INC . '/cart.class.php'); //引入购物车类
require_once(PHPMYWIND_INC . '/order.class.php'); //引入订单类
// require_once(PHPMYWIND_INC . '/CCPRestSDK.php'); //引入短信类
// require_once(PHPMYWIND_INC . '/sms.class.php'); //引入短信类
//引入数据库类
if ($cfg_mysql_type == 'mysqli' && function_exists('mysqli_init'))
    require_once(PHPMYWIND_INC . '/mysqli.class.php');
else
    require_once(PHPMYWIND_INC . '/mysql.class.php');

//引入语言包
//Session保存路径
$sess_savepath = PHPMYWIND_DATA . '/sessions/';
if (is_writable($sess_savepath) && is_readable($sess_savepath))
    session_save_path($sess_savepath);

//上传文件保存路径
$cfg_image_dir = PHPMYWIND_UPLOAD . '/image';
$cfg_soft_dir = PHPMYWIND_UPLOAD . '/soft';
$cfg_media_dir = PHPMYWIND_UPLOAD . '/media';

//系统版本号
$cfg_vernum = '5.2 Beta';
$cfg_vertime = '201412281230';

//设置默认时区
if (PHP_VERSION > '5.1') {
    $time51 = $cfg_timezone * -1;
    @date_default_timezone_set('Etc/GMT' . $time51);
}

//判断是否开启错误提示
if ($cfg_diserror == 'Y')
    error_reporting(E_ALL);
else
    error_reporting(0);

//获取登录用户信息
$userInfo = isLogin();

//保存推荐用户
$recUid = isset($recUid) ? $recUid : 0;
$recUid && saveRecUser($recUid);
if($userInfo && !$userInfo['isReced'] && $recUid){
    $recUserExist = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUid}");
    if($recUserExist){
        $dosql->ExecNoneQuery("UPDATE #@__member SET recUid={$recUserExist['id']} WHERE id={$userInfo['id']} AND id<>{$recUserExist['id']}");
        if($recUserExist['recUid'] == -1){
            $dosql->ExecNoneQuery("UPDATE #@__member SET recUid2=-1 WHERE id={$userInfo['id']}");
        }elseif($recUserExist['recUid'] == 0){
            $dosql->ExecNoneQuery("UPDATE #@__member SET recUid2=0 WHERE id={$userInfo['id']}");
        }else{
            $recUser2Exist = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUserExist['recUid']}");
            if($recUser2Exist){
                $dosql->ExecNoneQuery("UPDATE #@__member SET recUid2={$recUserExist['recUid']} WHERE id={$userInfo['id']} AND id<>{$recUserExist['recUid']}");
            }else{
                $dosql->ExecNoneQuery("UPDATE #@__member SET recUid2=0 WHERE id={$userInfo['id']}");
            }
        }
    }
}

if(empty($userInfo['mem_number'])){
    $mem_number = make_member_number($userInfo['id']);
    $dosql->ExecNoneQuery("update `#@__member` set mem_number = '$mem_number' where id = '{$userInfo['id']}' ");
}

$recUserInfo = $dosql->GetOne("SELECT id,recUid,username,truename,wechat_nickname FROM #@__member WHERE id={$userInfo['recUid']}");
$recName = $recUserInfo ? $recUserInfo['wechat_nickname'] : '官方商城';

//判断访问设备
//如果手动更改后台目录，请将/admin目录更改成新后台目录
/**
if (IsMobile() && !strstr(GetCurUrl(), 'mobile.php') && $cfg_mobile == 'Y' && !strstr(GetCurUrl(), '/myadmin')) {
    header('location:mobile.php');
}
*/

?>