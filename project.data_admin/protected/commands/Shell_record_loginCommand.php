<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-21
 * Time: 上午11:04
 * To change this template use File | Settings | File Templates.
 *登录次数:注册当天除外的登录次数+1;如注册当天以外的第一次登录为2登;
 *
 */
class Shell_record_loginCommand extends CConsoleCommand{
    //第二次,第三次，第五次登录用户数（区别于二等数）
    public function actionIndex(){
        $bid = (int)MyFunction::getSetSync('record_login_nums_bid');
        $ssdb = MyFunction::getSSDB();
        $arrLoginUser = array();
        while(1){
            $cdb = new CDbCriteria();
            $cdb->condition = "id > '{$bid}' ";
            $cdb->order = 'id ASC';
            $cdb->limit = 20;
            //step 1:find login data
            $objUserLogin = Pdl_user_log_3::model()->findAll($cdb);
            if($objUserLogin){
                foreach($objUserLogin as $loginObj){
                    $bid    = $loginObj->id;
                    $account= $loginObj->account;
                    //用户名不存在,过滤掉
                    if(!$loginObj->account){
                        continue;
                    }
                    //查找app信息
                    $appObj = MyFunction::getAppObjByAppKey( $loginObj->appid );
                    if(!$appObj){
                        MyFunction::saveException( 'shell_record_login','通过appkey未查询到相应的appid:'.$loginObj->appid );
                        continue;
                    }
                    //根据serverid 获取channelInfo('channel_id'=>$channel_id,'sub_id'=>$sub_id)
                    $channelInfo = MyFunction::getChannelByServerid( $loginObj->serverid );
                    if(!$channelInfo){
                        MyFunction::saveException( 'record_login','未查询到相应的channel_id,sub_id,通过serverid:'.$loginObj->serverid );
                        continue;
                    }
                    //获取pdcTypeObj
                    $pdcTypeObj = MyFunction::getPdcTypeObj($appObj->appid,$channelInfo['channel_id'],$channelInfo['sub_id'],$loginObj->device );

                    //type+account唯一用户识别
                    $uniqueUser = strtolower($account.'_'.$pdcTypeObj->id.'_md5_login_nums');
                    //$ssdb->set( $uniqueUser,'');continue;//------------------------------------------------------------------------测试行---------------------------------
                    $ssdb_data = $ssdb->get($uniqueUser);
                    if( empty($ssdb_data) ){
                        //注册表获取注册信息
                        $regObj = Pdl_user_log_5::model()->find("account = '{$account}'");
                        if(!$regObj){
                            MyFunction::saveException('shell_record_login','not found user register info by account:'.$account);
                            continue;
                        }
                        $regEndTimeStamp = strtotime(date('Y-m-d',$regObj->addtime).' 23:59:59');

                        //登录表中查询登录次数
                        $serverid_array  = MyFunction::getAllServerTypeByServerid($loginObj->serverid);
                        $serverid_str    = '';
                        foreach($serverid_array as $serverid){
                            $serverid_str.="'".$serverid."',";
                        }
                        $serverid_str = trim($serverid_str,',');
                        $loginNums = Pdl_user_log_3::model()->count("account = '{$account}' and appid ='{$loginObj->appid}' and serverid in($serverid_str) and device='{$loginObj->device}' and addtime > '{$regEndTimeStamp}' and addtime <= '{$loginObj->addtime}' ");
                        $reg_date = date('Y-m-d',$regObj->addtime);
                        $ssdb_data = array( 'reg_date'=>$reg_date,'loginNums'=>$loginNums);
                    }else{
                        $ssdb_data = unserialize( $ssdb_data );
                        //登录日期非注册日,则登录次数+1(登录次数为0,则代表之前登录均为注册日登录)
                        if( $ssdb_data['loginNums'] != 0 || $ssdb_data['reg_date'] != date('Y-m-d',$loginObj->addtime) ){
                            $ssdb_data['loginNums']++;
                        }
                    }
                    $ssdb->set( $uniqueUser,serialize($ssdb_data) );
                    
                    //$ssdb_data['loginNums'] > 4代表已经查出五登数,$ssdb_data['loginNums']=0代表为注册日登录,为3不作统计;
                    $incrKey = null;
                    if( $ssdb_data['loginNums'] == 4 ){
                        $incrKey = 'login_fifth_nums' ;
                    }else if( $ssdb_data['loginNums'] ==2 ){
                        $incrKey = 'login_third_nums' ;
                    }else if( $ssdb_data['loginNums'] ==1 ){
                        $incrKey = 'login_twice_nums' ;
                    }else{
                        continue;
                    }
                    if( $this->updateLoginNum( $ssdb_data['reg_date'],$pdcTypeObj->id,$incrKey) ){
                        //保存断点
                        echo "saved id: $bid".PHP_EOL;
                        MyFunction::getSetSync('record_login_nums_bid',$bid);
                    }
                }
                //避免continue掉后死循环
                MyFunction::getSetSync('record_login_nums_bid',$bid);
            }else{
                break;
            }
        }
        echo 'record login_num complete!!'."\n";
    }

    //update login_twice
    public function updateLoginNum($time,$type,$incrKey){
        $Pdc_login_obj = Pdc_login::model()->find("record_date='{$time}' and type='{$type}'");
        if(!$Pdc_login_obj){
            $Pdc_login_obj = new Pdc_login;
            $Pdc_login_obj->record_date = $time;
            $Pdc_login_obj->type        = $type;
            $Pdc_login_obj->$incrKey    = 0;
        }
        $Pdc_login_obj->$incrKey++;
        return $Pdc_login_obj->save();
    }
}