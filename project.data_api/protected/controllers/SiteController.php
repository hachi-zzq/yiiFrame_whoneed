<?php
/**
 * api
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2012
 *
 */

class SiteController extends MyPageController
{
	// 首页
	public function actionIndex(){
		echo 'hoho';
	}

    // test 
    public function actionTest()
    {
        echo 'this is a test';
        $strAndroidJUrl = "http://cdn.patabom.com/apk/20140127/King_30.apk#mp.weixin.qq.com";
        $strAndroidJUrl = 'http://www.patabom.com/channel_30.html#mp.weixin.qq.com';
        $strIphoneJUrl  = 'https://itunes.apple.com/cn/app/huang-di-jue-qi/id604615270?mt=8';
        $user_agent     = $_SERVER['HTTP_USER_AGENT'];
echo $user_agent;exit;
        // Android
        if(stripos($user_agent, 'Android') !== false){
            //$this->redirect($strAndroidJUrl);
            header("Location: {$strAndroidJUrl}"); 
            exit;
        }else if(stripos($user_agent, 'iPhone') !== false){
            // iphone
            $this->redirect($strIphoneJUrl);
        }

        /*
        $arrPhones			= array('Android','iPhone','SymbianOS','Nokia','MIDP','Windows Phone OS','iPad');

		// 判断手机
		foreach($arrPhones as $k=>$v){
			if(stripos($AD['strUserAgent'],$v) !== false){ // stripos 不区分大小写
                if($v == 'Android'){
                    //$this->redirect($strAndroidJUrl);
                    echo "android";
                }else if($v == 'iPhone'){
                    echo 'iphone';
                    //$this->redirect($strIphoneJUrl);
                }
				break;
			}
        }*/
        //print_r($_SERVER);
    }

    public function actionTd()
    {
        $strAndroidJUrl = 'http://cdn.patabom.com/apk/20140127/King_30.apk';
        header("Location: {$strAndroidJUrl}"); 
        exit;
    }
}
?>
