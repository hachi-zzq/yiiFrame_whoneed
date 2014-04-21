<?php
/**
 * 用于push channel数据到curl地址
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-3-3
 * Time: 下午12:04
 * To change this template use File | Settings | File Templates.
 */
 class Shell_push_channelCommand extends CConsoleCommand{
     private $postUrl = 'http://stats.api.haoyoudou.com/v1/index.php?c=apichannel::addchannel';

     public function actionIndex(){
         echo "start push channel \n";
         //step1:get sync
         $channel_bid     = (int)MyFunction::getSetSync('shell_push_channel_bid');
         $sub_channel_bid = (int)MyFunction::getSetSync('shell_push_sub_channel_bid');
         
         //推送父渠道
         $f_channel_objs = Pdcc_channel::model()->findAll('id>'.$channel_bid);
         if( $f_channel_objs ){
             foreach($f_channel_objs as $f_channel_obj){
                 $f_channel_info = $this->getFChannelInfoById($f_channel_obj->id);
                 if( !$f_channel_info ){
                     MyFunction::saveException('push_channel','未查找到父渠道channel_id为'.$f_channel_obj->id.'的渠道信息');
                     echo 'push_channel','未查找到父渠道channel_id为'.$f_channel_obj->id.'的渠道信息'.PHP_EOL;
                     continue;
                 }
                 
                 //返回非200状态应是对面服务器出错,不再继续
                 if( $this->pushChannel($f_channel_info,$f_channel_obj->id) ){
                     MyFunction::getSetSync('shell_push_channel_bid',$f_channel_obj->id);
                 }else{
                     break;
                 }
             }
         }

         //推送子渠道
         $sub_channel_objs = Pdcc_sub_channel::model()->findAll('id>'.$sub_channel_bid);
         //var_dump($sub_channel_objs);die();
         if($sub_channel_objs){
             foreach($sub_channel_objs as $sub_channel_obj){
                 //验证父渠道
                 $f_channel_info = $this->getFChannelInfoById($sub_channel_obj->channel_id);
                 if( !$f_channel_info ){
                     MyFunction::saveException('push_channel','未查找到sub_channel为'.$sub_channel_obj->sub_id.'的父渠道'.$sub_channel_obj->channel_id);
                     echo '未查找到sub_channel为'.$sub_channel_obj->sub_id.'的父渠道'.$sub_channel_obj->channel_id.PHP_EOL;
                     continue;
                 }

                 if( $this->pushChannel($f_channel_info,$sub_channel_obj->channel_id,$sub_channel_obj->sub_id) ){
                     MyFunction::getSetSync('shell_push_sub_channel_bid',$sub_channel_obj->id);
                 }else{
                     break;
                 }
             }
         }
     }

     public function getAppObjById($appid){
         static $ObjAppArr=array();
         if( !isset($ObjAppArr[$appid]) ){
             $objApp = Pdc_app::model()->find("appid = '{$appid}'");
             if($objApp){
                 $ObjAppArr[$appid] = $objApp;
             }else{
                 return false;
             }
         }
         return $ObjAppArr[$appid];
     }

     public function getFChannelInfoById($channel_id){
         static $father_channels=array();
         $channel_id = (int)$channel_id;
         if( !isset($father_channels[$channel_id]) ){
             $f_channel = Pdcc_channel::model()->getDbConnection()->createCommand("select a.id,channel_name,b.app_ab,b.appid,c.company_ab from pdcc_channel as a join pdcc_product as b on a.product_id=b.id join pdcc_company as c on b.company_id=c.id where a.id='{$channel_id}'")->queryRow();
             if($f_channel){
                 $father_channels[$channel_id] = $f_channel;
                 //验证appid
                 $objApp = $this->getAppObjById($f_channel['appid']);
                 if( ! $objApp ){
                     MyFunction::saveException('push_channel','未查找到appid为的'.$f_channel['appid'].'appkey');
                     echo 'appkey is not found by appid',$f_channel['appid'],"\n";
                     return false;
                 }
                 $father_channels[$channel_id]['appkey'] = $objApp->appkey;
                 $father_channels[$channel_id]['appname']= $objApp->appname;
                 $father_channels[$channel_id]['prefix'] = $f_channel['company_ab'].'_'.$f_channel['app_ab'].'_';
             }else{
                 return false;
             }
         }
         return $father_channels[$channel_id];
     }

     public function pushChannel($f_channel_info,$channel_id,$sub_id=0){
         $arrPost['appkey'] = $f_channel_info['appkey'];
         $arrPost['appname']= $f_channel_info['appname'];
         $arrPost['id']     = $f_channel_info['prefix'].$channel_id.'_'.$sub_id;
         $arrPost['remark'] = 'ptb';
         $arrPost['client_type'] = 2;
         if($sub_id==0){
             $arrPost['cname']  = '渠道'.$channel_id;
             $arrPost['pid']    = 0;
         }else{
             $arrPost['cname']  = '渠道'.$channel_id.'_'.$sub_id;
             $arrPost['pid']    = $channel_id;
         }
         //var_dump($arrPost);return true;
         $ret = MyFunction::get_url($this->postUrl,1,$arrPost);
         if($ret['code'] == 200){
             $content =  json_decode($ret['content'],TRUE);
             echo 'id:'.$arrPost['id'].$content['flag'].'--'.$content['info'].PHP_EOL;
             if( $content['flag']=='success' ){
                 return true;
             }else{
                 MyFunction::saveException('push_channel','出错,flag:'.$content['flag'].';info:'.$content['info']);
                 return false;
             }
         }else{
             MyFunction::saveException('push_channel','出错,http-code:'.$ret['code']);
             echo 'error!http-code:'.$ret['code'].'--content:'.$ret['content'].PHP_EOL;
             return false;
         }
     }
 }