<?php
/**
* ，周活跃数（按照登录计算）
* Created by JetBrains PhpStorm.
* User: zhu
* Date: 14-1-20
* Time: 上午11:28
* To change this template use File | Settings | File Templates.
*week_active::最近七天注册,并登录过的用户.
*第一步:从Pdl_user_log_5注册表中查询 (记录日期) 最近七天注册的用户.
*第二步:在登录表中查找注册时间 到 (记录日期) 是否登录过,登录则为 注册日期 week_active,给其自增1;
*第三步:全部查询完后,将记录的数据写入pdc_week_active,如记录日期,type已有数据,会覆盖之前数据.
*
*重复运行数据会被覆盖,无影响
*
*
*另一种思路
*查询最近七天所有注册用户,遍历,缓存中判断是否是周活跃用户,如果是周活跃用户,跳过,不是则到登录表中去查询(如登录表中查是周活跃用户,则缓存为周活跃用户)
*
*另一种思路
*以登录表反查注册表,缓存bid,每增加一个登录用户,查询是否最近七天注册,如是,注册时期活跃用户加1,并且缓存用户.(下次登录则直接跳过)
*
*思路:缓存最后一次执行的注册bid,  每次查询注册>bid,并且日期<(now-7days),则执行,并缓存为bid.
*/
class Record_week_activeCommand extends CConsoleCommand{
    public function actionIndex($date = null){
        $SSDB = MyFunction::getSSDB();
        $date or $date=date('Y-m-d');
        $timeNowStamp = strtotime($date);
        $pre_seven_day = date('Y-m-d',strtotime($date)-7*24*3600);
        echo "Start record $pre_seven_day to $date week_active,please wait.....\t\n";
        $pre_seven_begin_stamp = strtotime($pre_seven_day.' 00:00:00');
        //存放时间-type-nums数组
        $arrNums =  array();
        //初始化bid
        $bid = 0;
        while(TRUE){
            $cdb = new CDbCriteria();
            $cdb->condition = "addtime BETWEEN '{$pre_seven_begin_stamp}' and '{$timeNowStamp}' and id > '{$bid}'";
            $cdb->limit = 20;
            $cdb->order = 'id ASC';
            //注册表中查找数据
            $reg_users = Pdl_user_log_5::model()->findAll($cdb);
            if($reg_users){
                //缓存处理(数组存储)
                foreach($reg_users as $v){
                    $regTime = $v['addtime'];
                    $regDate = date('Y-m-d',$regTime);
                    $appId = $v['appid'];
                    //查找app信息
                    $appObj = MyFunction::getAppObjByAppKey( $v['appid'] );
                    if(!$appObj){
                        MyFunction::saveException('shell_record_login','通过appkey未查询到相应的appid');
                        continue;
                    }

                    //用户名不存在,过滤掉
                    if(!$v['account']){
                        continue;
                    }

                    //根据serverid 获取channelInfo('channel_id'=>$channel_id,'sub_id'=>$sub_id)
                    $channelInfo = MyFunction::getChannelByServerid($v['serverid']);
                    if(!$channelInfo){
                        MyFunction::saveException('week_active','未查询到相应的channel_id,sub_id,通过serverid:'.$v['serverid']);
                        continue;
                    }

                    //获取pdcTypeObj
                    $pdcTypeObj = MyFunction::getPdcTypeObj($appObj->appid,$channelInfo['channel_id'],$channelInfo['sub_id'],$v['device']);

                    //在登录表中查找
                    if( $this->seekInLogin($regTime,$timeNowStamp,$v['account']) ){
                        //数组统计
                        isset( $arrNums[$regDate][$pdcTypeObj->id] ) or $arrNums[$regDate][$pdcTypeObj->id] = 0;
                        $arrNums[$regDate][$pdcTypeObj->id] ++;
                    }
                }
                $bid = $v['id'];
            }else{
                break;
            }
        }

        //save login
        if($arrNums){
            foreach($arrNums as $date_record=>$arrTypeNums){
                if($arrTypeNums){
                    foreach($arrTypeNums as $type=>$typeNums){
                        $this->updateOldTime($date_record,$type,$typeNums);
                    }
                }
            }
        }
        echo "record week_active complete!!\n";
    }

    //登录表中进行查找是否登录过
    public function seekInLogin($startTime,$endTime,$account){
        $sql = "SELECT id FROM pdl_user_log_3 WHERE addtime BETWEEN '{$startTime}' and '{$endTime}' and account='{$account}' limit 1";
        return Yii::app()->db_data_log->createCommand($sql)->query();
    }

    //更新record表，用于统计已经存在的时间
    public function updateOldTime($time,$type,$loginNum){
        $sql = "SELECT id FROM pdc_week_active WHERE record_date='{$time}' and type='{$type}'";
        if($one = Yii::app()->db_data_centre->createCommand($sql)->queryRow()){
            $id = $one['id'];
            $updateSql = "UPDATE pdc_week_active SET nums = '{$loginNum}' WHERE id='{$id}'";
            Yii::app()->db_data_centre->createCommand($updateSql)->execute();
        }else{
            $insertSql = "INSERT INTO pdc_week_active (record_date,type,nums) VALUES ('$time','$type','$loginNum')";
            Yii::app()->db_data_centre->createCommand($insertSql)->execute();
        }
    }

    //一次性数据处理
    public function actionAllDateWeekActive($begin_date = '2014-01-01'){
        $end_stamp  = time();
        for($time_stamp = strtotime($begin_date);$time_stamp<=$end_stamp;$time_stamp+=86400){
            $date = date('Y-m-d',$time_stamp);
            echo 'week active date:'.$date.' execute begin'.PHP_EOL;
            $this->actionIndex($date);
            sleep(1);
        }
    }
}