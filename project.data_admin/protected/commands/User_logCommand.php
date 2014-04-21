<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-15
 * Time: 上午9:50
 * To change this template use File | Settings | File Templates.
 */
class User_logCommand extends CConsoleCommand{
    private $apiUrl = 'http://fapi.patabom.com/fapi/get_user_info';
    private $maxId = 0;                     //记录每次获取的最大id
    private $bid = 0;
    private $limit = 100;
    private $dataType = 'json';


    //拉取api接口user_log数据
    public function actionIndex(){
        echo "\tstart pull user_log,please Wait....\n\t";
        while(true){
            //查找断点
            $seek_bid_sql = "select ope_value from pdl_sync where ope_key='shell_pull_user_info_bid'order by id DESC limit 1";
            $one = Yii::app()->db_data_log->createCommand($seek_bid_sql)->queryRow();
            //保存断点
            $this->bid = !empty($one)?$one['ope_value']:'0';
            //查找断点结束

            $realApiUrl = $this->apiUrl.'?bid='.$this->bid.'&limit='.$this->limit.'&type='.$this->dataType;
            try{
                $retrunData = file_get_contents($realApiUrl);
                if($this->dataType == 'json'){
                    $obj = json_decode($retrunData);
                    if($obj->retCode == 0){
                        if($obj->retData){
                            //插入数据
                            if($this->userInfoInsert($obj->retData)){
                                //开始记录断点，也就是下次的bid保存到数据库中
                                $this->saveSync();
                                echo "saved id: $this->maxId\n\t";
                            }else{
                                break;
                            }
                        }else{
                            echo "pull user_log complete!!\n\t";
                            break;
                        }
                    }else{
                        $this->saveException('shell_pull_user_info',__FILE__,__LINE__,addslashes('错误信息：RetCode != 0'));
                        echo "pull user_log complete!! some error was found!! \n";
                        break;
                    }
                }

            }catch (Exception $e){
                $this->saveException('shell_pull_user_info',__FILE__,__LINE__,addslashes($e->getMessage()));
                echo "pull user_log complete!! some error was found!! \n";
            }
        }


    }


    //插入表中
    public function userInfoInsert($obj){
        if(isset($obj)){
            $arrTem[1] = array();
            $arrTem[2] = array();
            $arrTem[3] = array();
            $arrTem[4] = array();
            $arrTem[5] = array();
            $arrTem[6] = array();
            foreach($obj as $v){
                $id = $v->id;
                $appid = $v->appid;
                $serverid = $v->serverid;
                $imei = $v->imei;
                $account = $v->account;
                $friendou = $v->friendou;
                $time = $v->time;
                $addtime = $v->addtime;
                $type = $v->type;
                $device = $v->device;
                $machineid = $v->machineid;
                $rowkey = $v->rowkey;
                $fromtype = $v->fromtype;
                $sql_body="('$id','$appid','$serverid','$imei','$account','$friendou','$time','$addtime','$device','$machineid','$rowkey','$fromtype')";
                //保存maxId
                $this->maxId = $id>$this->maxId?$id:$this->maxId;
                //value     后面字串进战
                array_push($arrTem[$type],$sql_body);
            }
//            print_r($arrTem);
            $newArr = array();
            foreach($arrTem as $v){
                $str = implode(',',$v);
                array_push($newArr,$str);
            }
//            print_r($newArr);
            try{
                //尝试插入
                foreach($newArr as $key=>&$new){
                    $key = $key+1;
                    $sql_before = "replace into pdl_user_log_$key(id,appid,serverid,imei,account,friendou,time,addtime,device,machineid,rowkey,fromtype) values ";
                    if(!empty($new)){
                        $new = $sql_before.$new;
                        //循环插入数据
                        Yii::app()->db_data_log->createCommand($new)->execute();
                    }
                }
                $reseultCode = '1';
            }catch (Exception $e){
//                echo $e->getMessage();
                //开始保存异常
                $this->saveException('shell_insert_user_info',__FILE__,__LINE__,addslashes($e->getMessage()));
                $reseultCode = '0';
            }
        }
        return $reseultCode;
    }

    //记录异常信息，插入pdl_exception_log
    public function saveException($exception_key,$exception_file,$exception_dot,$exception_content){
        $exception_time = date('Y-m-d H:i:s');
        $sql_exception = "insert into pdl_exception_log (exception_key,file_name,exception_dot,content,exception_time) values ('$exception_key','$exception_file','$exception_dot','$exception_content','$exception_time')";
        Yii::app()->db_data_log->createCommand($sql_exception)->execute();
    }



    //记录断点，插入pdl_sync
    public function saveSync(){
        $end_bid = $this->maxId;
        $if_exist = "select id from pdl_sync where ope_key = 'shell_pull_user_info_bid'";
        if(Yii::app()->db_data_log->createCommand($if_exist)->queryRow()){
            $sql_sync = "update pdl_sync set ope_value=$end_bid where ope_key = 'shell_pull_user_info_bid'";
            Yii::app()->db_data_log->createCommand($sql_sync)->execute();
        }else{
            $sql_sync = "insert into pdl_sync (ope_key,ope_value) values ('shell_pull_user_info_bid','$end_bid')";
            Yii::app()->db_data_log->createCommand($sql_sync)->execute();
        }

    }


}
