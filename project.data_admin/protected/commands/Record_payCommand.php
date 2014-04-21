<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-22
 * Time: 下午4:04
 * To change this template use File | Settings | File Templates.
 */
class Record_payCommand extends CConsoleCommand{
    private $tableName = 'pdl_order';
    private $limit = 200;
    private $bid = 0;

    public function actionIndex(){
        $tableName = $this->tableName;
        $limit = $this->limit;
        while(true){
            //查找断点
            $bid = (int)MyFunction::getSetSync('record_user_pay_bid');
            $pays = Yii::app()->db_data_log->createCommand("SELECT id,user_id,money,pay_time,app_id,proxy_channel_id FROM $tableName WHERE id > '$bid' ORDER BY id ASC LIMIT $limit")->queryAll();
            if($pays){
                foreach($pays as $p){
                    $this->bid = $p['id'];
                    //查询用户信息,获取渠道信息
                    if($userInfo = $this->getUserById($p['user_id'])){
                        $userId   = $userInfo['id'];
                        $account  = $userInfo['account'];
                        $regTime  = date('Y-m-d H:i:s',$userInfo['ctime']);
                        $device   = '';
                    }else{
                        //未查到用户，添加到异常
                        $userId   = $p['user_id'];
                        $account  = '';
                        $regTime  = date('Y-m-d H:i:s',$p['pay_time']);
                        $device   = '';
                        MyFunction::saveException('record_user_pay','未找到user_id为'.$p['user_id'].'的用户');
                    }

                    //获取channel_id,sub_id;
                    $channelInfo = Myfunction::getChannelByServerid($p['proxy_channel_id']);
                    if(!$channelInfo){
                        MyFunction::saveException('record_user_pay','未查询到相应的channel_id,sub_id,通过serverid:'.$p['proxy_channel_id']);
                        continue;
                    }

                    //判断appid是否存在
                    $appObj = $this->isAppExist( $p['app_id'] );
                    if(!$appObj){
                        MyFunction::saveException('record_user_pay','appid不存在:'.$p['app_id'] );
                        continue;
                    }

                    //付款时间
                    $payTime = date('Y-m-d H:i:s',$p['pay_time']);
                    //插入目标表
                    $this->insertPayAtom($userId,$account,$channelInfo['channel_id'],$channelInfo['sub_id'],$appObj->appid,$device,$regTime,$payTime,$p['money']);
                    echo "record id {$p['id']}".PHP_EOL;
                }
                //保存断点到数据库
                MyFunction::getSetSync('record_user_pay_bid',$this->bid);
            }else{
                echo "\t complete!!";
                break;
            }
        }
    }

    //查询用户信息通过用户名
     public function getUserById($user_id){
         return Yii::app()->db_data_log->createCommand("SELECT id,account,ctime FROM pdl_user WHERE id = '$user_id' LIMIT 1")->queryRow();
     }

   //插入目标表
     public function insertPayAtom($userId,$account,$channelId,$subId,$appId,$device,$regTime,$payTime,$payAmount){
         Yii::app()->db_data_statistics->createCommand("INSERT INTO pds_pay_atom_statistics (user_id,account,channel_id,sub_id,appid,device,reg_time,pay_time,pay_amount) VALUES ('$userId','$account','$channelId','$subId','$appId','$device','$regTime','$payTime','$payAmount')")->execute();
     }

     public function isAppExist($app_id){
         return Pdc_app::model()->find("appid='{$app_id}'");
     }
}