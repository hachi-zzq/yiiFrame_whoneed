<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-20
 * Time: 下午5:25
 * To change this template use File | Settings | File Templates.
 */
class MallController extends MyPageController{

    //
    public function actionIndex(){
        $data['pageTitle'] = '商城';
        $data['current'] = 'mall';
        $this->renderPartial('index',$data);
    }


}