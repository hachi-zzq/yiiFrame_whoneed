<?php
/**
 * 渠道统计
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2014
 *
 */
/*3.28新问题
 *pdl_user_log_(1~6)表中serverid由channel_id改为 ($company)_($product)_($channel_fid)_($sub_id)
 *@之前没有子id的 $channel_id 等价于 $channel_id和$sub_id=1;
 *
 */
class ChannelCommand extends CConsoleCommand
{

    public function actionTest()
    {
        echo 'This is test!'."\t\n";
    }

    // channel statistics data update interface
    public function actionChannel_statistics()
    {
        $this->fun_import();
        $record_date = date('Y-m-d', time() - 3600);
        $this->fun_note("channel_statistics ..........");
        $this->fun_note("record_date = {$record_date}");

        // reg_user
        $this->fun_statistics_reg_user($record_date);

        // active_user
        //$this->fun_statistics_active_user($record_date);

        //new run
        $this->fun_statistics_new_run($record_date);
        // count link click
        $this->fun_count_link_click($record_date);

        //count login_2,count week_active跑最近七天的数据
        $time_now = time();
        for($time_stamp = ($time_now-8*24*3600);$time_stamp<=$time_now;$time_stamp+=86400){
            $record_date = date('Y-m-d',$time_stamp);
            echo 'record date:'.$record_date.'--begin'.PHP_EOL;
            $this->fun_count_login_2($record_date);
            $this->fun_count_week_active($record_date);
        }
        $this->fun_note("channel_statistics complete !");
    }

    // count link click from pdl_channel_day table
    public function actionCount_link_click($record_date = null)
    {
        $this->fun_import();
        $record_date= $record_date ? date('Ymd',strtotime($record_date)) : date('Ymd', time() - 3600);
        $ope_key    = 'shell_count_link_click_'.$record_date;
        $table_name = "pdl_channel_day_{$record_date}";
        $bid        = 0;
        
        //查找断点,保存断点
        $bid =  (int)MyFunction::getSetSync($ope_key);
        //检查统计表是否存在
        if( !Page::funGetIntroBySql("SHOW TABLES LIKE '{$table_name}'", false, Yii::app()->db_data_log) ) return;
        // step1: get data from log table
        while(true){
            $sql = "select * from {$table_name} where id > {$bid} order by id asc limit 100";
            $arrR = Page::funGetIntroBySql($sql, false, Yii::app()->db_data_log);
            if($arrR){
                foreach($arrR as $arrData){
                    $bid        = intval($arrData['id']);
                    $channel_id = intval($arrData['channel_id']);
                    $sub_id     = intval($arrData['sub_id']);
                    $appid      = intval($arrData['game_id']);

                    // step2: update data to pdc_channel_link_click
                    $objDB = Pdc_channel_link_click::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and sub_id = {$sub_id} and appid = {$appid}");
                    if(!$objDB){
                        $objDB = new Pdc_channel_link_click();
                        $objDB->record_date = $record_date;
                        $objDB->channel_id  = $channel_id;
                        $objDB->sub_id      = $sub_id;
                        $objDB->appid       = $appid;
                        $objDB->nums        = 0;
                    }
                    $objDB->nums += 1;
                    $objDB->save();
                }
            }else{
                break;
            }
        }
        //保存断点到数据库
        MyFunction::getSetSync($ope_key,$bid);
    }

    // function
    // reg_user
    public function fun_statistics_reg_user($record_date = '')
    {
        $this->fun_note("fun: fun_statistics_reg_user begin ...");
        if(!$record_date) exit("invalid record_date");

        // step 1: get data from pdc_reg_login_user
        $objDB = Pdc_reg_login_user::model()->findAll("record_date = '{$record_date}'");
        if($objDB)
        {
            $arrType    = array();
            $arrChannel = array();

            foreach($objDB as $obj){
                $objType = $this->getObjTypeById($obj->type);
                if(!$objType) continue;
                $objPCD =$this->getPdsChannelDailyObj($record_date,$objType->channel_id,$objType->sub_id,$objType->appid);
                $objPCD->reg_users = $obj->reg_nums;
                $objPCD->save();
            }
        }
        $this->fun_note("fun: fun_statistics_reg_user end.");
    }

    // active_user已改
    public function fun_statistics_active_user($record_date = '')
    {
        $this->fun_note("fun: fun_statistics_active_user begin ...");
        if(!$record_date) exit("invalid record_date");

        // step 1: get data from pdc_reg_login_user
        $objDB = Pdc_active::model()->findAll("record_date = '{$record_date}'");
        if($objDB)
        {
            $arrType    = array();
            $arrChannel = array();

            foreach($objDB as $obj){
                $objType = $this->getObjTypeById($obj->type);
                if(!$objType) continue;
                
                $objPCD =$this->getPdsChannelDailyObj($record_date,$objType->channel_id,$objType->sub_id,$objType->appid);
                $objPCD->active_nums = $obj->nums;
                $objPCD->save();
            }
        }
        $this->fun_note("fun: fun_statistics_active_user end.");
    }

