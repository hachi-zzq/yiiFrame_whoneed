<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-20
 * Time: 下午5:25
 * To change this template use File | Settings | File Templates.
 */
class ActivityController extends MyPageController{

    //
    public function actionIndex(){
        $data['pageTitle'] = '活动';
        $data['current'] = 'active';
        $this->renderPartial('index',$data);
    }
}