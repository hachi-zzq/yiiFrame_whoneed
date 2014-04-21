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
    //手机端视图文件夹
    private $_phoneViewDir = 'phone';
	// 首页
    public function actionIndex()
    {
        $objFDB = null;
        $objODB = null;
        $stype  = '1,2,15';

        $cdb = new CDbCriteria;
		$cdb->order     = "recommendflag desc, id DESC" ;
        $cdb->condition = "type in ({$stype})";
        $cdb->select    = 'id,title,type,submit_date';
        $cdb->limit     = 6;

        $objDB = Pdw_homepage_article::model()->findAll($cdb);

        if($objDB){
            foreach($objDB as $obj){
                if(!$objFDB){
                    $objFDB = $obj;
                }else{
                    $objODB[] = $obj;
                }
            }

            unset($objDB);
        }
        $data = array();
        $data['seoInfo'] = HP::funGetIndexSeoInfo(1);
        $data['objFDB'] = $objFDB;
        $data['objODB'] = $objODB;
        $data['stype']  = $stype;
        //check phone pc view file
        $viewName = $this->_isWap ? $this->_phoneViewDir.('/index') : 'index';
		$this->display($viewName, $data);
    }

    // 新闻列表页
    public function actionNew_index()
    {
        $data = array();
        $data['stype'] = '1,2';
        $data['sname'] = '新闻公告';
        $data['slink'] = '/site/new_index';  
        $data['dlink'] = '/site/new_detail';
        $data['seoInfo'] = HP::funGetListSeoInfo(1);
        $viewName = $this->_isWap ? $this->_phoneViewDir.('/new_index') : 'new_index';
        $this->display($viewName, $data);
    }

    //more list (phone)
    public function actionMoreList(){
        $cdb = new CDbCriteria();
        $arr = array();
        $type = Yii::app()->request->getParam('type');
        $lastId = Yii::app()->request->getParam('lastId');
        $limit = Yii::app()->request->getParam('limit');
        $cdb->condition = "type='{$type}' and id<{$lastId}";
        $cdb->limit = 6;
        $cdb->order = "recommendflag desc, id DESC";
        $objMore = Pdw_homepage_article::model()->findAll($cdb);
        if($objMore){
            foreach($objMore as $k=>$new){
                $arr[$k]['title'] = $new['title'];
                $arr[$k]['id'] = $new['id'];
                $arr[$k]['date'] = date('Y-m-d',strtotime($new['submit_date']));
            }
        }
        echo json_encode($arr);
    }

    // 新闻详细页
    public function actionNew_detail()
    {
        $data = array();
        $data['stype'] = '1,2';
        $data['sname'] = '新闻公告';
        $data['slink'] = '/site/new_index';  
        $data['dlink'] = '/site/new_detail';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $viewName = $this->_isWap ? $this->_phoneViewDir.('/new_detail') : 'new_detail';
        $this->display($viewName, $data);
    }

    // 游戏资料列表页
    public function actionGame_data_index()
    {
        $data = array();
        $data['stype'] = '3';
        $data['sname'] = '游戏资料';
        $data['slink'] = '/site/game_data_index';         
        $data['dlink'] = '/site/game_data_detail';
        $data['seoInfo'] = HP::funGetListSeoInfo(3);
        $this->display('new_index', $data);
    }

    // 游戏资料详细页
    public function actionGame_data_detail()
    {
        $data = array();
        $data['stype'] = '3';
        $data['sname'] = '游戏资料';
        $data['slink'] = '/site/game_data_index';  
        $data['dlink'] = '/site/game_data_detail';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('new_detail', $data);
    }

    // 攻略指南列表页
    public function actionStrategy_guide_index()
    {
        $data = array();
        $data['stype'] = '4';
        $data['sname'] = '攻略指南';
        $data['slink'] = '/site/strategy_guide_index';
        $data['dlink'] = '/site/strategy_guide_detail';        
        $data['seoInfo'] = HP::funGetListSeoInfo(4);
        $this->display('new_index', $data);
    }

    // 攻略指南详细页
    public function actionStrategy_guide_detail()
    {
        $data = array();
        $data['stype'] = '4';
        $data['sname'] = '攻略指南';
        $data['slink'] = '/site/strategy_guide_index';
        $data['dlink'] = '/site/strategy_guide_detail';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('new_detail', $data);
    }

    // 单页
    public function actionCdetail()
    {
        $id         = intval($_GET['id']);
        $type_name  = '';
        $data       = array();

        $objDB = Pdw_homepage_archives::model()->find("id = {$id}");
        if($objDB){
            $objTDB = Pdw_homepage_type::model()->find("id = {$id}");
            if($objTDB){
                $type_name = $objTDB->type_name;
            }
        }

        $data['objDB']  = $objDB;
        $data['id']     = $id;
        $data['sname']  = $type_name;
        $data['seoInfo'] = HP::funGetArchivesSeoInfo((int)$_GET['id']);
        $this->display('cdetail', $data);
    }

    // 成长礼包
    public function actionGrowth_package()
    {
        $this->display('growth_package');
    }

    //招聘信息
    public function actionJob(){
        $data = array();
        $data['stype'] = '16';
        $data['sname'] = '招聘信息';
        $data['slink'] = '/site/job';
        $data['dlink'] = '/site/jobDetail';
        $data['seoInfo'] = HP::funGetListSeoInfo(16);
        $this->display('new_index', $data);
    }

    //招聘详情页
    public function actionJobDetail(){
        $data = array();
        $data['stype'] = '16';
        $data['sname'] = '招聘信息';
        $data['slink'] = '/site/job';
        $data['dlink'] = '/site/jobDetail';
        $data['seoInfo'] = HP::funGetArticleSeoInfo((int)$_GET['id']);
        $this->display('new_detail', $data);
    }

    public function actionCustomer(){
        $this->display('customer');
    }
    
    //领取新手礼包
    public function actionGetNovicePackage(){
        $obj = Pdw_novice_package::model()->find('status=0');
        $reArr = array();
        if($obj){
            $user_ip = MyFunction::funGetIP();
            //var_dump($user_ip);die();
            $count   = Pdw_novice_package::model()->count('ip=:ip',array(':ip'=>$user_ip));

            if( $count>=5){
                $reArr['status'] = 0;
                $reArr['message']= '你已经领取过新手礼包,礼包只能激活一次,请不要领取更多!';
            }else{
                $code = $obj->code;
                $obj->status = 1;
                $obj->time   = date('Y-m-d H:i:s');
                $obj->ip     = $user_ip;
                $result = $obj->save();
                if($result){
                    $reArr['status'] = 1;
                    $reArr['code']   =$code;
                    $reArr['content']='38点券、铜币包*50、白金资源宝箱*50、武将刷新卡*5、建设令*3、驻颜丹*1';
                    $reArr['message']='每个账号只能使用一个激活码，不能重复激活';
                }else{
                    $reArr['status'] = 0;
                    $reArr['message']= '取激活码失败,请刷新再试!';
                }
            }
        }else{
            $reArr['status']  = 0;
            $reArr['message'] = '激活码已领完,请关注官网未来的活动!';
        }
        echo json_encode($reArr);
    }

    //姓名预测小游戏
    public function actionNameGame(){
        $data = array();
        $objResult = '';
        //request
        if(Yii::app()->request->isPostRequest){
            $name = trim(Yii::app()->request->getParam('test_name'));
            if(preg_match('/[\d]/',$name) || empty($name) || mb_strlen($name,'utf8')>8){
                MyFunction::alert_back('你确定这是你的名字？');
            }
            $key = $this->getKeyByName($name);
            if(! Yii::app()->cache->get($key)){
                $objResult = Pdw_forecast_game::model()->find("name_key='{$key}'");
                Yii::app()->cache->set($key,$objResult);
            }else{
                header("key_cache:yes");
                $objResult = Yii::app()->cache->get($key);
            }
        }
        $data['result'] = $objResult;
        $this->renderPartial('name_game',$data);

    }

    //get key by name/根据姓名换算后得到key
    public function getKeyByName($name){
        $py = MyUsePinyin::Pinyin($name);
        $sum = 0;
        for($i=0;$i<strlen($py);$i++){
            $sum += ord($py[$i]);
        }
        return $sum%10;
    }
}


