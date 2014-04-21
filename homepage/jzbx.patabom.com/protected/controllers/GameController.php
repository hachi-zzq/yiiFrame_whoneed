<?php
class GameController extends MyPageController{


    //download
    public function actionDownload(){
        $data = array();
        $data['link'] = '/game/download';
        $data['linkName'] = '游戏下载';
        $data['current'] = 'download';
        $data['seoInfo'] = HP::funGetListSeoInfo(83);
        $this->display('download',$data);
    }

    //game thumb
    public function actionGameThumb(){
        $cdb = new CDbCriteria();
        $cdb->condition = "type = 88";
        $cdb->order = "id DESC";
        $count = Pdw_homepage_game_thumb::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->setPageSize(6);
        $pager->applyLimit($cdb);
        //游戏截图
        $gameThumb = Pdw_homepage_game_thumb::model()->findAll($cdb);

        $data['gameThumb'] = $gameThumb;
        $data['pager'] = $pager;
        $data['pageTitle'] = '游戏截图';
        $data['seoInfo'] = HP::funGetListSeoInfo(88);
        $this->display('game_thumb',$data);
    }

    //世界杯预测小游戏
    public function actionAjaxSave(){
        $html = Yii::app()->request->getParam('data');
        $obj = new Pdw_jzbx_game();
        $param = time()+rand(1000,9999);
        $obj->param = $param;
        $obj->md5_verfiy = md5($param.'szjj');
        $obj->content = "<!DOCTYPE html>\n<html>".$html.'</html>';
        if($obj->save())
            echo $obj->param;
    }

    public function actionOutPutHtml(){
        $param = Yii::app()->request->getParam('param');
        //check md5
        $obj = Pdw_jzbx_game::model()->find("param='{$param}'");
        if($obj){
            if($obj->md5_verfiy != md5($param.'szjj')){
                exit('非法操作');
            }
            $content = $obj->content;
            $content = preg_replace('/id="weibo_btn"/iUu','id="try"',$content);
            $content = preg_replace('/id="share"/iUu','href="/game"',$content);
            echo $content;
        }else{
            exit('未找到相关记录');
        }
    }

}