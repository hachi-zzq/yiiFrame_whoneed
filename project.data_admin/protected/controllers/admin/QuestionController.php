<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-2-21
 * Time: 下午3:21
 * To change this template use File | Settings | File Templates.
 */
class QuestionController extends MyAdminController{

    public function init(){
        parent::init();
    }

    //hand add
    public function actionHanderAdd(){
        $adminId = Yii::app()->user->getState('admin_id');
        //submit
        if(Yii::app()->request->isPostRequest && Yii::app()->request->getParam('action')=='save_hander_question'){
            $questionType = Yii::app()->request->getParam('question_type');
            $userName = Yii::app()->request->getParam('user_name');
            $platformId = Yii::app()->request->getParam('channel_district_id');
            $gameId = Yii::app()->request->getParam('game_id');
            $roleName = Yii::app()->request->getParam('role_name');
            $gameArea = Yii::app()->request->getParam('game_area');
            $rechargeType = Yii::app()->request->getParam('recharge_type');
            $rechargeCardNumber = Yii::app()->request->getParam('recharge_card_number');
            $rechargeOrderNumber = Yii::app()->request->getParam('recharge_order_number');
            $description = Yii::app()->request->getParam('description');
            $flowTo = Yii::app()->request->getParam('flow_to');
            //if flow
            $flow = Yii::app()->request->getParam('is_flow');
            $questionModel = new Pdw_question();
            $questionModel->user_name = $userName;
            $questionModel->question_type = $questionType;
            $questionModel->platform_id = $platformId;
            $questionModel->game_id = $gameId;
            $questionModel->role_name = $roleName;
            $questionModel->game_area = $gameArea;
            $questionModel->recharge_type = $rechargeType;
            $questionModel->recharge_order_number = $rechargeOrderNumber;
            $questionModel->recharge_card_number = $rechargeCardNumber;
            $questionModel->question_description = $description;
            $questionModel->create_time = time();
            if( !empty($_FILES['question_thumb']['name'])){
                $questionModel->question_thumb = MyUploadFile::pageUploadCdnImg('question_thumb');
            }
            //if_flow设置问题状态
            if($flow){
                $questionModel->status = 2;
            }else{
                $questionModel->status = 4;
            }
            if($questionModel->save()){
                //flow
                if($flow){
                    $lastInsertId = Yii::app()->db_data_www->getLastInsertID();
                    $flowModel = new Pdw_question_flow();
                    $flowModel->question_id = $lastInsertId;
                    $flowModel->flow_to = $flowTo;
                    $flowModel->flow_from = $adminId;
                    $flowModel->flow_time = time();
                    $flowModel->is_begin = 1;
                    $flowModel->flow_reply = 1;
                    $flowModel->save();
                }
                $this->alert_ok('操作成功',array('callbackType'=>'closeCurrent'));
            }else{
                $this->alert_error('操作失败',array('callbackType'=>'closeCurrent'));
            }
        }

        //question type
        $questionType = $this->getQuestionType();
        $data['questionType'] = $questionType;

        //all games
        $data['games'] = $this->getAllGames();

        //all admin
        $data['admins'] = $this->getAllAdmin();
        $this->display('hander_add',$data);
    }


    //接入问题
    public function actionAccept(){
        $cdb = new CDbCriteria();
        $cdb->condition = 'status = 0';
        $objNotHander = Pdw_question::model()->findAll($cdb);
        $data['objNotHander'] = count($objNotHander);
        $this->display('question_accept',$data);
    }

    //question detail
    public function actionAcceptDetail(){
        $cdb = new CDbCriteria();
        $cdb->condition = "status = 0";
        $cdb->order = "id ASC";
        $objNotHander = Pdw_question::model()->findAll($cdb);

        if( ! $objNotHander){
            exit('没有可以接入的问题');
        }
        $id = $objNotHander[0]->id;
        //记录接入客服的信息
        $adminId = Yii::app()->user->getState('admin_id');
        $objQuestion = Pdw_question::model()->find("id='{$id}'");
        $objQuestion->accept_servicer_id = $adminId;
        $objQuestion->accept_time = time();
        //设置已经接入状态
        $objQuestion->status = 1;
        $objQuestion->save();
        $data['questionDetail'] = $objQuestion;
        //问题开始标记
        $data['question_start_flag'] = 1;

        $this->display('accept_detail',$data);
    }

