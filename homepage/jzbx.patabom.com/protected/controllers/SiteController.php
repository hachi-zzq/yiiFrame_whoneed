<?php
class SiteController extends MyPageController{

    //index
    public function actionIndex(){
        $objNews = $this->getIndexNews(67);
        $objNotice = $this->getIndexNews(68);
        $objActive = $this->getIndexNews(69);
        $objCoo = Pdw_homepage_game_thumb::model()->findAll(array(
            'condition'=>'type=87',
            'limit'=>10
        ));
        $objThumb = Pdw_homepage_game_thumb::model()->findAll(array(
            'condition'=>'type=88',
            'limit'=>4
        ));
        $data['thumb'] = $objThumb;
        $data['news'] =  $objNews;
        $data['notices'] =  $objNotice;
        $data['actives'] =  $objActive;
        $data['current'] = 'index';
        $data['coo'] = $objCoo;
        $data['seoInfo'] = HP::funGetIndexSeoInfo(4);
        $this->display('index',$data);
    }


    public function getIndexNews($type = ''){
        $objNews = Pdw_homepage_article::model()->findAll(array(
            'condition'=>"type = '{$type}'",
            'limit'=>6,
            'order'=>'recommendflag DESC,id DESC'
        ));
            return $objNews;
    }
}