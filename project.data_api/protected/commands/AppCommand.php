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
    public function actionGetAppInfo()
    {
        echo "get the app info ...\t\n";
        $url = 'http://stat.haoyoudou.net/api/v1/index.php?mtd=Api::getAppInfo';
        $arr =  MyController::get_url($url);                                                                    
        $arrResult = json_decode($arr['content'], true);
        if($arrResult['data']){
            foreach($arrResult['data'] as $data){
                $objDB = Pdc_app::model()->find("appid = '{$data['appid']}'");
                if(!$objDB){
                    $objDB = new Pa_app();
                    $objDB->appid = $data['appid'];
                    $objDB->appname = '';
                }

                if($objDB->appname != $data['name']){
                    $objDB->appname = $data['name'];
                    $objDB->save();
                }
            }
        }
        echo 'app info done'."\t\n";
    }
}
?>