    //reply
    public function actionReply(){
        $adminId = Yii::app()->user->getState('admin_id');
        $questionId = Yii::app()->request->getParam('question_id');
        $replyContent = Yii::app()->request->getParam('reply_content');
        $flowFromId = Yii::app()->request->getParam('flow_from_id');
        //判断是回复给最总客户还是流转来自
        $cbd = new CDbCriteria();
        $cbd->addCondition("question_id='{$questionId}' and flow_to='{$adminId}' and flow_from='{$flowFromId}' and is_begin=1 and flow_reply=1");
        $objFlow = Pdw_question_flow::model()->find($cbd);
        if($objFlow){
            //回复客服流转
            $flowModel = new Pdw_question_flow();
            $flowModel->question_id = $questionId;
            $flowModel->flow_from = $adminId;
            $flowModel->flow_to = $objFlow->flow_from;
            $flowModel->flow_remark = $replyContent;
            $flowModel->is_begin = 0;
            $flowModel->flow_reply = 2;
            $flowModel->flow_time = time();
            $res = $flowModel->save();
            //更改question的status属性
            $obj = Pdw_question::model()->find("id = '{$questionId}'");
            $obj->status = 3;
            $obj->save();
        }else{
            //直接回复客户，完结该问题
            $obj = Pdw_question::model()->find("id='{$questionId}'");
            $obj->reply_servicer_id = $adminId;
            $obj->reply_content = $replyContent;
            $obj->reply_time = time();
            $obj->status = 4;
            $res = $obj->save();
        }

        if($res){
            $this->alert_ok('操作成功',array('callbackType'=>'closeCurrent'));
        }else{
            $this->alert_error('操作失败',array('callbackType'=>'closeCurrent'));
        }

    }

    //流转，flow to
    public function actionFlowTo(){
        $questionId = Yii::app()->request->getParam('question_id');
        $adminId = Yii::app()->user->getState('admin_id');
        $flowTo = Yii::app()->request->getParam('flow');
        //start flag
        $questionStartFlag = Yii::app()->request->getParam('question_start_flag');

        $questionFlow = new Pdw_question_flow();
        $questionFlow->question_id = $questionId;
        $questionFlow->flow_from = $adminId;
        $questionFlow->flow_to = $flowTo;
        $questionFlow->flow_reply = 1;
        $questionFlow->flow_time = time();


        //问题开始标记，解决死循环
        if($questionStartFlag){
            $questionFlow->is_begin = 1;
        }

        if($questionFlow->save()){
            //设置question的状态为‘正在流转’
            $questionModel = Pdw_question::model()->find("id='{$questionId}'");
            $questionModel->status = 2;
            $questionModel->save();
            $this->alert_ok('操作成功',array('callbackType'=>'closeCurrent'));
        }else{
            $this->alert_error('操作失败',array('callbackType'=>'closeCurrent'));
        }

    }

