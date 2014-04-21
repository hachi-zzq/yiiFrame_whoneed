<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-20
 * Time: 上午11:17
 * To change this template use File | Settings | File Templates.
 *第一步:查询开始id,如无则为0;程序结束时记录下次开始运行id;
 *第二步:从Pdl_user_log_1打开程序表中查询 (记录id) 之后数据
 *第三步:针对每一个用户数据进行去重(根据channel_id,sub_id,appid,imei);
 *第四步:写入数据,记录日期,type已有数据则自增1;如无,则插入;
 *
 *重复运行会被开始id过滤掉,并且有去重程序,不会有任何影响.
 *有过滤重复程序,所以没有做数组缓存,否则程序意外中断数据会出错.
 *数据校验方法:数据库中查询sql举例:  select distinct a.appid,a.serverid,a.imei from project_data_log.pdl_user_log_1 as a join project_data_centre.pdc_app as b on a.appid=b.appkey where a.addtime<=UNIX_TIMESTAMP('2014-01-15')  and a.serverid =11;(join app表是为了验证appid必须正确)
 */
class Record_new_runCommand extends CConsoleCommand{
    private $bid = 0;
    private $limit = 500;


    public function actionIndex(){
        echo "Recording user_active,please wait.....\t\n";
        $limit = $this->limit;
        // step1: connect ssdb
        $ssdb = MyFunction::getSSDB();

        while(true){
            //查找断点,保存断点
            $bid = (int)MyFunction::getSetSync('record_new_run_bid');
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
                        MyFunction::saveException('record_new_run','未查询到相应的channel_id,sub_id,通过serverid:'.$v['serverid']);
                        continue;
                    }

                    //过滤重复的打开用户,加'_'隔开避免 channel_id.sub_id重复,如11,1与1,11
                    $strMd5 = strtolower($channelInfo['channel_id'].'_'.$channelInfo['sub_id'].'_'.$v['appid'].'_'.$v['imei'].'_md5_new_run');
                    //$ssdb->set( $strMd5,'');continue;//-------------------------------------------------------------------------测试行------------------------------------
                    if($ssdb->get($strMd5) == 1){
                        continue;
                    }

                    //查找app信息
                    $appObj = MyFunction::getAppObjByAppKey( $v['appid'] );
                    if(!$appObj){
                        MyFunction::saveException('record_new_run','未查询到相应的appid,通过appkey:'.$v['appid']);
                        continue;
                    }

                    //获取pdcTypeObj
                    $pdcTypeObj = MyFunction::getPdcTypeObj($appObj->appid,$channelInfo['channel_id'],$channelInfo['sub_id'],$v['device']);

                    //插入pdc_reg_login_user,以record_date汇总
                    $date_format = date('Y-m-d',$v['addtime']);

                    //更新用户new_run
                    $this->updateUserNewRun($date_format,$pdcTypeObj->id);
                    $ssdb->set($strMd5,1);
                    echo "record id {$v['id']}\n";
                }
                //保存断点到数据库
                MyFunction::getSetSync('record_new_run_bid',$this->bid);
            }else{
                echo "\t Recording complete!!\n";
                break;
            }
        }
    }

    //更新用户注册数据或插入用户注册数据
    public function updateUserNewRun($record_date,$type){
        $sql = "SELECT id,type FROM pdc_new_run  WHERE record_date = '$record_date' AND type='$type'";
        if($one = Yii::app()->db_data_centre->createCommand($sql)->queryRow()){
            $id = $one['id'];
            $updateSql = "UPDATE pdc_new_run SET nums=nums+1 WHERE id = '$id'";
            Yii::app()->db_data_centre->createCommand($updateSql)->execute();
        }else{
            $insertSql = "INSERT INTO  pdc_new_run (record_date,type,nums) VALUES ('$record_date','$type',1)";
            Yii::app()->db_data_centre->createCommand($insertSql)->execute();
        }
    }
}