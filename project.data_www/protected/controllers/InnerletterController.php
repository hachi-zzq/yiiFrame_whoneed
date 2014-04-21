<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-27
 * Time: 下午2:20
 * To change this template use File | Settings | File Templates.
 */
class InnerletterController extends MyPageController{

    //站内信
    public function actionIndex($page=1){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        //check  is login ???
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }

        $letter_model = Pdw_inner_letter::model();

        //总记录数
        $count = $letter_model->count('to_user=:toUser',array('toUser'=>Yii::app()->user->id));

        //page
        $pager = new CPagination($count);
        $pager->setPageSize(LETTER_PRE_PAGESIZE);

        //criteria
        $criteria = new CDbCriteria();
        $criteria->addCondition('to_user=:toUser');
        $criteria->params['toUser'] = Yii::app()->user->id;
        $criteria->limit = $pager->getPageSize();
        $criteria->offset = $pager->getPageSize()*($page-1);
        $criteria->order = 'send_time desc';
        $all_letter = $letter_model->findAll($criteria);
        $data['letters'] = $all_letter;
        $data['page'] = $pager;

        $data['noRead'] =  $letter_model->count('to_user=:toUser and status=0',array('toUser'=>Yii::app()->user->id));
        $data['pageTitle'] = '站内信';
        $data['person_current'] = 'innerletter';
        $data['current'] = 'person';
        $this->renderPartial('letter',$data);
    }

    //letter检索
    public function actionLetterSearch($page=1){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        //check  is login ???
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }
        $start = Yii::app()->request->getParam('start_time')?Yii::app()->request->getParam('start_time'):Yii::app()->session['start_time'];
        $end =  Yii::app()->request->getParam('end_time')?Yii::app()->request->getParam('end_time'):Yii::app()->session['end_time'];
        //检索条件放入session
        Yii::app()->session['start_time'] = $start;
        Yii::app()->session['end_time'] = $end;
        $letter_model = Pdw_inner_letter::model();

        //总记录数
        $count = $letter_model->count('to_user=:toUser and send_time between :start_time and :end_time',array(
            'toUser'=>Yii::app()->user->id,
            'start_time'=>date('Y-m-d H:i:s',strtotime($start)),
            'end_time'=>date('Y-m-d H:i:s',strtotime($end))
        ));
        //page
        $pager = new CPagination($count);
        $pager->setPageSize(LETTER_PRE_PAGESIZE);
        //criteria
        $criteria = new CDbCriteria();
        $criteria->addCondition('to_user=:toUser');
        $criteria->addBetweenCondition('send_time',$start,$end);
        $criteria->params['toUser'] = Yii::app()->user->id;
        $criteria->limit = $pager->getPageSize();
        $criteria->offset = $pager->getPageSize()*($page-1);
        $criteria->order = 'send_time desc';
        $all_letter = $letter_model->findAll($criteria);
        $data['letters'] = $all_letter;
        $data['page'] = $pager;
        $data['noRead'] =  $letter_model->count('to_user=:toUser and status=0',array('toUser'=>Yii::app()->user->id));
        $data['pageTitle'] = '站内信';
        $data['person_current'] = 'innerletter';
        $data['current'] = 'person';
        $data['search_time'] = array('start_time'=>$start,'end_time'=>$end);
        $data['is_search'] = true;
        $this->renderPartial('letter',$data);

    }

    //设置已读状态
     public function actionSetRead(){
        $id = Yii::app()->request->getParam('id');
        $inner = Pdw_inner_letter::model();
        $inner->updateByPk($id,array(
            'status'=>1
        ));
         echo $id;
     }
}