    //question search
    public function actionSearch(){
        $arrCondition = array();
        $adminId = Yii::app()->user->getState('admin_id');
        $page = Yii::app()->request->getParam('pageNum')-1;
        $myform = Yii::app()->request->getParam('myform');
        $nowTime = date('Y-m-d',time());
        //default time now
        $BeginStamp = strtotime($nowTime.' 00:00:00');
        $EndStamp = strtotime($nowTime.' 23:59:59');
        $cdb = new CDbCriteria();
        //start search
        if(Yii::app()->request->isPostRequest){
            $postStartTime =  Yii::app()->request->getParam('start_time');
            $postEndTime =  Yii::app()->request->getParam('end_time');
            $userName = Yii::app()->request->getParam('user_name');
            $questionType  = Yii::app()->request->getParam('question_type');
            $questionStatus  = Yii::app()->request->getParam('question_status');
            $channelId  = Yii::app()->request->getParam('district_channel_id');
            $BeginStamp = strtotime($postStartTime.' 00:00:00');
            $EndStamp = strtotime($postEndTime.' 23:59:59');
            if($userName){
                $cdb->addCondition("user_name = '{$userName}'");
                $arrCondition['user_name'] = $userName;
                $data['user_name'] = $userName;
            }
            if($questionType){
                $cdb->addCondition("question_type = '{$questionType}'");
                $arrCondition['question_type'] = $questionType;
                $data['question_type'] = $questionType;
            }

            if($questionStatus != '-100'){
                $cdb->addCondition("status = '{$questionStatus}'");
                $arrCondition['question_status'] = $questionStatus;
                $data['question_status'] = $questionStatus;
            }

            if($channelId){
                $cdb->addCondition("platform_id='{$channelId}'");
                $arrCondition['district_channel_id'] = $channelId;
                $data['channel_name'] = Yii::app()->request->getParam('district_channel_name');
                $data['channel_id'] = $channelId;
            }
            $arrCondition['start_time'] = $postStartTime;
            $arrCondition['end_time'] = $postEndTime;
            $data['time'] =array('start_time'=>$postStartTime,'end_time'=>$postEndTime);
        }
        $cdb->addCondition("create_time between '{$BeginStamp}' and '{$EndStamp}'");

        $cdb->order = "status ASC";
        $count = Pdw_question::model()->count($cdb);
        //page
        $pager = new CPagination($count);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->setCurrentPage($page);
        $pager->applyLimit($cdb);
        $objQuestion = Pdw_question::model()->findAll($cdb);
        //gameid->gamename,questionTypeid->questionTypeName
        foreach($objQuestion as $question){
            $question['game_id'] = Pdw_games::model()->find("id='{$question['game_id']}'")->title;
            $question['question_type'] = Pdw_question_type::model()->find("id='{$question['question_type']}'")->type_name;
        }

        $data['pager'] = $pager;
        $data['questions'] = $objQuestion;
        $data['arrCondition'] = $arrCondition;
        $this->display('question_search',$data);
    }

    //high searh
    public function actionHighSearch(){
        if(Yii::app()->request->isPostRequest){
            $arrCondition = array();
            $page = Yii::app()->request->getParam('pageNum')-1;
            $id = Yii::app()->request->getParam('question_id');
            $userName = Yii::app()->request->getParam('user_name');
            $gameId = Yii::app()->request->getParam('game_id');
            $gameArea = Yii::app()->request->getParam('game_area');
            $questionType = Yii::app()->request->getParam('question_type');
            $userPhone = Yii::app()->request->getParam('user_phone');
            $platformId = Yii::app()->request->getParam('district_channel_id');
            $startTime = Yii::app()->request->getParam('start_time');
            $endTime = Yii::app()->request->getParam('end_time');

            $cdb = new CDbCriteria();
            if($id){
                $cdb->addCondition("id='{$id}'");
                $arrCondition['question_id'] = $id;
            }

            if($userName){
                $cdb->addCondition("user_name='{$userName}'");
                $arrCondition['user_name'] = $userName;
            }

            if($gameId){
                $cdb->addCondition("game_id='{$gameId}'");
                $arrCondition['game_id'] = $gameId;
            }

            if($gameArea){
                $cdb->addCondition("game_area='{$gameArea}'");
                $arrCondition['game_area'] = $gameArea;
            }

            if($questionType){
                $cdb->addCondition("question_type='{$questionType}'");
                $arrCondition['question_type'] = $questionType;
            }

            if($userPhone){
                $cdb->addCondition("user_phone='{$userPhone}'");
                $arrCondition['user_phone'] = $userPhone;
            }

            if($platformId){
                $cdb->addCondition("platform_id='{$platformId}'");
                $arrCondition['platform_id'] = $platformId;
            }

            if($startTime){
                $BeginStamp = strtotime($startTime.' 00:00:00');
                $cdb->addCondition("create_time > '{$BeginStamp}' or create_time ='{$BeginStamp}'");
                $arrCondition['start_time'] = $startTime;

            }

            if($endTime){
                $EndStamp = strtotime($endTime.' 23:59:59');
                $cdb->addCondition("create_time < '{$EndStamp}' or create_time ='{$EndStamp}'");
                $arrCondition['end_time'] = $endTime;
            }

            //page
            $count = Pdw_question::model()->count($cdb);
            $pager = new CPagination($count);
            $pager->setCurrentPage($page);
            $pager->setPageSize(self::PAGE_SIZE);
            $pager->applyLimit($cdb);
            $objQuestion = Pdw_question::model()->findAll($cdb);

            foreach($objQuestion as $question){
                $question['game_id'] = Pdw_games::model()->find("id='{$question['game_id']}'")->title;
                $question['question_type'] = Pdw_question_type::model()->find("id='{$question['question_type']}'")->type_name;
            }
            $data['questions'] = $objQuestion;
            $data['arrCondition'] = $arrCondition;
            $data['pager'] = $pager;
            $this->display('question_search',$data);
        }
        $this->display('question_high_search');
    }


