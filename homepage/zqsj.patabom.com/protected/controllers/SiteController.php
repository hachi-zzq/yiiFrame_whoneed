<?php
/**
 * site
 *
 * @author		黑冰 <001.black.ice@gmail.com>
 * @copyright	Copyright 2014
 *
 */

class SiteController extends MyPageController
{
	// 首页
    public function actionIndex()
    {
        //新闻
        $objNews = Pdw_homepage_article::model()->findAll(array(
            'condition'=>'type in(35)',
            'limit'=>6,
            'order'=>'id DESC'
        ));

        //活动
        $objActive = Pdw_homepage_article::model()->findAll(array(
            'condition'=>'type in (36)',
            'limit'=>6,
            'order'=>'id DESC'
        ));

        //公告
        $objNotice = Pdw_homepage_article::model()->findAll(array(
            'condition'=>'type in(37)',
            'limit'=>6,
            'order'=>'id DESC'
        ));

        //球员展示
        $footballer = Pdw_homepage_game_thumb::model()->findAll(array(
            'condition'=>'type = 46',
            'order'=>'id DESC',
            'limit'=>10
        ));

        //游戏截图
        $gameThumb = Pdw_homepage_game_thumb::model()->findAll(array(
            'condition'=>'type=47',
            'order'=>'id DESC',
            'limit'=>4
        ));

        //合作媒体
        $cooperation = Pdw_homepage_game_thumb::model()->findAll(array(
            'condition'=>'type=57',
            'order'=>'id DESC',
            'limit'=>10
        ));
        $data['cooperation'] = $cooperation;
        $data['gameThumb'] = $gameThumb;
        $data['footballer'] = $footballer;
        $data['notices'] = $objNotice;
        $data['actives'] = $objActive;
        $data['news'] = $objNews;
        $data['pageTitle'] = '首页';
        $data['current'] = 'index';
        $data['seoInfo'] = HP::funGetIndexSeoInfo(3);
		$this->display('index',$data);
    }

    //最新列表页
    public function actionArticleList()
    {
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(35,36,37)";
        $cdb->order = 'id DESC';

        //page
        $count = Pdw_homepage_article::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);

