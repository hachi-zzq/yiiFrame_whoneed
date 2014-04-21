<?php
class ArticleController extends MyPageController{

    //index
    public function actionIndex(){
;

    }

    //article list
    public function actionArticleList($page=1){
        $data = $this->articleList($page,'67,68,69','/article/newsDetail','新闻中心','/article/articleList','news','all');
        $data['seoInfo'] = HP::funGetListSeoInfo(93);
        $this->display('news_list',$data);
    }

    //newslist
    public function actionNewsList($page=1){
        $data = $this->articleList($page,67,'/article/newsDetail','新闻中心','/article/newsList','news','news');
        $data['seoInfo'] = HP::funGetListSeoInfo(67);
        $this->display('news_list',$data);
    }

    //active list
    public function actionActiveList($page=1){
        $data = $this->articleList($page,69,'/article/newsDetail','活动中心','/article/activeList','news','active');
        $data['seoInfo'] = HP::funGetListSeoInfo(69);
        $this->display('news_list',$data);
    }
    //notice list
    public function actionNoticeList($page=1){
        $data = $this->articleList($page,68,'/article/newsDetail','公告中心','/article/noticeList','news','notice');
        $data['seoInfo'] = HP::funGetListSeoInfo(68);
        $this->display('news_list',$data);
    }

    //game info
    public function actionGameInfo($page=1){
        $data = $this->articleList($page,71,'/article/gameDetail','游戏介绍','/article/gameInfo','game_info','');
        $data['none_news_nav'] = 1;
        $data['seoInfo'] = HP::funGetListSeoInfo(71);
        $this->display('news_list',$data);
    }

    //job
    public function actionJob($page=1){
        $data = $this->articleList($page,70,'/article/gameDetail','加入我们','/article/job','news','');
        $data['none_news_nav'] = 1;
        $data['seoInfo'] = HP::funGetListSeoInfo(70);
        $this->display('news_list',$data);
    }

    //game detail
    /*
     *
     * linkName,链接名称
     * link,链接地址
     * current,用于控制nav高亮
     */
    public function articleList($page=1,$type='',$detailLink = '#',$linkName='',$link='#',$current='index',$news_nav='all'){
        $cdb = new CDbCriteria();
        $cdb->addCondition("type in ({$type})");
        $cdb->order = "id DESC";
        $count = Pdw_homepage_article::model()->count($cdb);
        //pager
        $pager = new CPagination($count);
        $pager->setCurrentPage($page-1);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);
        $obj = Pdw_homepage_article::model()->findAll($cdb);
        $data['news'] = $obj;
        $data['link'] = $link;
        $data['detailLink'] = $detailLink;
        $data['linkName'] = $linkName;
        $data['current'] = $current;
        $data['news_nav'] = $news_nav;
        $data['pager'] = $pager;
        return $data;
    }

    //通用news_detail
    public function actionNewsDetail(){
        $id = intval(Yii::app()->request->getParam('id'));
        if( ! $id)
            die('id is not found');
        $data = $this->returnDetail($id,'/article/articleList','新闻中心','news');
        $this->display('news_detail',$data);
    }

    //gameDetail
    public function actionGameDetail(){
        $id = intval(Yii::app()->request->getParam('id'));
        if( ! $id)
            die('id is not found');
        $data = $this->returnDetail($id,'/article/gameInfo','游戏介绍','game_info');
        $this->display('news_detail',$data);
    }

    //return detail
    public function returnDetail($id='',$link='#',$linkName='',$current='news'){
        $objNews = Pdw_homepage_article::model()->find("id='{$id}'");
        $content = Pdw_homepage_article_content::model()->find("id='{$id}'")->intro;
        $arrRet = array();
        if($objNews){
            $arrRet['title'] = $objNews->title;
            $arrRet['author'] = $objNews->author;
            $arrRet['time'] = $objNews->submit_date;
            $arrRet['content'] = $content;
        }
        $data['res'] = $arrRet;
        $data['link'] = $link;
        $data['linkName'] = $linkName;
        $data['current'] = $current;
        $data['seoInfo'] = HP::funGetArticleSeoInfo($id);
        return $data;
    }



}