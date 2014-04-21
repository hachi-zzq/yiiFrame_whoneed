<?php
class FaqController extends MyAdminController{
    // 初始化
    public function init(){
        parent::init();
    }

    public function actionFaqShow(){
        $search=array();
        $search['type_fid'] = intval(Yii::app()->request->getParam('type_fid'));
        $search['type_id']  = intval(Yii::app()->request->getParam('type_id'));
        $search['faq_question'] = Yii::app()->request->getParam('faq_question');
        //没有选子类则查询该父类下的所有子类
        $cdb = new CDbCriteria();
        $son_list = Pdw_faq_type::model()->getSonListByFid($search['type_fid']);
        if( !empty($search['type_id']) ){
            $cdb->condition = "type_id = ".$search['type_id'];
        }else{
            if( empty($son_list) ){
                $search_ids = $search['type_fid'];
            }else{
                $search_ids = join(',',array_keys($son_list));
            }
            $cdb->condition="type_id in($search_ids)";
        }
        
        if( !empty($search['faq_question']) ){
            $cdb->addCondition("question like :question");
            $cdb->params = array(':question'=>'%'.$search['faq_question'].'%');
        }
        $faq_model = Pdw_faq::model();
        //分页
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        $count = $faq_model->count($cdb);
        $pages = new CPagination($count);
        $pages->currentPage = $page;
        $pages->pageSize = self::PAGE_SIZE;
        $pages->applyLimit($cdb);

        $all      = $faq_model->findAll($cdb);
        $id_list  = Pdw_faq_type::model()->getIdList();
        $fid_list = Pdw_faq_type::model()->getFidList();
        //var_dump($all);die();
        $data['search'] =$search;
        $data['all']   = $all;
        $data['pages'] = $pages;
        $data['fid_list'] = $fid_list;
        $data['id_list'] = $id_list;
        $data['son_list'] = $son_list;
        $this->display('faqShow',$data);
    }

    public function actionFaqAddEdit(){
        $data=array();
        $fid_list = Pdw_faq_type::model()->getFidList();
        if( isset($_GET['faq_id']) ){
            $objDb=Pdw_faq::model()->findByPk((int)$_GET['faq_id']);
            if($objDb){
                $data['objDb']=$objDb;
                $data['type_fid'] = Pdw_faq_type::model()->getFidById($objDb->type_id);
                $data['son_list'] = Pdw_faq_type::model()->getSonListByFid($data['type_fid']);
            }
        }
        $data['fid_list'] = $fid_list;
        $this->display('faqAddEdit',$data);
    }

    public function actionFaqSave(){
        //保存游戏财务信息
        if( !empty($_REQUEST['faq_id']) && $faq_id=intval( Yii::app()->request->getParam('faq_id') ) ){
            $Pdw_faq=Pdw_faq::model()->findByPk($faq_id);
        }else{
            $Pdw_faq=new Pdw_faq;
        }
        $Pdw_faq->type_id    = empty($_REQUEST['type_id']) ? (int)$_REQUEST['type_fid'] : (int)$_REQUEST['type_id'];
        $Pdw_faq->question   = Yii::app()->request->getParam('question');
        $Pdw_faq->answer     = Yii::app()->request->getParam('answer');
        $Pdw_faq->video      = MyUploadFile::uploadVideo('video');
        $result = $Pdw_faq->save();
        $reArr = array("callbackType"=>"forward","statusCode"=>"200","message"=>'添加成功!');
        if(!$result){
            unset($reArr['callbackType']);
            $reArr['statusCode'] = "300";
            $reArr['message'] = "";
            if($Pdf_finance->hasErrors()){
                $message=$Pdf_finance->getErrors();
                foreach($message as $val) $reArr['message'].=$val[0];
            }
            if( empty($reArr['message']) ){
                $reArr['message'] = '添加失败!';
            }
        }
        echo json_encode($reArr);
    }

    public function actionFaqDelete(){
        $ids = Yii::app()->request->getParam('ids');
        $id_array=explode(',',$ids);
        //var_dump($id_array);die();
        $faq_count=Pdw_faq::model()->deleteByPk($id_array);
        if($faq_count){
            $reArr=array("statusCode"=>"200","message"=>"操作成功");
        }else{
            $reArr=array("statusCode"=>"-100","message"=>"删除失败,请重新选择需要删除的数据!");
        }
        echo json_encode($reArr);
    }

    public function actionAjaxGetSonList(){
        $type_fid  = (int)$_REQUEST['type_fid'];
        if( !empty($type_fid) ){
            $fid_list = Pdw_faq_type::model()->getSonListByFid($type_fid);
        }
        if( !empty($fid_list) ){
            $reArr = array("statusCode"=>"200","data"=>$fid_list);
        }else{
            $reArr = array("statusCode"=>"300");
        }
        echo json_encode($reArr);
    }
}