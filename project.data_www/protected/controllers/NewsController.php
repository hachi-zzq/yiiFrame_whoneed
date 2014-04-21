<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-17
 * Time: 下午3:06
 * To change this template use File | Settings | File Templates.
 */
class NewsController extends MyPageController{

    //index
    public function actionIndex($page=1){
        $criteria =  new CDbCriteria();
        $criteria->order = 'create_time desc';
        $count = Pdw_news::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->setPageSize(NEWS_PRE_PAGESIZE);
        $pager->applyLimit($criteria);
        $newsList = Pdw_news::model()->findAll(array(
            'order'=>'id desc',
            'limit'=>$pager->getPageSize(),
            'offset'=>$pager->getPageSize()*($page-1)
        ));
        $this->renderPartial('index',array(
            'page'=>$pager,
            'newsList'=>$newsList,
            'pageTitle'=>'新闻公告',
            'current'=>'news'
        ));

    }





}