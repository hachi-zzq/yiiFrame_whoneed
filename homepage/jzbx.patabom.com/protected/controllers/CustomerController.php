<?php
class CustomerController extends MyPageController{

    //index
    public function actionIndex(){
        //联系客服
        $objCall = Pdw_homepage_archives::model()->find('id=82');
        //下载问题
        $objDownloadQuestion = Pdw_homepage_article::model()->findAll('type in(72)');
        //安装问题
        $objInstallQuestion = Pdw_homepage_article::model()->findAll('type in(73)');
        //账号问题
        $objAccountQuestion = Pdw_homepage_article::model()->findAll('type in(74)');

        //安全问题
        $objSafeQuestion = Pdw_homepage_article::model()->findAll('type in(75)');

        //用户协议
        $objUserQuestion = Pdw_homepage_article::model()->findAll('type in(76)');

        //充值问题
        $objRechargeQuestion = Pdw_homepage_article::model()->findAll('type in(77)');

        //客户端问题
        $objKeQuestion = Pdw_homepage_article::model()->findAll('type in(78)');

        //登入运行问题
        $objRunQuestion = Pdw_homepage_article::model()->findAll('type in(79)');

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
        $data['seoInfo'] = HP::funGetListSeoInfo(82);
        $this->display('customer',$data);
    }

}