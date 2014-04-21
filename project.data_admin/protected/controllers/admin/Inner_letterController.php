<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-6
 * Time: 下午2:11
 * To change this template use File | Settings | File Templates.
 */
class Inner_letterController extends MyAdminController{

    //all inner_letter
    public function actionIndex(){
//        $sql = "select l.id,l.to_user,l.status,l.send_time,m.title,m.content from pdw_inner_letter l join pdw_message m on l.message_id=m.id where l.to_user !=0";
//        $all = Page::funGetIntroBySql($sql,'',Yii::app()->db_data_www);
//        foreach($all as &$v){
//            $user_id = $v["to_user"];
//            $user_model = Pdw_user::model();
//            $one = $user_model->findByPk($user_id);
//            $v['user_name'] = $one['username'];
//        }
////        print_r($all);
//        $data['all'] = $all;
////        $this->display('letter_list',$data);
    }

    //delete
    public function actionDelete(){
        $id = Yii::app()->request->getParam('id');
        $user_model = Pdw_inner_letter::model();
        if($user_model->deleteByPk($id)){
            $this->alert_ok();
        }else{
            $this->alert_error();
        }
    }

    //show add
    public function actionShowAdd(){

    }

    //show edit
    public function actionShowEdit(){
        $id = Yii::app()->request->getParam('id');
        $user_model = Pdw_user::model();
        $data['all_user'] = $user_model->findAll();
        $this->display('inner_edit',$data);

    }


    //新用户注册欢迎信
    public function actionWelcomeLetter(){
        $message_model = Pdw_message::model();
        if(Yii::app()->request->getIsPostRequest()){
            $title = MyFunction::inNoInjection(Yii::app()->request->getParam('letter_title'));
            $content = MyFunction::inNoInjection(Yii::app()->request->getParam('letter_content'));
            $id = Yii::app()->request->getParam('hidden_id');
            $res = $message_model->updateByPk($id,array(
                'title'=>$title,
                'content'=>$content
            ));
            if($res){
                $this->alert_ok('操作成功');
            }
        }
        $welcome_letter = $message_model->find('type=2');
        //欢迎信是否存在
//        $data['if_exist'] = isset($welcome_letter)?1:0;

        $data['one'] = $welcome_letter;
        $this->renderPartial('inner_letter',$data);
    }



}