    //flow me high search
    public function actionFlowMeHighSearch(){
        if(Yii::app()->request->isPostRequest){
            $adminId = Yii::app()->user->getState('admin_id');
            $arrCondition = array();
            $page = Yii::app()->request->getParam('pageNum')-1;
            $id = Yii::app()->request->getParam('question_id');
            $userName = Yii::app()->request->getParam('user_name');
            $gameId = Yii::app()->request->getParam('game_id');
            $gameArea = Yii::app()->request->getParam('game_area');
            $questionType = Yii::app()->request->getParam('question_type');
            $userPhone = Yii::app()->request->getParam('user_phone');
            $platformId = Yii::app()->request->getParam('district_channel_id');
            $startTime = Yii::app()->request->getParam('start_time');
            $endTime = Yii::app()->request->getParam('end_time');

            $cdb = new CDbCriteria();
            if($id){
                $cdb->addCondition("id='{$id}'");
                $arrCondition['question_id'] = $id;
            }

            if($userName){
                $cdb->addCondition("user_name='{$userName}'");
                $arrCondition['user_name'] = $userName;
            }

            if($gameId){
                $cdb->addCondition("game_id='{$gameId}'");
                $arrCondition['game_id'] = $gameId;
            }

            if($gameArea){
                $cdb->addCondition("game_area='{$gameArea}'");
                $arrCondition['game_area'] = $gameArea;
            }

            if($questionType){
                $cdb->addCondition("question_type='{$questionType}'");
                $arrCondition['question_type'] = $questionType;
            }

            if($userPhone){
                $cdb->addCondition("user_phone='{$userPhone}'");
                $arrCondition['user_phone'] = $userPhone;
            }

            if($platformId){
                $cdb->addCondition("platform_id='{$platformId}'");
                $arrCondition['platform_id'] = $platformId;
            }

            if($startTime){
                $BeginStamp = strtotime($startTime.' 00:00:00');
                $cdb->addCondition("create_time > '{$BeginStamp}' or create_time ='{$BeginStamp}'");
                $arrCondition['start_time'] = $startTime;

            }

            if($endTime){
                $EndStamp = strtotime($endTime.' 23:59:59');
                $cdb->addCondition("create_time < '{$EndStamp}' or create_time ='{$EndStamp}'");
                $arrCondition['end_time'] = $endTime;
            }

            //flow me
            $obj = Pdw_question_flow::model()->findAll("flow_to = '{$adminId}' and flow_reply='1'");
            $arrId = array();
            if($obj){
                foreach($obj as $v){
                    array_push($arrId,$v['question_id']);
                }
            }
            if(!empty($arrId)){
                $ids = implode(',',$arrId);
            }else{
                $ids = '-100';
            }
            $cdb->addCondition("id in ({$ids})");
            //page
            $count = Pdw_question::model()->count($cdb);
            $pager = new CPagination($count);
            $pager->setCurrentPage($page);
            $pager->setPageSize(self::PAGE_SIZE);
            $pager->applyLimit($cdb);
            $objQuestion = Pdw_question::model()->findAll($cdb);

            foreach($objQuestion as $question){
                $question['game_id'] = Pdw_games::model()->find("id='{$question['game_id']}'")->title;
                $question['question_type'] = Pdw_question_type::model()->find("id='{$question['question_type']}'")->type_name;
            }
            $data['questions'] = $objQuestion;
            $data['arrCondition'] = $arrCondition;
            $data['pager'] = $pager;
            $this->display('flow_me_list',$data);
        }
        $this->display('flow_me_high_search');
    }

