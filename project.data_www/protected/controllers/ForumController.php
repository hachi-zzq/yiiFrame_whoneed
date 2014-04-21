<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-20
 * Time: 下午5:25
 * To change this template use File | Settings | File Templates.
 */
class ForumController extends MyPageController{

    //
    public function actionIndex(){
        $data['current'] = 'forum';
        $data['pageTitle'] = '论坛';
        $this->renderPartial('index',$data);
    }


}