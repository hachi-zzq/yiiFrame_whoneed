<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-3-26
 * Time: 下午12:09
 * To change this template use File | Settings | File Templates.
 */
class Data_channelController extends MyAdminController{

    //ini
    public function init(){
        parent::init();
    }

    /*------------------------------------company-----------------------------------------*/

    //add commpay
    public function actionAddCompany(){
       $this->display('company_add');
    }

    //save edit
    public function actionSaveAddEdit(){
        if(Yii::app()->request->isPostRequest){
            $companyName = Yii::app()->request->getparam('company_name');
            $companyNameShort = Yii::app()->request->getparam('company_name_short');
            $action = Yii::app()->request->getParam('action');
            if($action == 'add_company'){
                $obj = new Pdcc_company();
            }elseif($action == 'edit_company' && !empty($_POST['id'])){
                $obj = Pdcc_company::model()->find("id='{$_POST['id']}'");
            }
            $obj->company = $companyName;
            $obj->company_ab = $companyNameShort;
            if($obj->save())
                $this->alert_ok();
            else
                $this->alert_error();
        }
    }

    //mulit del
    public function actionMultiDelete(){
        $ids = Yii::app()->request->getParam('ids');
        $cdb = new CDbCriteria();
        $cdb->addCondition("id in ($ids)");
        if(Pdcc_company::model()->deleteAll($cdb))
            $this->alert_ok();
        else
            $this->alert_error();
    }

    //company list
    public function actionCompanyList(){
        $data = array();
        $arrCondition = array();
        $searchParams = array();
        $page = Yii::app()->request->getParam('pageNum')-1;
        $cdb = new CDbCriteria();
        //search
        if(Yii::app()->request->isPostRequest){
            $searchCompanyName = trim(Yii::app()->request->getParam('search_company_name'));
            if($searchCompanyName){
                $cdb->addCondition("company like '%$searchCompanyName%'");
                $arrCondition['search_company_name'] = $searchCompanyName;
                $searchParams['company_name'] = $searchCompanyName;
            }
        }

        $count = Pdcc_company::model()->count($cdb);
        //pager
        $pager = new CPagination($count);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->setCurrentPage($page);
        $pager->applyLimit($cdb);

        $objCompany = Pdcc_company::model()->findAll($cdb);
        $data['companyList'] = $objCompany;
        $data['pager'] = $pager;
        $data['arrCondition'] = $arrCondition;
        $data['searchParams'] = $searchParams;
        $this->display('company_list',$data);
    }

    //company edit
    public function actionEdit($id){
        if( ! $id){
            die('id not found');
        }
        $data = array();
        $objCompany = Pdcc_company::model()->find("id = '{$id}'");
        $data['company'] = $objCompany;
        $this->display('company_edit',$data);
    }

    //company search
    public function actionCompanySearch(){
        $data = array();
        $arrCondition = array();
        $companyName = Yii::app()->request->getParam('search_company_name');
        $cdb = new CDbCriteria();
        if($companyName){
            $cdb->addCondition("company like '%{$companyName}%'");
        }

    }

       /*------------------------------------product-----------------------------------------*/

    //product list
    public function actionProductList(){
        $data = array();
        $arrCondition = array();
        $searchParams = array();
        $page = Yii::app()->request->getParam('pageNum')-1;
        $companyId = Yii::app()->request->getParam('id');
        if( ! $companyId){
            exit('company id is not found');
        }
        $cdb = new CDbCriteria();
        //search
        if(Yii::app()->request->isPostRequest){
            $searchproductName = trim(Yii::app()->request->getParam('search_product_name'));
            if($searchproductName){
                $cdb->addCondition("appname like '%$searchproductName%'");
                $arrCondition['search_product_name'] = $searchproductName;
                $searchParams['product_name'] = $searchproductName;
            }
        }

        $cdb->addCondition("company_id = '{$companyId}'");

        $count = Pdcc_product::model()->count($cdb);
        //pager
        $pager = new CPagination($count);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->setCurrentPage($page);
        $pager->applyLimit($cdb);

        $objProduct = Pdcc_product::model()->findAll($cdb);
        $data['productList'] = $objProduct;
        $data['pager'] = $pager;
        $data['arrCondition'] = $arrCondition;
        $data['searchParams'] = $searchParams;
        $this->display('product_list',$data);
    }


