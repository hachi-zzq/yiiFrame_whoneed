<?php
/**
 * pay log info 拉取
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2014
 *
 */
class Pull_payCommand extends CConsoleCommand
{
    public function actionGet_pay_info()
    {
        $time = time() - 2*60*60;
        $url = 'http://fapi.patabom.com/fapi/get_pay_info?time='.$time;

        echo "get the pay info ...\t\n";

        $arr =  MyController::get_url($url);                                                                    
        if($arr['code'] == 200){
            $arrResult = json_decode($arr['content'], true);
            if($arrResult['retCode'] === 0 && $arrResult['retData']){
                foreach($arrResult['retData'] as $arrData)
                {
                    // step1: check is ok
                    if(!$arrData['is_pay_ok']) continue;

                    // step2: check is exist
                    $oid = $arrData['id'];
                    $objDB = Pdl_order::model()->find("oid = {$oid}");
                    if($objDB) continue;

                    // step3: input the table
                    $objDB = new Pdl_order();
                    $objDB->oid                 = $arrData['id'];
                    $objDB->order_id            = $arrData['order_id'];
                    $objDB->user_id             = $arrData['user_id'];
                    $objDB->is_test             = $arrData['is_test'];
                    $objDB->channel             = $arrData['channel'];
                    $objDB->money               = $arrData['money'];
                    $objDB->gcoins              = $arrData['gcoins'];
                    $objDB->ctime               = $arrData['ctime'];
                    $objDB->pay_type            = $arrData['pay_type'];
                    $objDB->proxy_channel_id    = $arrData['proxy_channel_id'];
                    $objDB->channel_type        = $arrData['channel_type'];
                    $objDB->pay_order_code      = $arrData['pay_order_code'];
                    $objDB->trade_name          = $arrData['trade_name'];
                    $objDB->pay_order_id        = $arrData['pay_order_id'];
                    $objDB->game_order_id       = $arrData['game_order_id'];
                    $objDB->pay_time            = $arrData['pay_time'];
                    $objDB->is_pay_ok           = $arrData['is_pay_ok'];
                    $objDB->app_id              = $arrData['app_id'];
                    $objDB->is_send             = $arrData['is_send'];
                    $objDB->custom_param        = $arrData['custom_param'];
                    $objDB->save();

                    echo "do id: {$oid}; \t\n";
                }
            }
        }

        echo "get the pay info end. \t\n";
    }
}
