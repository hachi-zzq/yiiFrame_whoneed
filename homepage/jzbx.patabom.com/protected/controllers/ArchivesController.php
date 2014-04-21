<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-3-18
 * Time: 上午10:09
 * To change this template use File | Settings | File Templates.
 */
class ArchivesController extends MyPageController{

    //关于我们
    public function actionAboutUs(){
        $data = $this->archivesDetail(89,'/archives/aboutUs','关于我们','index');
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(89);
        $this->display('about_us',$data);
    }

    //合作洽谈
    public function actionCoo(){
        $data = $this->archivesDetail(80,'/archives/coo','合作洽谈','index');
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(80);
        $this->display('about_us',$data);
    }

    //联系我们
    public function actionConntract(){
        $data = $this->archivesDetail(81,'/archives/contract','联系我们','index');
        $data['seoInfo'] = HP::funGetArchivesSeoInfo(81);
        $this->display('about_us',$data);
    }

    //单页通用详情
    public function archivesDetail($id = '',$link='#',$linkName='',$current=''){
        if( ! $id){
            die('not found id');
        }
        $obj = Pdw_homepage_archives::model()->find("id = '{$id}'");
        $data['res'] = $obj;
        $data['link'] = $link;
        $data['linkName'] = $linkName;
        $data['current'] = $current;
        return $data;
    }

}