    //add product
    public function actionAddProduct(){
        $this->display('product_add');
    }

    //save add edit
     public function actionSaveAddEditProduct(){
         if(Yii::app()->request->isPostRequest){
             $appName = Yii::app()->request->getparam('district_game_name');
             $appab = Yii::app()->request->getparam('product_ab');
             $appId = Yii::app()->request->getparam('district_id');
             $companyId = Yii::app()->request->getparam('company_id');
             $action = Yii::app()->request->getParam('action');
             if($action == 'add_product'){
                 $obj = new Pdcc_product();
             }elseif($action == 'edit_product' && !empty($_POST['company_id'])){
                 $obj = Pdcc_product::model()->find("id='{$_POST['company_id']}'");
             }
             $obj->company_id = $companyId;
             $obj->app_ab = $appab;
             $obj->appid = $appId;
             $obj->appname = $appName;
             if($obj->save())
                 $this->alert_ok();
             else
                 $this->alert_error();
         }
     }

    //product multi del
    public function actionProductMultiDel(){
        $ids = Yii::app()->request->getParam('ids');
        $cdb = new CDbCriteria();
        $cdb->addCondition("id in ($ids)");
        if(Pdcc_product::model()->deleteAll($cdb))
            $this->alert_ok();
        else
            $this->alert_error();
    }

    //product edit
    public function actionShowProductEdit(){
        $id = Yii::app()->request->getParam('id');
        if( ! $id){
            die('id not found');
        }
        $data = array();
        $objProduct = Pdcc_product::model()->find("id = '{$id}'");
        $data['product'] = $objProduct;
        $this->display('product_edit',$data);
    }

    /*------------------------------------channel-----------------------------------------*/
    //channel list
    public function actionChannelList(){
        $data = array();
        $arrCondition = array();
        $searchParams = array();
        $productId = Yii::app()->request->getParam('product_id');
        $page = Yii::app()->request->getParam('pageNum')-1;
        if( ! $productId){
            exit('product id is not found');
        }
        $cdb = new CDbCriteria();
        //search
        if(Yii::app()->request->isPostRequest){
            $searchChannelName = trim(Yii::app()->request->getParam('search_channel_name'));
            if($searchChannelName){
                $cdb->addCondition("channel_name like '%$searchChannelName%'");
                $arrCondition['search_channel_name'] = $searchChannelName;
                $searchParams['channel_name'] = $searchChannelName;
            }
        }

        $cdb->addCondition("product_id = '{$productId}'");
        $count = Pdcc_channel::model()->count($cdb);
        //pager
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);

