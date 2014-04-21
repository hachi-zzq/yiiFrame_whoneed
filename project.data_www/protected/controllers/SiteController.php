<?php
/**
 * 缃戠珯鍓嶇棣栭〉
 *
 * @author		瀣寸泭铏� <Yingyh@whoneed.com>
 * @copyright	Copyright 2012
 *
 */

class SiteController extends MyPageController
{
	// 棣栭〉
	public function actionIndex(){
        $game = Pdw_games::model();
        $cbd = new CDbCriteria();
        $cbd->select = 'id,title,status,homepage_url,img_thumb';
        $cbd->order = 'create_time desc';
        $cbd->addCondition("img_thumb !=''");
        $cbd->limit = 8;
        $data['game_list'] = $game->findAll($cbd);
        $data['pageTitle'] = '首页';
        $data['current'] = 'index';
        //load main
        $this->renderPartial('index',$data);
	}

    //姓名预测游戏
     public function actionNameGame(){
         if(Yii::app()->request->isPostRequest){
                $name = trim(Yii::app()->request->getParam('user_name'));
                 $py = MyUsePinyin::Pinyin($name);
                 $sum = 0;
                 for($i=0;$i<strlen($py);$i++){
                     $sum += ord($py[$i]);
                 }
                 $key = intval($sum%10);
                if($obj = Pdw_forecast_game::model()->find("name_key=$key"))
                    echo $obj->value;
                 else
                     echo 1;
         }
         $this->renderPartial('name_game',array('name'=>$name));
     }
}
?>