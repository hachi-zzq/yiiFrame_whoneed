<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-19
 * Time: 上午10:03
 * To change this template use File | Settings | File Templates.
 */
class CustomerController extends MyPageController{

    public function actionIndex(){
        $data['pageTitle'] = '客服中心';
        $data['current'] = 'customer';
        $this->renderPartial('index',$data);
    }


}