        $objChannel = Pdcc_channel::model()->findAll($cdb);
        $data['all'] = $objChannel;
        $data['pager'] = $pager;
        $data['arrCondtion'] = $arrCondition;
        $data['searchParams'] = $searchParams;
        $this->display('channel_list',$data);
    }

    //add channel
    public function actionChannelAdd(){
        $this->display('channel_add');
    }

    //show edit
    public function actionShowEdit($id){
        if(isset($id)){
            $channel_model = Pdcc_channel::model();
            $data['one'] = $channel_model->findByPk($id);
            $this->display('channel_edit',$data);
        }
    }

    //add_eidt
    public function actionAddEdit(){
        if( ! isset($_POST['id']) && $_POST['action'] == 'add_channel'){
            $objChannel = new Pdcc_channel();
        }elseif(isset($_POST['id']) && $_POST['action'] == 'edit_channel'){
            $objChannel = Pdcc_channel::model()->find("id='{$_POST['id']}'");
        }
        $objChannel->product_id = Yii::app()->request->getParam('product_id');
        $objChannel->channel_name = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_name'));
        $objChannel->channel_type = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_type'));
        $objChannel->channel_from = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_from'));
        $objChannel->channel_child_param = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_child_param'));
        $objChannel->is_cooperation = MyFunction::inNoInjection(Yii::app()->request->getParam('is_cooperation'));
        $objChannel->is_redirect = intval(Yii::app()->request->getParam('is_redirect'));
        $objChannel->create_time = date('Y-m-d H:i:s');
        $objChannel->view_name = MyFunction::inNoInjection(Yii::app()->request->getParam('view_name'));

        if($objChannel->save())
            $this->alert_ok();
        else{
            if($objChannel->hasErrors()){
                $message=$objChannel->getErrors();
            }
            $message_str='';
            foreach($message as $val) $message_str.=$val[0];
            $this->alert_error($message_str);
        }
    }

    //channel multi del
    public function actionChannelMultiDelete(){
        $ids = Yii::app()->request->getParam('ids');
        $cdb = new CDbCriteria();
        $cdb->addCondition("id in ($ids)");
        if(Pdcc_channel::model()->deleteAll($cdb))
            $this->alert_ok();
        else
            $this->alert_error();
    }

    public function  actionShowOneType(){
        $data = array();
        $arrCondition = array();
        $searchParams = array();
        //param
        $channel_from = Yii::app()->request->getParam('channel_from');
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        if(empty($channel_from)){
            exit('type is null');
        }

        if(isset($channel_from)){
            $channel_model = Pdcc_channel::model();

            //分页
            $cdb = new CDbCriteria();

            //search
            if(Yii::app()->request->isPostRequest){
                $searchChannelName = trim(Yii::app()->request->getParam('search_channel_name'));
                $searchChannelType = trim(Yii::app()->request->getParam('channel_type'));
                if($searchChannelName){
                    $cdb->addCondition("channel_name like '%$searchChannelName%'");
                    $arrCondition['search_channel_name'] = $searchChannelName;
                    $searchParams['channel_name'] = $searchChannelName;
                }

                if($searchChannelType !== '0'){
                    $cdb->addCondition("channel_type like '{$searchChannelType}'");
                    $arrCondition['channel_type'] = $searchChannelType;
                    $searchParams['channel_type'] = $searchChannelType;
                }
            }

            $cdb->addCondition("channel_from = '{$channel_from}'");
            $count = $channel_model->count($cdb);
            $pager = new CPagination($count);
            $pager->pageSize = self::PAGE_SIZE;
            $pager->currentPage = $page;
            $pager->applyLimit($cdb);

            $all = $channel_model->findAll($cdb);
            $data['channel_from'] = $channel_from;
            $data['all'] = $all;
            $data['pager'] = $pager;
            $data['searchParams'] = $searchParams;
            $data['arrCondition'] = $arrCondition;
            $this->display('one_type_channel',$data);
        }
    }

    public function actionShowChild(){
        $data = array();
        $arrCondition = array();
        //param
        $fid = Yii::app()->request->getParam('fid');
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页

        if(isset($fid)){
            $channel_model = Pdcc_sub_channel::model();
            //page
            $cdb = new CDbCriteria();
            $cdb->condition = "channel_id='$fid' order by id desc";
            $count = $channel_model->count($cdb);

            $pages = new CPagination($count);
            $pages->currentPage = $page;
            $pages->pageSize = self::PAGE_SIZE;
            $pages->applyLimit($cdb);

            $all = $channel_model->findAll($cdb);

            //father
            $one = Pdcc_channel::model()->find("id='$fid'");
            $data['father_name'] = $one['channel_name'];
            $data['all_child'] =  $all;
            $data['page'] = $pages;
            $data['fid'] = $fid;
            $this->display('channel_child',$data);
        }
    }