    //unhander high search
    public function actionUnhanderHighSearch(){
        if(Yii::app()->request->isPostRequest){
            $adminId = Yii::app()->user->getState('admin_id');
            $arrCondition = array();
            $page = Yii::app()->request->getParam('pageNum')-1;
            $id = Yii::app()->request->getParam('question_id');
            $userName = Yii::app()->request->getParam('user_name');
            $gameId = Yii::app()->request->getParam('game_id');
            $gameArea = Yii::app()->request->getParam('game_area');
            $questionType = Yii::app()->request->getParam('question_type');
            $userPhone = Yii::app()->request->getParam('user_phone');
            $platformId = Yii::app()->request->getParam('district_channel_id');
            $startTime = Yii::app()->request->getParam('start_time');
            $endTime = Yii::app()->request->getParam('end_time');

            $cdb = new CDbCriteria();
            if($id){
                $cdb->addCondition("id='{$id}'");
                $arrCondition['question_id'] = $id;
            }

            if($userName){
                $cdb->addCondition("user_name='{$userName}'");
                $arrCondition['user_name'] = $userName;
            }

            if($gameId){
                $cdb->addCondition("game_id='{$gameId}'");
                $arrCondition['game_id'] = $gameId;
            }

            if($gameArea){
                $cdb->addCondition("game_area='{$gameArea}'");
                $arrCondition['game_area'] = $gameArea;
            }

            if($questionType){
                $cdb->addCondition("question_type='{$questionType}'");
                $arrCondition['question_type'] = $questionType;
            }

            if($userPhone){
                $cdb->addCondition("user_phone='{$userPhone}'");
                $arrCondition['user_phone'] = $userPhone;
            }

            if($platformId){
                $cdb->addCondition("platform_id='{$platformId}'");
                $arrCondition['platform_id'] = $platformId;
            }

            if($startTime){
                $BeginStamp = strtotime($startTime.' 00:00:00');
                $cdb->addCondition("create_time > '{$BeginStamp}' or create_time ='{$BeginStamp}'");
                $arrCondition['start_time'] = $startTime;

            }

            if($endTime){
                $EndStamp = strtotime($endTime.' 23:59:59');
                $cdb->addCondition("create_time < '{$EndStamp}' or create_time ='{$EndStamp}'");
                $arrCondition['end_time'] = $endTime;
            }

            $objIds = Pdw_question_flow::model()->findAll("flow_to='{$adminId}' and flow_reply='2'");
            $arrIds = array();
            if($objIds){
                foreach($objIds as $obj){
                    $questionId = $obj['question_id'];
                    $status = Pdw_question::model()->find("id = '{$questionId}'")->status;
                    if($status !=1 && $status != 3) continue;
                    array_push($arrIds,$obj['question_id']);
                }
                if(!empty($arrIds)){
                    $ids = implode(',',$arrIds);
                }else{
                    $ids = '-100';
                }
            }else{
                $ids = '-100';
            }
            //筛选已经接入或者已经回复的问题
            $cdb->addCondition("id in({$ids}) or status=1");

            //page
            $count = Pdw_question::model()->count($cdb);
            $pager = new CPagination($count);
            $pager->setCurrentPage($page);
            $pager->setPageSize(self::PAGE_SIZE);
            $pager->applyLimit($cdb);
            $objQuestion = Pdw_question::model()->findAll($cdb);

            foreach($objQuestion as $question){
                $question['game_id'] = Pdw_games::model()->find("id='{$question['game_id']}'")->title;
                $question['question_type'] = Pdw_question_type::model()->find("id='{$question['question_type']}'")->type_name;
            }
            $data['questions'] = $objQuestion;
            $data['arrCondition'] = $arrCondition;
            $data['pager'] = $pager;
            $this->display('unhander_question',$data);
        }
        $this->display('unhander_high_search');
    }

