<?php
class QuestionController extends MyPageController{

    //问题提交
    public function actionSubmit(){
        if(Yii::app()->request->isPostRequest){
            //step1: get form data
            $questionTyep = Yii::app()->request->getParam('question_type');
            $gameId = Yii::app()->request->getParam('game_id');
            $gameArea = Yii::app()->request->getParam('game_area');
            $roleName = Yii::app()->request->getParam('role_name');
            $platformId = Yii::app()->request->getParam('flatform_id');
            $rechargeType = Yii::app()->request->getParam('recharge_type');
            $rechargeCardNumber = Yii::app()->request->getParam('recharge_card_number');
            $rechargeOrderdNumber = Yii::app()->request->getParam('recharge_order_number');
            $questionDescription = Yii::app()->request->getParam('question_description');
            $userPhone =Yii::app()->request->getParam('user_phone');


            //step2: in sql
            $objQuestion = new Pdw_question();
            $objQuestion->user_name = 'luyiyun';
            $objQuestion->question_type = $questionTyep;
            $objQuestion->game_id = $gameId;
            $objQuestion->game_area = $gameArea;
            $objQuestion->role_name = $roleName;
            $objQuestion->platform_id = $platformId;
            $objQuestion->recharge_type = $rechargeType;
            $objQuestion->recharge_order_number = $rechargeOrderdNumber;
            $objQuestion->recharge_card_number = $rechargeCardNumber;
            $objQuestion->question_description = $questionDescription;
            $objQuestion->user_phone = $userPhone;
            $objQuestion->create_time = time();
            $objQuestion->status = 0;
            //upload img
            if(!empty($_FILES['img_thumb']['name'])){
                $imgThumb = MyUploadFile::pageUploadCdnImg('img_thumb');
                $objQuestion->question_thumb = $imgThumb;
            }

            if($objQuestion->save()){
                MyFunction::alert_back('添加成功');
            }else{
                MyFunction::alert_back('添加失败');
            }
        }
        $this->renderPartial('question_submit');
    }


    //reply，已经回复的
    public function actionReplyed(){
        //replyed question
        $cdb = new CDbCriteria();
        $cdb->condition = "user_name= 'luyiyun' and status = '4'";
        $cdb->order = 'reply_time DESC';

        //seek data
        $data = array();
        $objReply = Pdw_question::model()->findAll($cdb);
        $data['replyed'] = $objReply;
        $this->renderPartial('question_replyed',$data);
    }

    //no reply，没有回复的
     public function actionNoReply(){
         //replyed question
         $cdb = new CDbCriteria();
         $cdb->condition = "user_name= 'luyiyun' and status != '4'";
         $cdb->order = 'reply_time DESC';

         //seek data
         $data = array();
         $objReply = Pdw_question::model()->findAll($cdb);
         $data['replyed'] = $objReply;
         $this->renderPartial('question_noreply',$data);
     }

    //question detail
    public function actionDetail(){
        $id = Yii::app()->request->getParam('id');
        if(!$id){
            exit('not find id');
        }
        $data = array();
        $objQuestion = Pdw_question::model()->find("id = '{$id}'");
        $objQuestion->question_type = Pdw_question_type::model()->find("id='{$objQuestion->question_type}'")->type_name;
        $objQuestion->game_id = Pdw_games::model()->find("id='{$objQuestion->game_id}'")->title;

        $data['detail'] = $objQuestion;

        $this->renderPartial('question_detail',$data);
    }

    /**************************************************************手机端问题**************************************************/
    //phone question
     public function actionPhoneQuestion(){
         $data = array();
         //Get方式获取角色名称和当前服务器
         $roleName = urlencode(trim($_GET['role_name']));
         $gameArea = urlencode(trim($_GET['game_area']));
        $data['params'] = array('role_name'=>$roleName,'game_area'=>$gameArea);
        $this->renderPartial('phone_question',$data);
     }

    public function actionPhoneSubmit(){
        if(Yii::app()->request->isPostRequest){
            //step1: get form data
            $questionTyep = Yii::app()->request->getParam('question_type');
            $gameArea = Yii::app()->request->getParam('game_area');
            $roleName = Yii::app()->request->getParam('role_name');
            $questionDescription = MyFunction::inNoInjection(Yii::app()->request->getParam('question_description'));
            $userPhone =Yii::app()->request->getParam('user_phone');
            //check Description
            if( ! $questionDescription){
                MyFunction::alert_back('问题描述必须填写');
                exit;
            }
            //check phone
            if($userPhone && (! MyFunction::checkPhoneNumber($userPhone))){
                MyFunction::alert_back('手机号不合法');
                exit;
            }

            //step2: in sql
            $objQuestion = new Pdw_question();
            $objQuestion->user_name = $roleName;
            $objQuestion->question_type = $questionTyep;
            $objQuestion->game_area = $gameArea;
            $objQuestion->role_name = $roleName;
            $objQuestion->question_description = $questionDescription;
            $objQuestion->user_phone = $userPhone;
            $objQuestion->create_time = time();
            $objQuestion->status = 0;
            //upload img
            if(!empty($_FILES['img_thumb']['name'])){
                $imgThumb = MyUploadFile::pageUploadCdnImg('img_thumb');
                $objQuestion->question_thumb = $imgThumb;
            }

            if($objQuestion->save()){
                MyFunction::alert_back('添加成功','/question/phoneQuestion?role_name='.$roleName.'&game_area='.$gameArea);
            }else{
                MyFunction::alert_back('添加失败','/question/phoneQuestion?role_name='.$roleName.'&game_area='.$gameArea);
            }
        }
        $this->renderPartial('phone_submit');
    }

    //my question resutl查询结果
    public function actionMyPhoneQuestion(){
        $data = array();
        $gameArea = Yii::app()->request->getParam('game_area');
        $roleName = Yii::app()->request->getParam('role_name');
        $cdb = new CDbCriteria();
        $cdb->addCondition("role_name = '{$roleName}' and game_area='{$gameArea}' and status=4");
        $cdb->limit = 1;
        $cdb->order = 'reply_time DESC';
        $objQuestion = Pdw_question::model()->find($cdb);
        $data['reply'] = $objQuestion;
        $this->renderPartial('phone_my_reply',$data);
    }
}