    // active_user
    public function fun_statistics_new_run($record_date = '')
    {
        $this->fun_note("fun: fun_statistics_new_run begin ...");
        if(!$record_date) exit("invalid record_date");

        // step 1: get data from pdc_reg_login_user
        $objDB = Pdc_new_run::model()->findAll("record_date = '{$record_date}'");
        if($objDB)
        {
            $arrType    = array();
            $arrChannel = array();

            foreach($objDB as $obj){
                $objType = $this->getObjTypeById($obj->type);
                if(!$objType) continue;
                
                $objPCD =$this->getPdsChannelDailyObj($record_date,$objType->channel_id,$objType->sub_id,$objType->appid);
                $objPCD->new_run_nums = $obj->nums;
                $objPCD->save();
            }
        }
        $this->fun_note("fun: fun_statistics_new_run end.");
    }

    // count click
    public function fun_count_link_click($record_date = '')
    {
        $this->fun_note("fun: fun_count_link_click ......");
        if(!$record_date) exit("invalid record_date");

        // step1: get data from pdc_channel_link_click
        $objDB = Pdc_channel_link_click::model()->findAll("record_date = '{$record_date}'");
        if($objDB){
            foreach($objDB as $obj){
                $objPCD =$this->getPdsChannelDailyObj($record_date,$obj->channel_id,$obj->sub_id,$obj->appid);
                $objPCD->click_nums = $obj->nums;
                $objPCD->save();
            }
        }
        $this->fun_note("fun: fun_count_link_click end.");
    }

    //login_2
    public function fun_count_login_2($record_date=''){
        $this->fun_note("fun: fun_count_login_2 ......");
        if(!$record_date) exit("invalid record_date");
        // step1: get data from pdc_channel_link_click
        $objDB = Pdc_login::model()->findAll("record_date = '{$record_date}'");
        if($objDB){
            $arrType    = array();
            $arrChannel = array();
            foreach($objDB as $obj){
                $objType = $this->getObjTypeById($obj->type);
                if(!$objType) continue;
                
                $objPCD =$this->getPdsChannelDailyObj($record_date,$objType->channel_id,$objType->sub_id,$objType->appid);
                $objPCD->login_twice_nums = $obj->login_twice_nums;
                $objPCD->login_third_nums = $obj->login_third_nums;
                $objPCD->login_fifth_nums = $obj->login_fifth_nums;
                $objPCD->save();
            }
        }
        $this->fun_note("fun: fun_statistics_login_2 end.");
    }


    //week active
    public function fun_count_week_active($record_date=''){
        $this->fun_note("fun: fun_count_week_active ......");
        if(!$record_date) exit("invalid record_date");
        // step1: get data from pdc_channel_link_click
        $objDB =  Pdc_week_active::model()->findAll("record_date = '{$record_date}'");
        if($objDB){
            $arrType    = array();
            $arrChannel = array();
            foreach($objDB as $obj){
                $objType = $this->getObjTypeById($obj->type);
                if(!$objType) continue;
                
                $objPCD =$this->getPdsChannelDailyObj($record_date,$objType->channel_id,$objType->sub_id,$objType->appid);
                $objPCD->week_active = $obj->nums;
                $objPCD->save();
            }
        }
        $this->fun_note("fun: fun_statistics_week_active end.");
    }

    // note
    public function fun_note($msg)
    {
        echo $msg.PHP_EOL;
    }

    // import
    public function fun_import()
    {
        Yii::import('system.extentions.com.models.*');
        Yii::import('system.extentions.com.models.project_data_log.*');
        Yii::import('system.extentions.com.models.project_data_centre.*');
    }

    public function getObjTypeById($type_id){
        static $objTypeArr=array();
        $type_id = (int)$type_id;
        if(!isset($objTypeArr[$type_id])){
            $objType = Pdc_type::model()->find("id = {$type_id}");
            if($objType){
                $objTypeArr[$type_id] = $objType;
            }else{
                return false;
            }
        }
        return $objTypeArr[$type_id];
    }

    public function getPdsChannelDailyObj($record_date,$channel_id,$sub_id,$app_id){
        $record_date = $record_date;
        $channel_id  = (int)$channel_id;
        $sub_id      = (int)$sub_id;
        $app_id      = (int)$app_id;
        $objPCD = Pds_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and sub_id = {$sub_id} and appid = {$app_id}");
        if(!$objPCD){
            $objPCD = new Pds_channel_daily();
            $objPCD->record_date    = $record_date;
            $objPCD->channel_id     = $channel_id;
            $objPCD->sub_id         = $sub_id;
            $objPCD->appid          = $app_id;
        }
        return $objPCD;
    }
    
    //统计指定日期到现在的点击量
    public function actionAllDateClickCount($begin_date = '2014-01-01 08:00:00'){
        $end_stamp  = time();
        for($time_stamp = strtotime($begin_date);$time_stamp<=$end_stamp;$time_stamp+=86400){
            $record_date = date('Y-m-d',$time_stamp);
            $this->actionCount_link_click($record_date);
            echo 'Click Count date:'.$record_date.' execute end'.PHP_EOL;
        }
    }

    //统计指定日期到现在的渠道数据
    public function actionAllDateChannelStatistics($begin_date = '2014-01-01 08:00:00'){
        $this->fun_import();
        $end_stamp  = time();
        for($time_stamp = strtotime($begin_date);$time_stamp<=$end_stamp;$time_stamp+=86400){
            $record_date = date('Y-m-d',$time_stamp);
            $this->fun_statistics_reg_user($record_date);
            $this->fun_statistics_new_run($record_date);
            $this->fun_count_link_click($record_date);
            $this->fun_count_login_2($record_date);
            $this->fun_count_week_active($record_date);
            echo 'Channel Statistics date:'.$record_date.' execute end'.PHP_EOL;
            sleep(1);
        }
    }
}