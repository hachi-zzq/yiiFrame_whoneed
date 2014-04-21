<?php
/**
 * 渠道统计
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2013
 *
 */
class ChannelCommand extends CConsoleCommand
{

    public function actionTest()
    {
        echo 'This is test!'."\t\n";
    }

    // friendou data update interface
    public function actionFriendouUpdateInterface()
    {
        $this->funFriendouUpdateInterface();
    }

    public function funFriendouUpdateInterface($strTime = '')
    {
        // init
        $preUrl     = 'http://stat.haoyoudou.net/api/v1/index.php'; // the interface domain
        $channel_id = 0;
        $appid      = 0;

        // default current time
        if(empty($strTime)){
            $strTime = time();
        }

        // format the date
        $day         = date('Ymd',      $strTime);
        $record_date = date('Y-m-d',    $strTime);
        echo 'date:'.$record_date."; day:{$day}; running ...\t\n";

        // get the success install nums
        echo "get the success install nums ... \t\n";
        $data = array();
        $data = $this->funGetFriendouContent('Api::getInstall', $day);
        if($data){
            foreach($data as $arrData){
                $appid = $arrData['appid'];
                $objDB = Pds_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and appid = {$appid}");
                if(!$objDB){
                    $objDB = new Pds_channel_daily();
                    $objDB->record_date = $record_date;
                    $objDB->channel_id  = $channel_id;
                    $objDB->appid       = $appid;
                    $objDB->install_nums= 0; 
                }
                $objDB->install_nums = $arrData['android'] + $arrData['iphone'] + $arrData['winphone'];
                $objDB->save();
            }
        }

        // get the new add users
        echo "get the new add users ... \t\n";
        $data = array();
        $data = $this->funGetFriendouContent('Api::getNewUser', $day);
        if($data){
            foreach($data as $arrData){
                $appid = $arrData['appid'];
                $objDB = Pds_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and appid = {$appid}");
                if(!$objDB){
                    $objDB = new Pds_channel_daily();
                    $objDB->record_date = $record_date;
                    $objDB->channel_id  = $channel_id;
                    $objDB->appid       = $appid;
                    $objDB->new_users   = 0; 
                }
                $objDB->new_users = $arrData['total'];
                $objDB->save();
            }
        }     

        // get the run nums
        echo "get the run nums ... \t\n";
        $data = array();
        $data = $this->funGetFriendouContent('Api::getopenuser', $day);
        if($data){
            foreach($data as $arrData){
                $appid = $arrData['appid'];
                $objDB = Pds_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and appid = {$appid}");
                if(!$objDB){
                    $objDB = new Pds_channel_daily();
                    $objDB->record_date = $record_date;
                    $objDB->channel_id  = $channel_id;
                    $objDB->appid       = $appid;
                    $objDB->run_nums    = 0; 
                }
                $objDB->run_nums = $arrData['count'];
                $objDB->save();
            }
        }       

        // get the actives nums
        echo "get the actives nums ... \t\n";
        $data = array();
        $data = $this->funGetFriendouContent('Api::getactiveuser', $day);
        if($data){
            foreach($data as $arrData){
                $appid = $arrData['appid'];
                $objDB = Pds_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and appid = {$appid}");
                if(!$objDB){
                    $objDB = new Pds_channel_daily();
                    $objDB->record_date = $record_date;
                    $objDB->channel_id  = $channel_id;
                    $objDB->appid       = $appid;
                    $objDB->active_nums = 0; 
                    $objDB->login_users = 0;
                }
                $objDB->active_nums = $arrData['count'];
                $objDB->login_users = $arrData['count'];
                $objDB->save();
            }
        }   

        // get the reg users nums
        echo "get the reg users nums ... \t\n";
        /*
        $data = array();
        $data = $this->funGetFriendouContent('Api::getreguser', $day);
        print_r($data);
        /*
        if($data){
            foreach($data as $arrData){
                $appid = $arrData['appid'];
                $objDB = Pa_st_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and appid = {$appid}");
                if(!$objDB){
                    $objDB = new Pa_st_channel_daily();
                    $objDB->record_date = $record_date;
                    $objDB->channel_id  = $channel_id;
                    $objDB->appid       = $appid;
                    $objDB->active_nums = 0; 
                }
                $objDB->active_nums = $arrData['count'];
                $objDB->save();
            }
        }  */       

        // get the pay amount nums
        echo "get the pay amount nums ... \t\n";
        $data = array();
        $data = $this->funGetFriendouContent('Api::getPayCharge', $day);
        if($data){
            foreach($data as $arrData){
                $appid = $arrData['appid'];
                $objDB = Pds_channel_daily::model()->find("record_date = '{$record_date}' and channel_id = {$channel_id} and appid = {$appid}");
                if(!$objDB){
                    $objDB = new Pds_channel_daily();
                    $objDB->record_date = $record_date;
                    $objDB->channel_id  = $channel_id;
                    $objDB->appid       = $appid;
                    $objDB->pay_amount  = 0; 
                }
                $objDB->pay_amount = $arrData['mtotal'];
                $objDB->save();
            }
        }       
    }

    // get friendou content by interface
    public function funGetFriendouContent($func, $day, $appid = null)
    {
        if(!$func || !$day){
            echo 'the param error!';
            exit;
        }

        $url = 'http://stat.haoyoudou.net/api/v1/index.php?mtd='.$func.'&day='.$day;
        if($appid)
        {
            $url .= '&appid='.$appid;
        }

        $arr =  MyController::get_url($url);                                                                    
        $arrResult = json_decode($arr['content'], true);

        if(isset($arrResult['data'])){
            return  $arrResult['data'];
        }else{
            return;
        }
    }
}
