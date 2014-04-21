<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-4-10
 * Time: 下午2:50
 * To change this template use File | Settings | File Templates.
 */
class Pull_pdl_userCommand extends CConsoleCommand{
    private $apiUrl = 'http://fapi.patabom.com/fapi/get_user_reg_info';
    private $limit = 50;
    private $dataType = 'json';


    //拉取api接口user_log数据
    public function actionIndex(){
        echo "start pull user_reg_info,please Wait....\n";
        while(true){
            //查找断点
            $bid = MyFunction::getSetSync('pull_user_reg_info_bid');
            $realApiUrl = $this->apiUrl.'?bid='.$bid.'&limit='.$this->limit.'&type='.$this->dataType;
            $res = MyFunction::get_url($realApiUrl);
            if($res['code'] == '200'){
                $content = json_decode($res['content'],TRUE);
                if($content){
                    $content = $content['retData'];
                    if($content){
                        foreach($content as $c){
                            $objMachineInfo = new Pdl_user();
                            $objMachineInfo->id = $c['id'];
                            $objMachineInfo->imei = $c['imei'];
                            $objMachineInfo->account = $c['account'];
                            $objMachineInfo->password = $c['password'];
                            $objMachineInfo->ctime = $c['ctime'];
                            $objMachineInfo->type = $c['type'];
                            $objMachineInfo->main_id = $c['main_id'];
                            if( ! $objMachineInfo->save()){
                                echo 'save id'.$c['id'].'fail';
                                MyFunction::getSetSync('pull_user_reg_info_bid',$c['id']);
                                continue;
                            }
                            MyFunction::getSetSync('pull_user_reg_info_bid',$c['id']);
                            echo "saved id {$c['id']} \n";
                        }
                    }else{
                        echo 'pull user_reg_info complete!!',"\n";
                        break;
                    }
                }
            }else{
                echo 'pull user_reg_info error';
                exit;
            }
        }

    }
}