        $objArticle = Pdw_homepage_article::model()->findAll($cdb);
        $data['objArticle'] = $objArticle;
        $data['pager'] = $pager;
        $data['pageTitle'] = '新闻公告';
        $data['fLink'] = '/';
        $data['linkName'] = '新闻公告';
        $data['Link'] = '/site/articleList';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(92);
        $this->display('article_list', $data);
    }

    //新闻列表
    public function actionNews($page=1){
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(35)";
        $cdb->order = 'id DESC';

        //page
        $count = Pdw_homepage_article::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(1);
        $pager->applyLimit($cdb);

        $objArticle = Pdw_homepage_article::model()->findAll($cdb);
        $data['objArticle'] = $objArticle;
        $data['pager'] = $pager;
        $data['pageTitle'] = '新闻';
        $data['fLink'] = '/';
        $data['linkName'] = '新闻';
        $data['Link'] = '/site/news';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(35);
        $this->display('news_list', $data);
    }

    //活动列表
    public function actionActive(){
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(36)";
        $cdb->order = 'id DESC';

        //page
        $count = Pdw_homepage_article::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);

        $objArticle = Pdw_homepage_article::model()->findAll($cdb);
        $data['objArticle'] = $objArticle;
        $data['pager'] = $pager;
        $data['pageTitle'] = '活动';
        $data['fLink'] = '/';
        $data['linkName'] = '活动';
        $data['Link'] = '/site/active';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(36);
        $this->display('active_list', $data);
    }

    //公告列表
    public function actionNotice(){
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(37)";
        $cdb->order = 'id DESC';

        //page
        $count = Pdw_homepage_article::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);

        $objArticle = Pdw_homepage_article::model()->findAll($cdb);
        $data['objArticle'] = $objArticle;
        $data['pager'] = $pager;
        $data['pageTitle'] = '公告';
        $data['fLink'] = '/';
        $data['linkName'] = '公告';
        $data['Link'] = '/site/notice';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(37);
        $this->display('notice_list', $data);
    }

    // 新闻详细页
    public function actionNewsDetail()
    {
        $id = Yii::app()->request->getParam('id');
        if( ! $id){
            exit('not found news');
        }
        $data = array();
        $objDetail = Pdw_homepage_article::model()->find("id='{$id}'");
        $data['objDetail'] = $objDetail;
        $data['pageTitle'] = '新闻详情';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('news_detail', $data);
    }


    //download
    public function actionDownload(){
        $data['pageTitle'] = '游戏下载';
        $data['current'] = 'download';

        $data['seoInfo'] = HP::funGetListSeoInfo(38);
        $this->display('download',$data);
    }


    //游戏资料
    public function actionGameInfo()
    {
       $type = 41;
       $data = array();
       $obj = Pdw_homepage_article::model()->findAll("type in ({$type})");
       $data['pageTitle'] = '游戏资料';
        $data['linkName'] = '游戏资料';
        $data['link'] = '/site/gameInfo';
        $data['game_info'] = $obj;
        $data['current'] = 'game_info';
        $data['seoInfo'] = HP::funGetListSeoInfo(41);
        $this->display('game_info',$data);
    }

    //game detail
    public function actionGameDetail(){
        $id = Yii::app()->request->getParam('id');
        if( ! $id){
            exit('not found id');
        }
        $data = array();
        $objDetail = Pdw_homepage_article::model()->find("id='{$id}'");
        $data['objDetail'] = $objDetail;
        $data['linkName'] = '游戏资料';
        $data['link'] = '/site/gameInfo';
        $data['pageTitle'] = '游戏资料';
        $data['current'] = 'game_info';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('game_detail', $data);
    }

    //游戏攻略
    public function actionGuider(){
        $type = 42;
        $data = array();
        $obj = Pdw_homepage_article::model()->findAll("type in ({$type})");
        $data['pageTitle'] = '游戏攻略';
        $data['linkName'] = '游戏攻略';
        $data['link'] = '/site/guider';
        $data['game_info'] = $obj;
        $data['current'] = 'guider';
        $data['seoInfo'] = HP::funGetListSeoInfo(42);
        $this->display('game_info',$data);
    }

    public function actionCustomer(){
        //联系客服
        $objCall = Pdw_homepage_archives::model()->find('id=48');
        //下载问题
        $objDownloadQuestion = Pdw_homepage_article::model()->findAll('type in(49)');
        //安装问题
        $objInstallQuestion = Pdw_homepage_article::model()->findAll('type in(50)');
        //账号问题
        $objAccountQuestion = Pdw_homepage_article::model()->findAll('type in(51)');

        //安全问题
        $objSafeQuestion = Pdw_homepage_article::model()->findAll('type in(52)');

        //用户协议
        $objUserQuestion = Pdw_homepage_article::model()->findAll('type in(53)');

        //充值问题
        $objRechargeQuestion = Pdw_homepage_article::model()->findAll('type in(54)');

        //客户端问题
        $objKeQuestion = Pdw_homepage_article::model()->findAll('type in(55)');

        //登入运行问题
        $objRunQuestion = Pdw_homepage_article::model()->findAll('type in(56)');

        $data['objCall'] = $objCall;
        $data['objDown'] = $objDownloadQuestion;
        $data['install'] = $objInstallQuestion;
        $data['account'] = $objAccountQuestion;
        $data['safe'] = $objSafeQuestion;
        $data['user'] = $objUserQuestion;
        $data['recharge'] = $objRechargeQuestion;
        $data['ke'] = $objKeQuestion;
        $data['run'] = $objRunQuestion;
        $data['pageTitle'] = '客服中心';
        $data['current'] = 'customer';
        $data['seoInfo'] = HP::funGetListSeoInfo(91);
        $this->display('customer',$data);
    }

    //game thumb
    public function actionGameThumb($page=1){
        $cdb = new CDbCriteria();
        $cdb->condition = "type = 47";
        $cdb->order = "id DESC";
        $count = Pdw_homepage_game_thumb::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(6);
        $pager->applyLimit($cdb);
        //游戏截图
        $gameThumb = Pdw_homepage_game_thumb::model()->findAll($cdb);

        $data['gameThumb'] = $gameThumb;
        $data['pager'] = $pager;
        $data['pageTitle'] = '游戏截图';
        $data['seoInfo'] = HP::funGetListSeoInfo(47);
        $this->display('game_thumb',$data);
    }

    //footballer
    public function actionFootballer($page=1){
        $cdb = new CDbCriteria();
        $cdb->condition = "type = 46";
        $cdb->order = "id DESC";

        $count = Pdw_homepage_game_thumb::model()->count($cdb);

        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(4);
        $pager->applyLimit($cdb);
        
        //球员展示
        $footballer = Pdw_homepage_game_thumb::model()->findAll($cdb);
        $data['footballer'] = $footballer;
        $data['pager'] = $pager;
        $data['pageTitle'] = '球员展示';
        $data['seoInfo'] = HP::funGetListSeoInfo(46);
        $this->display('footballer',$data);
    }


    //about us
    public function actionAboutUs(){
        $objAbout = Pdw_homepage_archives::model()->find('id=58');
        $data['about'] = $objAbout;
        $data['pageTitle'] = '关于我们';
        $data['linkName'] = '关于我们';
        $data['link'] = '/site/aboutUs';
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(58);
        $this->display('about_us',$data);
    }

    //job
    public function actionJob(){
        $type = 61;
        $data = array();
        $cdb = new CDbCriteria();
        $cdb->condition = "type in ({$type})";
        $cdb->order = "id desc";
        $obj = Pdw_homepage_article::model()->findAll($cdb);
        $data['pageTitle'] = '加入我们';
        $data['linkName'] = '加入我们';
        $data['link'] = '/site/job';
        $data['game_info'] = $obj;
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(61);
        $this->display('game_info',$data);
    }

    //coo合作洽谈
    public function actionCoop(){
        $objAbout = Pdw_homepage_archives::model()->find('id=60');
        $data['about'] = $objAbout;
        $data['pageTitle'] = '合作洽谈';
        $data['current'] = 'news';
        $data['linkName'] = '合作洽谈';
        $data['link'] = '/site/coop';
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(60);
        $this->display('about_us',$data);
    }

    //联系我们
    public function actionContact(){
        $objAbout = Pdw_homepage_archives::model()->find('id=62');
        $data['about'] = $objAbout;
        $data['pageTitle'] = '联系我们';
        $data['linkName'] = '联系我们';
        $data['link'] = '/site/contact';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(62);
        $this->display('about_us',$data);
    }
}
?>