    //get question detail
    public function actionQuestionDeatail(){
        $id = Yii::app()->request->getParam('id');
        $status = Yii::app()->request->getParam('status');
        $adminId = Yii::app()->user->getState('admin_id');
        $objQuestion = Pdw_question::model()->find("id='{$id}'");
        //remark
        $objRemark = Pdw_question_remark::model()->findAll("question_id='{$id}'");

        $data['questionDetail'] = $objQuestion;
        $data['objRemark'] = $objRemark;
        foreach($objRemark as $remark){
            $remark['user_id'] = Whoneed_admin::model()->find("id='{$remark['user_id']}'")->user_name;
        }
        //问题开始标记
        $data['question_start_flag'] = 1;
        $this->display('question_detail',$data);
    }

    //remark question
    public function actionRemark(){
        $questionId = Yii::app()->request->getParam('question_id');
        $remarkContent = Yii::app()->request->getParam('remark_content');
        $adminId = Yii::app()->user->getState('admin_id');

        $remarkModel = new Pdw_question_remark();
        $remarkModel->question_id = $questionId;
        $remarkModel->user_id = $adminId;
        $remarkModel->remark_content = $remarkContent;
        $remarkModel->remark_time = time();
        if($remarkModel->save()){
            $this->alert_ok('操作成功',array('callbackType'=>'closeCurrent'));
        }else{
            $this->alert_error('操作失败',array('callbackType'=>'closeCurrent'));
        }


    }

    //flow me list
    public function actionFlowMeList(){
        $arrCondition = array();
        $adminId = Yii::app()->user->getState('admin_id');
        $page = Yii::app()->request->getParam('pageNum')-1;
        $nowTime = date('Y-m-d',time());
        //default time now
        $BeginStamp = strtotime($nowTime.' 00:00:00');
        $EndStamp = strtotime($nowTime.' 23:59:59');
        $cdb = new CDbCriteria();
        //start search
        if(Yii::app()->request->isPostRequest){
            $postStartTime =  Yii::app()->request->getParam('start_time');
            $postEndTime =  Yii::app()->request->getParam('end_time');
            $userName = Yii::app()->request->getParam('user_name');
            $questionType  = Yii::app()->request->getParam('question_type');
            $questionStatus  = Yii::app()->request->getParam('question_status');
            $channelId  = Yii::app()->request->getParam('district_channel_id');
            $BeginStamp = strtotime($postStartTime.' 00:00:00');
            $EndStamp = strtotime($postEndTime.' 23:59:59');
            if($userName){
                $cdb->addCondition("user_name = '{$userName}'");
                $arrCondition['user_name'] = $userName;
                $data['user_name'] = $userName;
            }
            if($questionType){
                $cdb->addCondition("question_type = '{$questionType}'");
                $arrCondition['question_type'] = $questionType;
                $data['question_type'] = $questionType;
            }

            if($questionStatus != '-100'){
                $cdb->addCondition("status = '{$questionStatus}'");
                $arrCondition['question_status'] = $questionStatus;
                $data['question_status'] = $questionStatus;
            }

            if($channelId){
                $cdb->addCondition("platform_id='{$channelId}'");
                $arrCondition['district_channel_id'] = $channelId;
                $data['channel_name'] = Yii::app()->request->getParam('district_channel_name');
                $data['channel_id'] = $channelId;
            }
            $arrCondition['start_time'] = $postStartTime;
            $arrCondition['end_time'] = $postEndTime;
            $data['time'] =array('start_time'=>$postStartTime,'end_time'=>$postEndTime);
        }
        $cdb->addCondition("create_time between '{$BeginStamp}' and '{$EndStamp}' and status = '2'");


        $objIds = Pdw_question_flow::model()->findAll("flow_to='{$adminId}'");
        $arrIds =array();
        if($objIds){
            foreach($objIds as $obj){
                array_push($arrIds,$obj['question_id']);
            }
            $ids = implode(',',$arrIds);
        }else{
            $ids = '-100';
        }
        $cdb->addCondition("id in({$ids})");


        $cdb->order = "status ASC";
        $count = Pdw_question::model()->count($cdb);
        //page
        $pager = new CPagination($count);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->setCurrentPage($page);
        $pager->applyLimit($cdb);
        $objQuestion = Pdw_question::model()->findAll($cdb);
        //gameid->gamename,questionTypeid->questionTypeName
        foreach($objQuestion as $question){
            $question['game_id'] = Pdw_games::model()->find("id='{$question['game_id']}'")->title;
            $question['question_type'] = Pdw_question_type::model()->find("id='{$question['question_type']}'")->type_name;
        }

        $data['pager'] = $pager;
        $data['questions'] = $objQuestion;
        $data['arrCondition'] = $arrCondition;
        $this->display('flow_me_list',$data);
    }

