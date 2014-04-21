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
        $type = '17,21,24';
        //最新
        $cdb = new CDbCriteria();
        $cdb->condition = "type in({$type}) and status=1";
        $cdb->select = 'id,title,type,submit_date';
        $cdb->order = 'id desc';
        $cdb->limit = 4;

        $objNewArticle = Pdw_homepage_article::model()->findAll($cdb);
        //news
        $objNews = Pdw_homepage_article::model()->findAll(array(
            'condition'=>"type in (17)",
            'order'=>'id DESC',
            'limit'=>4
        ));

        //active
        $objActive = Pdw_homepage_article::model()->findAll(array(
            'condition'=>"type in (24)",
            'order'=>'id DESC',
            'limit'=>4
        ));

        //notice
        $objNotice = Pdw_homepage_article::model()->findAll(array(
            'condition'=>"type in (21)",
            'order'=>'id DESC',
            'limit'=>4
        ));
        $data['objNewArticle'] = $objNewArticle;
        $data['objNews'] = $objNews;
        $data['objActive'] = $objActive;
        $data['objNotice'] = $objNotice;
        $data['pageTitle'] = '首页';
        $data['current'] = 'index';
        $data['seoInfo'] = HP::funGetIndexSeoInfo(2);
		$this->display('index', $data);
    }

    //最新列表页
    public function actionArticleList()
    {
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(17,21,24)";
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
        $data['tLink'] = '/site/articleList';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(90);
        $this->display('article_list', $data);
    }

    //新闻列表
    public function actionNews($page=1){
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(17)";
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
        $data['pageTitle'] = '新闻';
        $data['fLink'] = '/';
        $data['tLink'] = '/site/news';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(17);
        $this->display('news_list', $data);
    }

    //活动列表
    public function actionActive(){
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(24)";
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
        $data['tLink'] = '/site/active';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(24);
        $this->display('active_list', $data);
    }

    //公告列表
    public function actionNotice(){
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(21)";
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
        $data['tLink'] = '/site/notice';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(21);
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
        $data['current'] = 'download';
        $data['pageTitle'] = '下载中心';
        $data['seoInfo'] = HP::funGetListSeoInfo(18);
        $this->display('game_download',$data);
    }

    //customer
    public function actionCustomer(){
        //联系客服
        $objCall = Pdw_homepage_archives::model()->find('id=33');
        //下载问题
        $objDownloadQuestion = Pdw_homepage_article::model()->findAll('type in(25)');
        //安装问题
        $objInstallQuestion = Pdw_homepage_article::model()->findAll('type in(26)');
        //账号问题
        $objAccountQuestion = Pdw_homepage_article::model()->findAll('type in(27)');

        //安全问题
        $objSafeQuestion = Pdw_homepage_article::model()->findAll('type in(28)');

        //用户协议
        $objUserQuestion = Pdw_homepage_article::model()->findAll('type in(29)');

        //充值问题
        $objRechargeQuestion = Pdw_homepage_article::model()->findAll('type in(30)');

        //客户端问题
        $objKeQuestion = Pdw_homepage_article::model()->findAll('type in(31)');

        //登入运行问题
        $objRunQuestion = Pdw_homepage_article::model()->findAll('type in(32)');

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
        $data['seoInfo'] = HP::funGetListSeoInfo(20);
        $this->display('customer',$data);
    }

    //游戏资料
    public function actionGameInfo()
    {
        $page = Yii::app()->request->getParam('page');
        $cdb = new CDbCriteria();
        $cdb->condition = "type in(19)";
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
        $data['pageTitle'] = '游戏资料';
        $data['link'] = '/site/notice';
        $data['linkName'] = '游戏资料';
        $data['current'] = 'game_info';
        $data['seoInfo'] = HP::funGetListSeoInfo(19);
        $this->display('game_info', $data);
    }

    //游戏资料详情页
    public function actionGameDetail(){
        $data = array();
        $id = Yii::app()->request->getParam('id');
        $guiderDetail = Pdw_homepage_article::model()->find("id='{$id}'");
        $data['guider_detail'] = $guiderDetail;
        $data['fLink'] = '/';
        $data['tLink'] = '/site/guider';
        $data['pageTitle'] = '游戏资料';
        $data['current'] = 'game_info';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('game_detail',$data);
    }

    //游戏攻略
     public function actionGuider(){
        $data = array();
         $objGuider = Pdw_homepage_article::model()->findAll("type in (45)");
        $data['guider'] = $objGuider;
         $data['fLink'] = '/';
         $data['tLink'] = '/site/guider';
         $data['pageTitle'] = '游戏攻略';
         $data['current'] = 'guider';
         $data['seoInfo'] = HP::funGetListSeoInfo(45);
         $this->display('guider',$data);

     }

//guider detail
    public function actionGuiderDetail(){
        $data = array();
        $id = Yii::app()->request->getParam('id');
        $guiderDetail = Pdw_homepage_article::model()->find("id='{$id}'");
        $data['guider_detail'] = $guiderDetail;
        $data['fLink'] = '/';
        $data['tLink'] = '/site/guider';
        $data['pageTitle'] = '游戏攻略';
        $data['current'] = 'guider';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('guider_detail',$data);
    }

    //about us
    public function actionAboutUs(){
        $objAbout = Pdw_homepage_archives::model()->find('id=63');
        $data['about'] = $objAbout;
        $data['pageTitle'] = '关于我们';
        $data['linkName'] = '关于我们';
        $data['link'] = '/site/aboutUs';
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(63);
        $this->display('about_us',$data);
    }


    //job
    public function actionJob(){
        $type = 64;
        $data = array();
        $cdb = new CDbCriteria();
        $cdb->condition = "type in ({$type})";
        $cdb->order = "id desc";
        $obj = Pdw_homepage_article::model()->findAll($cdb);
        $data['pageTitle'] = '加入我们';
        $data['linkName'] = '加入我们';
        $data['link'] = '/site/job';
        $data['objArticle'] = $obj;
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetListSeoInfo(64);
        $this->display('job',$data);
    }

    //job detail
    public function actionJobDetail(){
        $data = array();
        $id = Yii::app()->request->getParam('id');
        $guiderDetail = Pdw_homepage_article::model()->find("id='{$id}'");
        $data['guider_detail'] = $guiderDetail;
        $data['link'] = '/site/job';
        $data['linkName'] = '加入我们';
        $data['pageTitle'] = '加入我们';
        $data['current'] = 'news';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('job_detail',$data);
    }


    //coop
    public function actionCoop(){
        $objAbout = Pdw_homepage_archives::model()->find('id=65');
        $data['about'] = $objAbout;
        $data['pageTitle'] = '合作洽谈';
        $data['linkName'] = '合作洽谈';
        $data['link'] = '/site/coop';
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(65);
        $this->display('about_us',$data);
    }

    //contact
    public function actionContact(){
        $objAbout = Pdw_homepage_archives::model()->find('id=66');
        $data['about'] = $objAbout;
        $data['pageTitle'] = '联系我们';
        $data['linkName'] = '联系我们';
        $data['link'] = '/site/contact';
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(66);
        $this->display('about_us',$data);
    }
}
?>
