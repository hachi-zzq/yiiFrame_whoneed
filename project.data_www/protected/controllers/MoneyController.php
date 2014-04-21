<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-20
 * Time: 下午5:25
 * To change this template use File | Settings | File Templates.
 */
class MoneyController extends MyPageController{

    //充值
    public function actionIndex(){
        $data['pageTitle'] = '充值';
        $data['current'] = 'money';
        $this->renderPartial('index',$data);
    }


}