//look link
    public function actionChannelLink(){
        $channelName =  Yii::app()->request->getParam('channel_name');
        $channelId = Yii::app()->request->getParam('channel_id');
        if( ! $channelId){
            exit('not found channel_id');
        }
        $subId = Yii::app()->request->getParam('sub_id');
        $linkParam = 'channel_'.$channelId.'.html';
        if($subId != 0){
            $linkParam .= '?sub_id='.$subId;
        }
        $data = array();

        $objDistribute = Pdc_channel_distribute::model()->find("channel_id='{$channelId}' and sub_id='{$subId}'");
        $package_model = Pdc_package::model();
        if($objDistribute){
            $packageId = $objDistribute->package_id;
            $objPackage = $package_model->find("id='{$packageId}'");
            $data['objPackage'] = $objPackage;
        }

        $productId = Pdcc_channel::model()->find("id='{$channelId}'")->product_id;
        $product_ab = Pdcc_product::model()->find("id='{$productId}'")->app_ab;
        $companyId = Pdcc_product::model()->find("id='{$productId}'")->company_id;
        $company_ab = Pdcc_company::model()->find("id='{$companyId}'")->company_ab;
        $data['channel_name'] = $channelName;
        $data['channel_id'] = $channelId;
        $data['sub_id'] = $subId;
        $data['product_ab'] = $product_ab;
        $data['company_ab'] = $company_ab;
        $data['link_param'] = $linkParam;
        $this->display('channel_link',$data);
    }
    /*----------------------sub channel----------------------------*/

    //sub channel list
    public function actionSubChannelList(){
        $data = array();
        //param
        $fid = Yii::app()->request->getParam('fid');
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页

        if(isset($fid)){
            //page
            $cdb = new CDbCriteria();
            $cdb->condition = "channel_id ='{$fid}'";
            $count = Pdcc_sub_channel::model()->count($cdb);

            $pages = new CPagination($count);
            $pages->currentPage = $page;
            $pages->pageSize = self::PAGE_SIZE;
            $pages->applyLimit($cdb);

            $objSub = Pdcc_sub_channel::model()->findAll($cdb);
            $data['all_child'] = $objSub;
            $data['page'] = $pages;
            $this->display('sub_channel_list',$data);
        }
    }

    //mut del
    public function actionSubChannelMultiDel(){
        $ids = Yii::app()->request->getParam('ids');
        $cdb = new CDbCriteria();
        $cdb->addCondition("id in ($ids)");
        if(Pdcc_sub_channel::model()->deleteAll($cdb))
            $this->alert_ok();
        else
            $this->alert_error();
    }

    //add
    //show child add
    public function actionShowChlidAdd(){
        $data = array();
        $fid = Yii::app()->request->getParam('fid');
        $fname = Pdcc_channel::model()->find("id='{$fid}'")->channel_name;
        $data['fname'] = $fname;
        $this->display('sub_channel_add',$data);
    }

    //edit
    public function actionSubChannelEdit(){
        $data = array();
        $id = Yii::app()->request->getParam('id');
        $objSub = Pdcc_sub_channel::model()->find("id='{$id}'");
        $fname = Pdcc_channel::model()->find("id='{$objSub->channel_id}'")->channel_name;
        $data['fname'] = $fname;
        $data['objSub'] = $objSub;
        $this->display('sub_channel_edit',$data);
    }

    //save sub add edit
    public function actionSubSaveEditAdd(){
        $subId = Yii::app()->request->getParam('sub_id');
        if( ! isset($_POST['id']) && $_POST['action'] == 'add_sub_channel'){
            $objSubChannel = new Pdcc_sub_channel();
            if( ! empty($subId)){
                $this->checkSubId($_POST['fid'],$subId) and $this->alert_error('子渠道id已经存在');
                $objSubChannel->sub_id = $subId;
            }else{
                $objSubChannel->sub_id = $this->setSubSub_id($_POST['fid']);
            }
        }elseif(isset($_POST['id']) && $_POST['action'] == 'edit_sub_channel'){
            $objSubChannel = Pdcc_sub_channel::model()->find("id='{$_POST['id']}'");
            if( ! empty($subId) && ($subId != $objSubChannel->sub_id)){
                $this->checkSubId($_POST['fid'],$subId) and $this->alert_error('子渠道id已经存在');
                $objSubChannel->sub_id = $subId;
            }elseif(empty($subId)){
                $objSubChannel->sub_id = $this->setSubSub_id($_POST['fid']);
            }
        }
        $objSubChannel->channel_id = Yii::app()->request->getParam('fid');
        $objSubChannel->sub_channel_name = Yii::app()->request->getParam('sub_channel_name');

        if($objSubChannel->save())
            $this->alert_ok();
        else
            $this->alert_error();
    }

    //渠道分发
    public function actionChannelDistribute(){
        $channelName = Yii::app()->request->getParam('channel_name');
        $channelId = Yii::app()->request->getParam('channel_id');
        $subId = Yii::app()->request->getParam('sub_id');
        //save
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'save'){
            $gameId = $_POST['district_id'];
            $packageId = $_POST['district_package_id'];
            $packagePath = $_POST['district_package_path'];
            $objChannel = $this->findChannelId($channelId,$subId);
            $objChannel->channel_id = $channelId;
            $objChannel->sub_id = $subId;
            $objChannel->game_id = $gameId;
            $objChannel->game_version_id = 0;
            $objChannel->package_id = $packageId;
            $objChannel->package_path = $packagePath;
            $objChannel->update_time = date('Y-m-d H:i:s');
            if($objChannel->save()){
                $this->alert_ok();
            }else{
                $this->alert_error();
            }
        }
        $data['channel_name'] = $channelName;
        $data['channel_id'] = $channelId;
        $data['sub_id'] = $subId;
        $this->display('channel_distribute',$data);
    }

    //check sub is already exist
    public function checkSubId($channelId,$subId){
        $cdb = new CDbCriteria();
        $cdb->addCondition("channel_id = '{$channelId}' and sub_id ='{$subId}'");
        if(Pdcc_sub_channel::model()->find($cdb))
            return true;
        else
            return false;
    }

    //get sub sub_id
    public function setSubSub_id($subChannelId){
        $cdb = new CDbCriteria();
        $cdb->addCondition("channel_id = '{$subChannelId}'");
        $cdb->order = "sub_id DESC";
        $cdb->limit = 1;
        $obj = Pdcc_sub_channel::model()->find($cdb);
        if($obj){
            return ($obj->sub_id)+1;
        }else{
            return 1;
        }
    }
    




    //渠道用户管理
    //添加渠道用户
    public function actionAddChannelUser(){
        $channel_id = (int)Yii::app()->request->getParam('channel_id');
        $data['channel_id'] =$channel_id;
        $this->display('add_channel_user',$data );
    }

    public function actionChannelUserSave(){
        $username   = Yii::app()->request->getParam('username');
        $password   = Yii::app()->request->getParam('password');
        $channel_id = (int)Yii::app()->request->getParam('channel_id');
        $error_message = '';
        //查询用户是否存在
        $user_obj = $this->isUserExists($username);
        if(!$user_obj){
            $user_model = new Whoneed_admin;
            $user_model ->user_name = $username;
            $user_model ->user_pass = MyFunction::funHashPassword($password,true);
            $result = $user_model->save();
            if(!$result){
                if($user_model->hasErrors()){
                    $errors = $user_model->getErrors();
                    foreach($errors as $val){
                        $error_message.=$val[0];
                    }
                }
            }else{
                $user_obj =$user_model;
            }
        }

        if($user_obj){
            //查询用户是否有渠道权限
            $role_obj = Whoneed_rbac_role::model()->find('role_name=:role_name',array(':role_name'=>'渠道'));
            //var_dump($role_obj->id);
            if($role_obj->id){
                $role_ids = $user_obj->role_id;
                if(empty($role_ids)){
                    $role_id_array=array();
                }else{
                    $role_id_array = (array)explode(',',$role_ids);
                }
                //var_dump($role_id_array);
                if(!in_array($role_obj->id,$role_id_array)){
                    $role_id_array[] = $role_obj->id;
                    $role_ids = join(',',$role_id_array);
                    $user_obj->role_id = $role_ids;
                    $result = $user_obj->save();
                }
            }
            //关联用户与渠道
            $model = new Pdcc_user_channel;
            $model->user_id    =(int)$user_obj->id;
            $model->channel_id =$channel_id;
            $result = $model->save();
            if($result){
                $this->alert_ok();
            }else{
                if($model->hasErrors()){
                    $errors = $model->getErrors();
                    foreach($errors as $val){
                        $error_message.=$val[0];
                    }
                }
            }
        }
        $this->alert_error($error_message);
    }

    //检查用户是否存在
    public function isUserExists($user_name){
        $user_model = Whoneed_admin::model();
        $obj = $user_model->find('user_name=:user_name',array(':user_name'=>$user_name));
        if($obj){
            return $obj;
        }
        return false;
    }

    public function actionAjaxCheckUserExists(){
        $username   = Yii::app()->request->getParam('username');
        $reArr=array();
        $reArr['statusCode'] = 200;
        if($this->isUserExists($username)){
            $reArr['message']    =true;
        }else{
            $reArr['message']    =false;
        }
        echo json_encode($reArr);
    }



}