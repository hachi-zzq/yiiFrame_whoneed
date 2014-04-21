<?php
/**
 *用户激活
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-20
 * Time: 上午11:17
 * To change this template use File | Settings | File Templates.
*/
class Record_user_new_activeCommand extends CConsoleCommand{
    private $bid = 0;
    private $limit = 500;

    public function actionIndex(){
        echo "Recording user_active,please wait.....\t\n";
        $limit = $this->limit;
        // step1: connect ssdb
        $ssdb = MyFunction::getSSDB();

        while(true){
            //查找断点,保存断点
            $bid = (int)MyFunction::getSetSync('record_user_active_bid');
            $cdb = new CDbCriteria();
            $cdb->addCondition("id > '{$bid}'");
            $cdb->order = 'id ASC';
            $cdb->limit = $limit;
            $reg_users = Pdl_user_log_1::model()->findAll($cdb);
            if($reg_users){
                foreach($reg_users as $v){
                    //记录下次程序开始执行的id
                    $this->bid = $v['id'];

                    //获取channel_id,sub_id;
                    $channelInfo = Myfunction::getChannelByServerid($v['serverid']);
                    if(!$channelInfo){
                        MyFunction::saveException('record_new_active','未查询到相应的channel_id,sub_id,通过serverid:'.$v['serverid']);
                        continue;
                    }

                    //过滤重复的激活用户
                    $uniqueStr = md5($channelInfo['channel_id'].'_'.$channelInfo['sub_id'].'_'.$v['appid'].'_'.$v['imei'].'_md5_user_active');
                    if($ssdb->get($uniqueStr) == 1) continue;

                    //查找app信息
                    $appObj = MyFunction::getAppObjByAppKey( $v['appid'] );
                    if(!$appObj){
                        MyFunction::saveException('record_new_active','未查询到相应的appid,通过appkey:'.$v['appid']);
                        continue;
                    }

                    //获取pdcTypeObj
                    $pdcTypeObj = MyFunction::getPdcTypeObj($appObj->appid,$channelInfo['channel_id'],$channelInfo['sub_id'],$v['device']);
                    //插入pdc_reg_login_user,以record_date汇总
                    $date_format = date('Y-m-d',$v['addtime']);

                    //不存在此key,插入new_active
                    if($oneRecord = $this->findOneTimeFromRecord($date_format,$pdcTypeObj->id)){
                        $this->updateOldTime($oneRecord['id']);
                    }else{
                        $this->insertNewTime($date_format,$pdcTypeObj->id);
                    }
                    $ssdb->set($uniqueStr,1);

                    echo "record id {$v['id']}\n";
                }
                //保存断点到数据库
                MyFunction::getSetSync('record_user_active_bid',$this->bid);
            }else{
                echo "\t Recording complete!!\n";
                break;
            }
        }
    }

    //查找pdc_reg_lgoin_user时间，用于更新统计
    public function findOneTimeFromRecord($time,$type){
        if($one = Yii::app()->db_data_centre->createCommand("SELECT id,type FROM pdc_active  WHERE record_date = '$time' AND type='$type'")->queryRow()){
            return $one;
        }else{
            return '';
        }
    }

    //插入record表,用于统计查找到的新时间
    public function insertNewTime($record_date,$type){
        $sql = "INSERT INTO  pdc_active (record_date,type,nums) VALUES ('$record_date','$type',1)";
        Yii::app()->db_data_centre->createCommand($sql)->execute();
    }

    //更新record表，用于统计已经存在的时间
    public function updateOldTime($id){
        $sql = "UPDATE pdc_active SET nums=nums+1 WHERE id = '$id'";
        Yii::app()->db_data_centre->createCommand($sql)->execute();
    }
}