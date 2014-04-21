<?php
class FaqController extends MyPageController{
    public function actionIndex(){
        $type_id    = Yii::app()->request->getParam('id');
        $type_model = Pdw_faq_type::model();
        if( !isset($type_id) ){
            $cdb = new CDbCriteria();
            $cdb->order     = "recomment desc,id desc";
            $cdb->condition = "fid=0";
            $type_first_obj = $type_model->find($cdb);
            $type_id =$type_first_obj->id;
        }else{
            $type_id = (int)$type_id;
        }
        $type_obj   = $type_model->findByPK($type_id);
        if($type_obj){
            $data=array();
            //顶级类别
            $data['fid_list'] = $type_model->getFidList();
            //获取父类
            $data['type_fobj'] =$type_model->findByPK($type_obj->fid);
            //子类
            $cdb = new CDbCriteria();
            $cdb->order     = "recomment desc,id desc";
            $cdb->condition = "fid=:fid";
            $cdb->params    = array(':fid'=>$type_id);
            $son_list = $type_model->findAll($cdb);
            //存在父类则视图为faq_list;
            //存在子类则视图为faq_list,并且默认当前类为第一个子类,
            if( !empty($data['type_fobj']) || !empty($son_list) ){
                if( empty($data['type_fobj']) ){
                    $data['type_fobj'] = $type_obj;
                    $data['type_id']  = $son_list[0]->id;
                }else{
                    $data['type_id'] = $type_id;
                }
                $view = 'faq_list';
                if( empty($son_list) ){
                    $cdb = new CDbCriteria();
                    $cdb->order     = "recomment desc,id desc";
                    $cdb->condition = "fid=:fid";
                    $cdb->params    = array(':fid'=>$data['type_fobj']->id);
                    $son_list = $type_model->findAll($cdb);
                }
            }else{
                $data['type_id'] = $type_id;
                $view = 'faq_show';
            }
            $cdb = new CDbCriteria();
            $cdb->condition = 'type_id=:type_id';
            $cdb->params=array(':type_id'=>$data['type_id']);
            $cdb->order = 'id ASC';
            
            //分页
            $page = Yii::app()->request->getParam('page')-1;
            $count = Pdw_faq::model()->count($cdb);
            //page
            $pages = new CPagination($count);
            $pages->setPageSize(10);
            $pages->setCurrentPage($page);
            $pages->applyLimit($cdb);
            $all = Pdw_faq::model()->findAll($cdb);
            $data['type_name']=$type_obj->name;
            $data['son_list'] = $son_list;
            $data['all']  = $all;
            $data['pages']=$pages;
            $this->renderPartial($view,$data);
        }else{
            //跳转FAQ首页
            $this->redirect('/faq/',true, 301);
        }
    }
}