<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-15
 * Time: 上午9:50
 * To change this template use File | Settings | File Templates.
 */
class Pull_machine_infoCommand extends CConsoleCommand{
    private $apiUrl = 'http://fapi.patabom.com/fapi/get_machine_info';
    private $limit = 50;
    private $dataType = 'json';


    //拉取api接口user_log数据
    public function actionIndex(){
        echo "start pull machine_info,please Wait....\n";
        while(true){
            //查找断点
            $bid = MyFunction::getSetSync('pull_machine_info_bid');
            $realApiUrl = $this->apiUrl.'?bid='.$bid.'&limit='.$this->limit.'&type='.$this->dataType;
            $res = MyFunction::get_url($realApiUrl);
            if($res['code'] == '200'){
                $content = json_decode($res['content'],TRUE);
                if($content){
                    $content = $content['retData'];
                    if($content){
                        foreach($content as $c){
                            $objMachineInfo = new Pdl_machine();
                            $objMachineInfo->id = $c['id'];
                            $objMachineInfo->appid = $c['appid'];
                            $objMachineInfo->serverid = $c['serverid'];
                            $objMachineInfo->imei = $c['imei'];
                            $objMachineInfo->account = $c['account'];
                            $objMachineInfo->friendou = $c['friendou'];
                            $objMachineInfo->time = $c['time'];
                            $objMachineInfo->addtime = $c['addtime'];
                            $objMachineInfo->type = $c['type'];
                            $objMachineInfo->device = $c['device'];
                            $objMachineInfo->machineid = $c['machineid'];
                            $objMachineInfo->rowkey = $c['rowkey'];
                            if( ! $objMachineInfo->save()){
                                echo 'save id'.$c['id'].'fail';
                                MyFunction::getSetSync('pull_machine_info_bid',$c['id']);
                                continue;
                            }
                            MyFunction::getSetSync('pull_machine_info_bid',$c['id']);
                        }
                    }else{
                        echo 'pull machine_info complete!!',"\n";
                        break;
                    }
                }
            }else{
                echo 'pull machine_info error';
                exit;
            }
        }

    }

}