    //my form,流转给我的表单详情
    public function actionFlowMeDetail(){
        $id = Yii::app()->request->getParam('id');
        $status = Yii::app()->request->getParam('status');
        $adminId = Yii::app()->user->getState('admin_id');
        $objQuestion = Pdw_question::model()->find("id='{$id}'");
        //remark
        $objRemark = Pdw_question_remark::model()->findAll("question_id='{$id}'");

        $data['questionDetail'] = $objQuestion;
        $data['objRemark'] = $objRemark;
        foreach($objRemark as $remark){
            $remark['user_id'] = Whoneed_admin::model()->find("id='{$remark['user_id']}'")->user_name;
        }
        //问题开始标记
        $data['question_start_flag'] = 1;
        $this->display('flow_me_detail',$data);
    }


    //unhander未处理李的问题（已经接入和流转已经回复的问题）
    public function actionUnhander(){
        $arrCondition = array();
        $adminId = Yii::app()->user->getState('admin_id');
        $page = Yii::app()->request->getParam('pageNum')-1;
        $nowTime = date('Y-m-d',time());
        //default time now
        $BeginStamp = strtotime($nowTime.' 00:00:00');
        $EndStamp = strtotime($nowTime.' 23:59:59');
        $cdb = new CDbCriteria();
        //start search
        if(Yii::app()->request->isPostRequest){
            $postStartTime =  Yii::app()->request->getParam('start_time');
            $postEndTime =  Yii::app()->request->getParam('end_time');
            $userName = Yii::app()->request->getParam('user_name');
            $questionType  = Yii::app()->request->getParam('question_type');
            $questionStatus  = Yii::app()->request->getParam('question_status');
            $channelId  = Yii::app()->request->getParam('district_channel_id');
            $BeginStamp = strtotime($postStartTime.' 00:00:00');
            $EndStamp = strtotime($postEndTime.' 23:59:59');
            if($userName){
                $cdb->addCondition("user_name = '{$userName}'");
                $arrCondition['user_name'] = $userName;
                $data['user_name'] = $userName;
            }
            if($questionType){
                $cdb->addCondition("question_type = '{$questionType}'");
                $arrCondition['question_type'] = $questionType;
                $data['question_type'] = $questionType;
            }

            if($questionStatus != '-100'){
                $cdb->addCondition("status = '{$questionStatus}'");
                $arrCondition['question_status'] = $questionStatus;
                $data['question_status'] = $questionStatus;
            }

            if($channelId){
                $cdb->addCondition("platform_id='{$channelId}'");
                $arrCondition['district_channel_id'] = $channelId;
                $data['channel_name'] = Yii::app()->request->getParam('district_channel_name');
                $data['channel_id'] = $channelId;
            }
            $arrCondition['start_time'] = $postStartTime;
            $arrCondition['end_time'] = $postEndTime;
            $data['time'] =array('start_time'=>$postStartTime,'end_time'=>$postEndTime);
        }
//        $cdb->addCondition("status = 1",'OR');
        $cdb->addCondition("create_time between '{$BeginStamp}' and '{$EndStamp}'");
        $objIds = Pdw_question_flow::model()->findAll("flow_to='{$adminId}' and flow_reply='2'");
        $arrIds = array();
        if($objIds){
            foreach($objIds as $obj){
                $questionId = $obj['question_id'];
                $status = Pdw_question::model()->find("id = '{$questionId}'")->status;
                if($status !=1 && $status != 3) continue;
                array_push($arrIds,$obj['question_id']);
            }
            if(!empty($arrIds)){
                $ids = implode(',',$arrIds);
            }else{
                $ids = '-100';
            }
        }else{
            $ids = '-100';
        }
        //筛选已经接入或者已经回复的问题
        $cdb->addCondition("id in({$ids}) or status=1");
        $cdb->order = "status ASC";
        $count = Pdw_question::model()->count($cdb);
        //page
        $pager = new CPagination($count);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->setCurrentPage($page);
        $pager->applyLimit($cdb);
        $objQuestion = Pdw_question::model()->findAll($cdb);
        //gameid->gamename,questionTypeid->questionTypeName
        foreach($objQuestion as $question){
            $question['game_id'] = Pdw_games::model()->find("id='{$question['game_id']}'")->title;
            $question['question_type'] = Pdw_question_type::model()->find("id='{$question['question_type']}'")->type_name;
        }

        $data['pager'] = $pager;
        $data['questions'] = $objQuestion;
        $data['arrCondition'] = $arrCondition;
        $this->display('unhander_question',$data);
    }

