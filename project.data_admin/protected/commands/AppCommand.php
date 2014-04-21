<?php
/**
 * App 拉取
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2013
 *
 */
class AppCommand extends CConsoleCommand
{
    //get all app info or update app info
    public function actionGet_app_info()
    {
        echo "get the app info ...\t\n";

        $bid    = 0;
        $limit  = 100;
        while(true)
        {
            $url = $this->Get_app_info_url($bid, $limit);
            $arr =  MyController::get_url($url);                                                                    
            if($arr['code'] == 200){
                $arrResult = json_decode($arr['content'], true);
                if($arrResult['retCode'] === 0 && $arrResult['retData']){
                    foreach($arrResult['retData'] as $data){
                        $objDB = Pdc_app::model()->find("appid = '{$data['ID']}'");
                        if(!$objDB){
                            $objDB = new Pdc_app();
                            $objDB->appid       = $data['ID'];
                            $objDB->appname     = $data['NAME'];
                            $objDB->appkey      = $data['APPKEY'];
                            $objDB->add_time    = $data['ADDTIME'];
                            $objDB->update_time = '';
                        }

                        if($objDB->update_time != $data['UPDATETIME']){
                            $objDB->appname     = $data['NAME'];
                            $objDB->update_time = $data['UPDATETIME'];
                            $objDB->save();

                            echo "save id : ".$data['ID']. "\t\n" ;
                        }

                        $bid = $data['ID'];
                    }
                }else{
                    break;
                }
            }else{
                break;
            }
        }

        echo 'app info done'."\t\n";
    }

    // inner function
    // get fapi url
    public function Get_app_info_url($bid = 0, $limit = 100)
    {
        $time = time();

        $strUrl = 'http://fapi.patabom.com/fapi/get_app_info';
        $strUrl.= '?bid='.$bid;
        $strUrl.= '&limit='.$limit;
        $strUrl.= '&time='.$time;
        $strUrl.= '&sign='.md5($bid.'_'.$limit.'_'.$time.'_'.'suzhoujiju@friend!@#');

        return $strUrl;
    }
}
?>
