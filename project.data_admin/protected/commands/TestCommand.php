<?php
/**
 * pay log info 拉取
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2014
 *
 */
class TestCommand extends CConsoleCommand
{
    public function actionTest()
    {
        echo "do test; \t\n";

        try{
            // step1: connect ssdb
            $host = Yii::app()->params['SSDB']['host'];
            $port = Yii::app()->params['SSDB']['port'];
        
            $ssdb = new SimpleSSDB($host, $port);

            // step2: check open log by step 1
            //$ssdb->set('test1', 1);
            //$ssdb->set('test2', 2);

            echo $ssdb->get('test1').'_'.$ssdb->get('test2')."\t\n";

        }catch(Exception $e){
            die(__LINE__ . ' ' . $e->getMessage());
        }

        echo "do test ok; \t\n";
    }

    public function actionTest_user_run()
    {
        echo "begin:\t\n";
        $host = Yii::app()->params['SSDB']['host'];
        $port = Yii::app()->params['SSDB']['port'];

        try{
            $ssdb = new SimpleSSDB($host, $port);
        }catch(SSDBException $e){
            die(__LINE__ . ' ' . $e->getMessage());
        }

        $i = 0;
        $id = 0;
        while(true){
            $sql = "SELECT id,appid,serverid,imei,device,addtime FROM pdl_user_log_1 where id > {$id} ORDER BY id ASC LIMIT 1000";
            $arrData = Yii::app()->db_data_log->createCommand($sql)->queryAll();
            if($arrData){
                foreach($arrData as $data){
                    $id = $data['id'];
                    echo "do id:".$id."\t\n";
                    $uniqueStr = $data['imei'].'_'.$data['serverid'].'_'.$data['appid'].'_02';
                    //$uniqueStr = $data['imei'].'_02';
                    //memcache
                    if($ssdb->get($uniqueStr)){
                        echo 'isexist'."\t\n";
                        continue;
                    }else{
                        if($data['serverid'] == 48 and $data['addtime'] >= 1393632000 and $data['addtime'] <= 1395100799){
                            $i++;
                        }
                        $ssdb->set($uniqueStr,1);
                    }
                }
            }else{
                break;
            }
        }
        echo "总数为：{$i} ;\t\n";
        echo "end.\t\n";
    }
}
