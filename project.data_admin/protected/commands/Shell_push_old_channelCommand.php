<?php
/**
 * 用于push old channel数据到curl地址
 *一次性跑完,后面不再使用
 */
 class Shell_push_old_channelCommand extends CConsoleCommand{
     private $postUrl = 'http://stats.api.haoyoudou.com/v1/index.php?c=apichannel::addchannel';

     public function actionIndex(){
         echo "start push old channel \n";
         
         $father_channels = array();
         $f_channels = Pdcc_channel::model()->getDbConnection()->createCommand("select a.id,channel_name,b.app_ab,b.appid from pdcc_channel as a join pdcc_product as b on a.product_id=b.id order by a.id")->queryAll();
         if($f_channels){
             foreach($f_channels as $f_channel){
                 //验证appid
                 $objApp = $this->getAppObjById($f_channel['appid']);
                 if( ! $objApp){
                     MyFunction::saveException('push_channel','未查找到appid为的'.$f_channel['appid'].'appkey');
                     echo 'appkey is not found by appid',$f_channel['appid'],"\n";
                     continue;
                 }
                 $father_channels[$f_channel['id']]= $f_channel;
                 $father_channels[$f_channel['id']]['appkey'] = $objApp->appkey;
                 $father_channels[$f_channel['id']]['appname']= $objApp->appname;
                 //推送父渠道
                 $arrPost = array();
                 $arrPost['appkey'] = $father_channels[$f_channel['id']]['appkey'];
                 $arrPost['appname']= $father_channels[$f_channel['id']]['appname'];
                 $arrPost['id']     = $f_channel['id'];
                 $arrPost['cname']  = '渠道'.$f_channel['id'];
                 $arrPost['remark'] = 'ptb';
                 $arrPost['pid']    = 0;
                 $arrPost['client_type'] = 2;
                 //var_dump($arrPost);die();
                 $ret = MyFunction::get_url($this->postUrl,1,$arrPost);
                 if($ret['code'] == 200){
                     $content =  json_decode($ret['content'],TRUE);
                     echo "id:".$arrPost['id'].$content['flag'].'--',$content['info'].PHP_EOL;
                 }else{
                     MyFunction::saveException('push_channel','出错,http-code:'.$ret['code']);
                     echo 'error!http-code:'.$ret['code'].'--content:',$ret['content'];
                     break;
                 }
             }
         }

         //推送子渠道
         $sub_channel_objs = Pdcc_sub_channel::model()->findAll();
         //var_dump($sub_channel_objs);die();
         foreach($sub_channel_objs as $sub_channel_obj){
             //验证父渠道
             if( !isset($father_channels[$sub_channel_obj->channel_id]) ){
                 MyFunction::saveException('push_channel','未查找到sub_channel为'.$sub_channel_obj->sub_id.'的父渠道'.$sub_channel_obj->channel_id);
                 echo '未查找到sub_channel为'.$sub_channel_obj->sub_id.'的父渠道'.$sub_channel_obj->channel_id.PHP_EOL;
                 continue;
             }
             $arrPost = array();
             $arrPost['appkey'] = $father_channels[$sub_channel_obj->channel_id]['appkey'];
             $arrPost['appname']= $father_channels[$sub_channel_obj->channel_id]['appname'];
             $arrPost['id']     = $sub_channel_obj->sub_id;
             $arrPost['cname']  = '渠道'.$sub_channel_obj->sub_id;
             $arrPost['remark'] = 'ptb';
             $arrPost['pid']    = $sub_channel_obj->channel_id;
             $arrPost['client_type'] = 2;
             //var_dump($arrPost);continue;
             $ret = MyFunction::get_url($this->postUrl,1,$arrPost);
             if($ret['code'] == 200){
                 $content =  json_decode($ret['content'],TRUE);
                 echo "id:".$arrPost['id'].$content['flag'].'--'.$content['info'].PHP_EOL;
             }else{
                 MyFunction::saveException('push_channel','出错,http-code:'.$ret['code']);
                 echo 'error!http-code:'.$ret['code'].'--content:'.$ret['content'];
                 break;
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
 }