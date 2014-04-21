<?php
/**
 * 游戏controller
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-17
 * Time: 上午9:40
 * To change this template use File | Settings | File Templates.
 */
class GameController extends MyPageController{

    //game list
    public function actionIndex($page=1){
        $count = Pdw_games::model()->count();
        //cbd
        $criteria = new CDbCriteria();
        $criteria->order = 'id desc';
        $criteria->limit = GAME_PRE_PAGESIZE;
        $criteria->offset = GAME_PRE_PAGESIZE*($page-1);
        $pager = new CPagination($count);
        $pager->setPageSize(GAME_PRE_PAGESIZE);
        $pager->applyLimit($criteria);
        $data['own_all'] = Pdw_games::model()->findAll($criteria);
        $data['page'] = $pager;
        $data['pageTitle'] = '游戏中心';
        $data['current'] = 'game';
        $this->renderPartial('gameList',$data);
    }

    //分离Detail右边区域
    public function getDetailRight(){
        $cbd = new CDbCriteria();
        $cbd->select = 'id,title,img_thumb';
        $cbd->order = 'create_time desc';
        $cbd->addCondition("img_thumb !=''and recomment=1");
        $data['gameList'] = Pdw_games::model()->findAll($cbd);

        return $this->renderPartial('gameDetailRight',$data,true);
    }


    //游戏详情
    public function actionGameDetail($id){
        if(isset($id)){
            //load detail right
            $data['rightHtml'] = $this->getDetailRight();
            $oneDetail = Pdw_games::model()->findByPk($id);

            //处理二维码
            require_once(Yii::getPathOfAlias('ext').'/com/tools/qrcode.class.php');
            $dir = WEB_ROOT.'/images/qrcode';
            if( ! is_dir($dir)){
                mkdir($dir);
            }
            $forDomain = Yii::app()->params['for_domain'];
            $androidCode = $oneDetail->android_code;
            $androidFile = md5($androidCode).'.png';
            $androidUrl = $forDomain.'/images/qrcode/'.$androidFile;
            $iosCode = $oneDetail->ios_code;
            $iosFile = md5($iosCode).'.png';
            $iosUrl = $forDomain.'/images/qrcode/'.$iosFile;

            //android code
            if( ! file_exists($androidFile)){
                if(empty($androidCode)){
                    $androidUrl = $forDomain.'/images/qrcode_null.png';
                }
                QRcode::png($androidCode,$dir.'/'.$androidFile);
            }
            //ios code
            if( ! file_exists($iosFile)){
                if(empty($iosCode)){
                    $iosUrl = $forDomain.'/images/qrcode_null.png';
                }
                QRcode::png($iosCode,$dir.'/'.$iosFile);
            }


            $data['android_code'] = $androidUrl;
            $data['ios_code'] = $iosUrl;
            $data['androidUrl'] = $androidCode;
            $data['iosUrl'] = $iosCode;

            }
            $data['oneDetail'] = $oneDetail;
            $data['pageTitle'] = '游戏详情';
            $data['current'] = 'game';


        $this->renderPartial('gameDetail',$data);
    }






}