    //unhander detail
    public function actionUnhanderDetail(){
        $id = Yii::app()->request->getParam('id');
        $objQuestion = Pdw_question::model()->find("id='{$id}'");
        //remark
        $objRemark = Pdw_question_remark::model()->findAll("question_id='{$id}'");

        $data['questionDetail'] = $objQuestion;
        $data['objRemark'] = $objRemark;
        foreach($objRemark as $remark){
            $remark['user_id'] = Whoneed_admin::model()->find("id='{$remark['user_id']}'")->user_name;
        }
        //问题开始标记
        $data['question_start_flag'] = 1;
        $this->display('unhander_detail',$data);
    }

    //channle look back
    public function actionChannelLookBack(){
        $arrCondition = array();
        //page
        $page = Yii::app()->request->getParam('pageNum')-1;
        $channel_name = Yii::app()->request->getParam('channel_name');



        //all channel
        $channel_model = Pdc_channel::model();
        $cdb = new CDbCriteria();

        if($channel_name){
            $cdb->addCondition("channel_name like '%{$channel_name}%'");
            $arrCondition['channel_name'] = $channel_name;
        }

        //pagesize
        $count = $channel_model->count($cdb);
        $pager = new CPagination($count);
        $pager->pageSize = self::PAGE_SIZE;
        $pager->currentPage = $page;
        $pager->applyLimit($cdb);
        $objChannels = $channel_model->findAll($cdb);
        $data['channels'] = $objChannels;
        $data['pager'] = $pager;
        $data['arrCondition'] = $arrCondition;
        $this->display('channel_look_back',$data);
    }

    //question type
    public function getQuestionType(){
        $objQuestionType = Pdw_question_type::model()->findAll();
        return $objQuestionType;
    }

    //all ganmes
    public function getAllGames(){
        $objGame = Pdw_games::model()->findAll();
        return $objGame;
    }

    //all admin
    public function getAllAdmin(){
        $objAdmin = Whoneed_admin::model()->findAll();
        return $objAdmin;
    }



}