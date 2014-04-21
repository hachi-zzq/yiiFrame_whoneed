<?php
/**
 * package 
 *
 * @author      嬴益虎<Yingyh@whoneed.com>
 * @copyright	Copyright 2013
 *
 */

class PackageController extends MyPageController
{
    // record the click nums and than jump the apk url
    public function actionIndex()
    {
        // get the param
        $channel_id = intval(Yii::app()->request->getParam('channel_id'));
        $sub_id     = Yii::app()->request->getParam('sub_id');
        //兼容pdc_channel旧格式
        if($sub_id === null){
            $channelinfo = MyFunction::getChannelInfo($channel_id);
            if(!$channelinfo) die('Error!');
            $channel_id  = $channelinfo['channel_id'];
            $sub_id      = $channelinfo['sub_id'];
        }

        if(!$channel_id){
            die('Error!');
        }

        // get the relation obj
        $objDB = Pdc_channel_distribute::model()->find("channel_id = {$channel_id} and sub_id = {$sub_id}");
        if(!$objDB){
            die('obj Error!');
        }

        // record click log
        Pdl_channel_day::doNewLog($objDB);

        // jump the apk url
        $strJUrl = Yii::app()->params['cdn_domain'].$objDB->package_path;
        //$this->redirect($strJUrl);

        $channle_obj = Pdcc_channel::model()->find("id = {$channel_id}");
        if( (1==$channle_obj->is_redirect) && !empty($channle_obj->view_name) ){
            if($this->check_wap()){
                //如果是手机
                $this->renderPartial($channle_obj->view_name.'_phone',array('url'=>$strJUrl));;
            }else{
                //pc
                $this->renderPartial($channle_obj->view_name,array('url'=>$strJUrl));
            }
        }else{
            $this->redirect($strJUrl);
        }
    }


    function check_wap(){
        // 先检查是否为wap代理，准确度高
        if(stristr($_SERVER['HTTP_VIA'],"wap")){
            return true;
        }
        // 检查浏览器是否接受 WML.
        elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
            return true;
        }
        //检查USER_AGENT
        elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function actionDownload()
    {
        // get the param
        $channel_id = intval(Yii::app()->request->getParam('channel_id'));
        $sub_id     = Yii::app()->request->getParam('sub_id');
        if(!$channel_id){ echo 1; exit; }
        //兼容pdc_channel旧格式
        if($sub_id === null){
            $channelinfo = MyFunction::getChannelInfo($channel_id);
            if(!$channelinfo){
                echo 3;exit;
            }
            $channel_id  = $channelinfo['channel_id'];
            $sub_id      = $channelinfo['sub_id'];
        }

        $objDB = Pdc_channel_distribute::model()->find("channel_id = {$channel_id} and sub_id = {$sub_id}");
        if($objDB){
            $strJUrl = Yii::app()->params['cdn_domain'].$objDB->package_path;
            //echo $strJUrl;
            $this->redirect($strJUrl);
        }else{
            echo 2;
            exit;
        }
    }

    public function actionD7794()
    {
        // get the param
        $channel_id = intval(Yii::app()->request->getParam('channel_id'));
        $sub_id     = intval(Yii::app()->request->getParam('sub_id'));

        if(!$channel_id){
            die('Error!');
        }

        // get the relation obj
        $objDB = Pdc_channel_distribute::model()->find("channel_id = {$channel_id} and sub_id = {$sub_id}");
        if(!$objDB){
            die('obj Error!');
        }

        // record click log
        Pdl_channel_day::doNewLog($objDB);

        // jump the apk url
        //$strJUrl = Yii::app()->params['cdn_domain'].$objDB->package_path;
        $strJUrl = 'https://itunes.apple.com/cn/app/huang-di-jue-qi/id604615270?mt=8';
        $this->redirect($strJUrl);
    }    

    public function actionDapk()
    {
        $apk_url = urldecode(trim(Yii::app()->request->getParam('apk_url')));
                //apk
        if(preg_match('/\?ios$/',$apk_url)){
            $this->redirect($apk_url);
        }
        $data = array();
        $data['apk_url'] = $apk_url;
        $this->display('dapk', $data);
    }


}
