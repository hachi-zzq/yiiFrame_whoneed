<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-9
 * Time: 上午11:41
 * To change this template use File | Settings | File Templates.
 */
class ChannelController extends MyAdminController{

    public function init(){
        parent::init();
    }

    public function  actionShowOneType(){
        //param
        $channel_from = Yii::app()->request->getParam('channel_from');
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页

        if(isset($channel_from)){
            $channel_model = Pdc_channel::model();

            //分页
            $cdb = new CDbCriteria();
            $cdb->condition = 'channel_from='.$channel_from.' and fid=0 order by id desc';
            $count = $channel_model->count($cdb);
            $pager = new CPagination($count);
            $pager->pageSize = self::PAGE_SIZE;
            $pager->currentPage = $page;
            $pager->applyLimit($cdb);

            $all = $channel_model->findAll($cdb);
            foreach($all as $v){
                $id = $v['id'];
                $count = $channel_model->count("fid=:f_id",array('f_id'=>$id));
                $data['count_'.$id] = $count;
            }
            $data['channel_from'] = $channel_from;
            $data['all'] = $all;
            $data['pager'] = $pager;

            $this->display('one_type_channel',$data);
        }
    }

    //show add
    public function actionShowAdd(){
        $this->display('channel_add');
    }

    //show child add
    public function actionShowChlidAdd(){
        $fid = Yii::app()->request->getParam('fid');
        $channel_model = Pdc_channel::model();
        $data['one'] = $channel_model->find('id=:cid',array('cid'=>$fid));
        $this->display('channel_child_add',$data);
    }

    //show edit
    public function actionShowEdit($id){
        if(isset($id)){
            $channel_model = Pdc_channel::model();
            $data['one'] = $channel_model->findByPk($id);
            $this->display('channel_edit',$data);
        }
    }

    //add_eidt
    public function actionAddEdit(){
        if( ! isset($_POST['id'])){
            $channel_model = new Pdc_channel();
            $channel_model->channel_name = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_name'));
            $channel_model->channel_type = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_type'));
            $channel_model->channel_from = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_from'));
            $channel_model->channel_child_param = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_child_param'));
            $channel_model->is_cooperation = MyFunction::inNoInjection(Yii::app()->request->getParam('is_cooperation'));
            $channel_model->is_redirect = intval(Yii::app()->request->getParam('is_redirect'));
            $channel_model->create_time = date('Y-m-d H:i:s');
            $channel_model->view_name = MyFunction::inNoInjection(Yii::app()->request->getParam('view_name'));
            $channel_model->fid = Yii::app()->request->getParam('fid');
            $channel_model->game_id = Yii::app()->request->getParam('district_id');
            if($channel_model->save()){
                $this->alert_ok();
            }else{
                if($channel_model->hasErrors()){
                    $message=$channel_model->getErrors();
                }
                $message_str='';
                foreach($message as $val) $message_str.=$val[0];
                $this->alert_error($message_str);
            }
        }else{
            $channel_model = Pdc_channel::model();
            $one = $channel_model->findByPk(Yii::app()->request->getParam('id'));
            $one->channel_name = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_name'));
            $one->channel_type = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_type'));
            $one->channel_from = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_from'));
            $one->channel_child_param = MyFunction::inNoInjection(Yii::app()->request->getParam('channel_child_param'));
            $one->is_cooperation = MyFunction::inNoInjection(Yii::app()->request->getParam('is_cooperation'));
            $one->is_redirect    = intval(Yii::app()->request->getParam('is_redirect'));
            $one->view_name        = MyFunction::inNoInjection(Yii::app()->request->getParam('view_name'));
            $one->fid = Yii::app()->request->getParam('fid');
            $one->game_id = Yii::app()->request->getParam('district_id');
            if($one->save()){
                $this->alert_ok();
            }else{
                if($one->hasErrors()){
                    $message=$one->getErrors();
                }
                $message_str='';
                foreach($message as $val) $message_str.=$val[0];
                $this->alert_error($message_str);
            }
        }
    }

    //one delete
    public function actionDeleteOne($id){
        if(isset($id)){
            $one = Pdc_channel::model()->findByPk($id);
            //判断是否有子渠道
            if(Pdc_channel::model()->count('fid=:f_id',array('f_id'=>$id))){
                //删除子渠道
                Pdc_channel::model()->deleteAll('fid=:f_id',array('f_id'=>$id));
            }
            if($one->delete()){
                $this->alert_ok();
            }else{
                $this->alert_error();
            }

        }
    }

    //multi delete
    public function actionMultiDelete(){

        $ids	= trim(Yii::app()->request->getParam('ids'));

//       //删除子渠道
        $idArr = explode(',',$ids);
//        foreach($idArr as $id){
//            Pdc_channel::model()->deleteAll('fid=:f_id and fid!=0',array('f_id'=>$id));
//        }

        //删除付渠道
        foreach($idArr as $id){
            $res = Pdc_channel::model()->deleteByPk($id);
        }
        if($res){
            $this->alert_ok();
        }else{
            $this->alert_error();
        }
    }


    //show chilid
    public function actionShowChild(){
        //param
        $fid = Yii::app()->request->getParam('fid');
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页

        if(isset($fid)){
            $channel_model = Pdc_channel::model();
            //page
            $cdb = new CDbCriteria();
            $cdb->condition = "fid='$fid' order by id desc";
            $count = $channel_model->count($cdb);

            $pages = new CPagination($count);
            $pages->currentPage = $page;
            $pages->pageSize = self::PAGE_SIZE;
            $pages->applyLimit($cdb);

            $all = $channel_model->findAll($cdb);

            //father
            $one = $channel_model->find("id='$fid'");
            $data['father_name'] = $one['channel_name'];
            $data['all_child'] =  $all;
            $data['page'] = $pages;
            $data['fid'] = $fid;

            foreach($all as $v){
                $id = $v['id'];
                $count_child = $channel_model->count("fid=:f_id",array('f_id'=>$id));
                $data['count_'.$id] = $count_child;
            }
            $this->display('channel_child',$data);
        }
    }

    //nav search
    public function actionNavSearch(){
        $search_channel_name = trim(Yii::app()->request->getParam('search_channel_name'));
        $search_channel_from = Yii::app()->request->getParam('search_channel_from');
        $appid = intval(trim(Yii::app()->request->getParam('district_id')));

        if($appid){
            $appidWhere = "and game_id = '{$appid}'";
        }

        $channle_model = Pdc_channel::model();
        if(Yii::app()->request->isPostRequest){
            $search_res = $channle_model->findAll("channel_name like '%$search_channel_name%' and channel_from = $search_channel_from and fid=0 {$appidWhere} order by id desc");
            $data['all'] = $search_res;
            foreach($search_res as $v){
                $id = $v['id'];
                $count = $channle_model->count("fid=:f_id",array('f_id'=>$id));
                $data['count_'.$id] = $count;
            }
            $data['channel_from'] = $search_channel_from;
            $this->display('one_type_channel',$data);
        }
    }

    //high search
    public function actionHighSearch(){
        if(Yii::app()->request->isPostRequest){
            //param
            $channel_from = Yii::app()->request->getParam('channel_from');
            $cdb = new CDbCriteria();
            if(($channel_name=trim(Yii::app()->request->getParam('channel_name'))) != ''){
                $cdb->addCondition("channel_name like '%$channel_name%'");
            }

            if(($channel_type=Yii::app()->request->getParam('channel_type')) !='not'){
                $cdb->addCondition("channel_type = '$channel_type'");
            }

            if(($is_cooperation = Yii::app()->request->getparam('is_cooperation')) !='not'){
                $cdb->addCondition("is_cooperation = $is_cooperation");
            }
            $cdb->addCondition("channel_from = $channel_from");
            $cdb->addCondition('fid = 0');
//            $cdb->addCondition('order by id desc');
            //time search
            $time_start = Yii::app()->request->getParam('time_start');
            $time_end = Yii::app()->request->getParam('time_end');

            if($time_start && $time_end){
                $cdb->addCondition("create_time between '$time_start' and '$time_end' ");
            }elseif(!empty($time_start) && empty($time_end)){
                $cdb->addCondition("create_time between '$time_start' and now()");
            }elseif(!empty($time_end) && empty($time_start)){
                $cdb->addCondition("create_time between '1970-01-01 00:00:00' and '$time_end'");
            }
            $channel_model = Pdc_channel::model();
            $all = $channel_model->findAll($cdb);
            $data['all'] = $all;
            $this->display('one_type_channel',$data);

        }


        $this->display('channel_high_search');

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

    //find channel_id
    public function findChannelId($channelId,$subId,$isCheckDistribute=FALSE){
        $channelDistribute = Pdc_channel_distribute::model();
        if($objFind = $channelDistribute->find("channel_id='{$channelId}' and sub_id='{$subId}'")){
            return $objFind;
        }else{
            if($isCheckDistribute){
                return FALSE;
            }else{
                return new Pdc_channel_distribute();
            }
        }
    }


    //ganmeId选择，用于查找带回
    public function actionGameBack(){
        $arrCondition = array();
        //param
        $page = Yii::app()->request->getParam('pageNum')-1;
        $gameName = Yii::app()->request->getParam('game_name');

        //all_games
        $cdb =  new CDbCriteria();

        //条件查找
        if($gameName){
            $cdb->addCondition("appname like '%{$gameName}%'");
            $arrCondition['game_name'] = $gameName;
        }

        $app_model = Pdc_app::model();
        $count = $app_model->count($cdb);

        //pager
        $pager = new CPagination($count);
        $pager->pageSize = self::PAGE_SIZE;
        $pager->currentPage = $page;
        $pager->applyLimit($cdb);

        //findAll

        $games = $app_model->findAll($cdb);
        $data['games'] = $games;
        $data['pager'] = $pager;
        $data['arrCondition'] = $arrCondition;
        $this->display('game_look_back',$data);
    }

    //packageId选择，查找带回
    public function actionPackageBack(){
        $arrCondition = array();
        //param
        $page = Yii::app()->request->getParam('pageNum')-1;
        $pack_title = Yii::app()->request->getParam('pack_title');
        $pack_path = Yii::app()->request->getParam('pack_path');

        //all_games
        $cdb =  new CDbCriteria();

        //条件查找
        if($pack_title){
            $cdb->addCondition("title like '%{$pack_title}%'");
            $arrCondition['pack_title'] = $pack_title;
        }

        //paht
        if($pack_path){
            $cdb->addCondition("package_path like '%{$pack_path}%'");
            $arrCondition['pack_path'] = $pack_path;
        }

        $cdb->order = 'create_time DESC';
        $package_model = Pdc_package::model();
        $count = $package_model->count($cdb);

        //pager
        $pager = new CPagination($count);
        $pager->pageSize = self::PAGE_SIZE;
        $pager->currentPage = $page;
        $pager->applyLimit($cdb);

        //findAll

        $packages = $package_model->findAll($cdb);
        $data['packages'] = $packages;
        $data['pager'] = $pager;
        $data['arrCondition'] = $arrCondition;
        $this->display('package_look_back',$data);
    }

    //look link
    public function actionChannelLink(){
        $channelName =  Yii::app()->request->getParam('channel_name');
        $channelId = Yii::app()->request->getParam('channel_id');
        $subId = Yii::app()->request->getParam('sub_id');
        $channelDistribute = Pdc_channel_distribute::model();
        $objDistribute = $channelDistribute->find("channel_id='{$channelId}' and sub_id='{$subId}'");
        $package_model = Pdc_package::model();
        $data = array();
        $data['channel_name'] = $channelName;
        if($objDistribute){
            $packageId = $objDistribute->package_id;
            $objPackage = $package_model->find("id='{$packageId}'");
            $data['objPackage'] = $objPackage;
            $data['channel_params'] =array('channel_id'=>$channelId,'sub_id'=>$subId);
        }
        $this->display('channel_link',$data);
    }

    //channel look back
    public function actionChannelLookBack(){
        $arrCondition = array();
        //page
        $page = Yii::app()->request->getParam('pageNum')-1;
        $channel_name = Yii::app()->request->getParam('channel_name');



        //all channel
        $channel_model = Pdcc_channel::model();
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

    //channel pay add
    public function actionChannelPayAdd(){
        if(Yii::app()->request->isPostRequest && $_POST['action']=='save_channel_pay'){
            $recordBeginDate= Yii::app()->request->getParam('record_begin_date');
            $recordEndDate= Yii::app()->request->getParam('record_end_date');
            $cost = Yii::app()->request->getParam('cost');
            $channelId = Yii::app()->request->getParam('district_channel_id');
            $channelFrom = Yii::app()->request->getParam('district_channel_from');
            $channel_pay_model = new Pdc_channel_cost();

            if(Pdc_channel_cost_slave::model()->find("(record_date = '{$recordBeginDate}' or record_date='{$recordEndDate}') and channel_id='{$channelId}'")){
                $this->alert_error('可能已经存在记录，请查看后在录入');
                exit;
            }
            $channel_pay_model->record_begin_date = $recordBeginDate;
            $channel_pay_model->record_end_date = $recordEndDate;
            $channel_pay_model->cost = $cost;
            $channel_pay_model->channel_id = $channelId;
            $channel_pay_model->channel_from = $channelFrom;
            if($channel_pay_model->save()){
                //切表，把时间段切割成每日
                $this->cutChannelCostTable($recordBeginDate,$recordEndDate,$channelId,$channelFrom,$cost);
                $this->alert_ok();
            }else{
                $this->alert_error();
            }
        }
        $this->display('channel_cost_add');
    }

//cut table
    public function cutChannelCostTable($startTime,$endTime,$channelId,$channelFrom,$cost){
        $dayCount = MyFunction::countDays($startTime,$endTime);
        $arrReg = MyFunction::getTimeReg($startTime,$endTime,$channelId);
        $regSum = $arrReg['reg_sum'];
        $activeSum = $arrReg['new_run_nums'];
        $perRegCost = $regSum==0?0:$cost/$regSum;
        $perActiveCost = $activeSum==0?0:($cost/$activeSum);
        for($i=0;$i<$dayCount;$i++){
            $obj = new Pdc_channel_cost_slave();
            $obj->record_date = date('Y-m-d',strtotime($startTime)+24*60*60*$i);
            $obj->channel_id = $channelId;
            $obj->channel_from = $channelFrom;
            $arrDaily = MyFunction::getTimeReg(date('Y-m-d',strtotime($startTime)+24*60*60*$i),date('Y-m-d',strtotime($startTime)+24*60*60*$i),$channelId);
            $obj->reg_cost = $perRegCost*$arrDaily['reg_sum'];
            $obj->active_cost =$perActiveCost*$arrDaily['new_run_nums'];
            $obj->save();
        }
    }

    //channel_pay渠道费用管理
    public function actionChannelPay($page=1){
        $data = array();
        $arrCondition = array();
        //cdb
        $cdb = new CDbCriteria();

        if(Yii::app()->request->isPostRequest && $_POST['action'] == 'search'){
            $page = Yii::app()->request->getParam('pageNum')-1;
            $channelId = Yii::app()->request->getParam('district_channel_id');
            $channelName = Yii::app()->request->getParam('district_channel_name');
            $channelFrom = Yii::app()->request->getParam('channel_from');
            if($channelId){
                $cdb->addCondition("channel_id = '{$channelId}'");
                $arrCondition['district_channel_id'] = $channelId;
            }
            if($channelFrom){
                $cdb->addCondition("channel_from = '{$channelFrom}'");
                $arrCondition['channel_from'] = $channelFrom;
            }
        }
        //page
        $count = Pdc_channel_cost::model()->count($cdb);
        $pager = new CPagination($count);
        $pager->currentPage = $page;
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);
        $objCost = Pdc_channel_cost::model()->findAll($cdb);
        $data['objcost'] = $objCost;
        $data['arrCondition'] = $arrCondition;
        $data['pager'] = $pager;
        $data['params'] = array('channel_id'=>$channelId);
        $this->display('channel_cost',$data);
    }

    //channel_pay edit
    public function actionChannelPayEdit(){
        $data = array();
        $id = intval(Yii::app()->request->getParam('id'));
        $objCost = Pdc_channel_cost::model()->find("id = '{$id}'");
        $channelId = $objCost->channel_id;
        $channelFrom = $objCost->channel_from;
        $record_begindate = $objCost->record_begin_date;
        $record_end_date = $objCost->record_end_date;
        //post
        if(Yii::app()->request->isPostRequest && $_POST['action']=='channel_pay_edit'){
            //delete slave data
            $arrDays = MyFunction::getDays($record_begindate,$record_end_date);
            $cost = Yii::app()->request->getParam('channel_cost');
            foreach($arrDays as $day){
                Pdc_channel_cost_slave::model()->deleteAll("record_date = '{$day}' and channel_id='{$channelId}'");
            }
            //重新分配
            $this->cutChannelCostTable($record_begindate,$record_end_date,$channelId,$channelFrom,$cost);

            //edit cost data
            $objCost->cost = $cost;
            $objCost->save();
            $this->alert_ok();
        }
        $data['objCost'] = $objCost;
        $this->display('channel_cost_edit',$data);
    }

    //channel pay del
    public function actionChannelPayDel(){
        $id = intval(Yii::app()->request->getParam('id'));
        $objCost = Pdc_channel_cost::model()->find("id = '{$id}'");
        $record_begindate = $objCost->record_begin_date;
        $record_end_date = $objCost->record_end_date;
        $channelId = $objCost->channel_id;
        $arrDays = MyFunction::getDays($record_begindate,$record_end_date);
        //delte slave data
        foreach($arrDays as $day){
            Pdc_channel_cost_slave::model()->deleteAll("record_date = '{$day}' and channel_id='{$channelId}'");
        }
        //delete cost data
        Pdc_channel_cost::model()->deleteByPk($id);
        $this->alert_ok();
    }

    public function actionPayMultiDelete(){
        $ids	= trim(Yii::app()->request->getParam('ids'));
        if( ! $ids){
            $this->alert_error('请选择一条数据');
        }
        $arrIds = explode(',',$ids);
        foreach($arrIds as $id){
            $res = Pdc_channel_cost::model()->deleteByPk($id);
        }
        if($res){
            $this->alert_ok();
        }else{
            $this->alert_error();
        }
    }

    //生成日结数据
     public function actionCreateDay(){
        $date = Yii::app()->request->getParam('date');
        $channelType = trim(Yii::app()->request->getParam('channel_type'));
         //开始过滤掉channel_type
         $ids = '';
         if($channelType !== '0'){
            $arr = array();
            $objChannel = Pdcc_channel::model()->findAll("channel_type = '{$channelType}'");
            if($objChannel){
                foreach($objChannel as $channel){
                    array_push($arr,$channel->id);
                }
                $ids = implode(',',$arr);
                $ids = "and channel_id in($ids)";
            }
         }

        $sql = "select sum(new_run_nums) as new_run_nums,sum(reg_users) as reg_users,channel_id from pds_channel_daily where record_date = '{$date}' {$ids} group by channel_id";
        $arrChannel = Page::funGetIntroBySql($sql,'',Yii::app()->db_data_statistics);
         if($arrChannel){
             foreach($arrChannel as &$channel){
                 $channel['channel_name'] = Pdcc_channel::model()->find("id='{$channel['channel_id']}'")->channel_name;
                 $cost = Pdc_channel_cost::model()->find("record_begin_date='{$date}' and record_end_date='{$date}' and channel_id='{$channel['channel_id']}'")->cost;
                 $channel['cost'] = $cost?$cost:0;
             }
         }
         echo json_encode($arrChannel);

     }

    //修改生成的日结数据
    public function actionDayCostEdit(){
        $channelId = Yii::app()->request->getParam('channel_id');
        $date = Yii::app()->request->getParam('date');
        $cost = Yii::app()->request->getParam('cost');
        if( ! $channelId || ! $date){
            exit('not found channel_id or date');
        }
       $channelFrom = Pdcc_channel::model()->find("id='{$channelId}'")->channel_from;
        $obj = Pdc_channel_cost::model()->find("record_begin_date='{$date}' and record_end_date='{$date}' and channel_id='{$channelId}'");
        if($obj){
            $obj->delete();
            Pdc_channel_cost_slave::model()->find("record_date = '{$date}'")->delete();
        }
       $objCost = new Pdc_channel_cost();
        $objCost->record_begin_date = $date;
        $objCost->record_end_date = $date;
        $objCost->channel_id = $channelId;
        $objCost->channel_from = $channelFrom;
        $objCost->cost = $cost;
        if($objCost->save()){
            //切分表
            $this->cutChannelCostTable($date,$date,$channelId,$channelFrom,$cost);
            echo 1;
        }else{
            echo 0;
        }
    }
         //out put excel
    public function actionOutputExcel(){
        $channel_id = Yii::app()->request->getParam('channel_id');
        $channel_from = Yii::app()->request->getParam('channel_from');

        $cdb = new CDbCriteria();
        if($channel_id){
            $cdb->addCondition("channel_id = '{$channel_id}'");
        }

        if($channel_from){
            $cdb->addCondition("channel_from = '{$channel_from}'");
        }
        //page
        $objCost = Pdc_channel_cost::model()->findAll($cdb);
        //
        //直接输出到浏览器
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="channel_cost.xls"');
        header("Content-Transfer-Encoding:binary");

        $fileTop = "渠道编号\t开始日期\t结束日期\t渠道名称\t付费金额\n";
        $row = '';
        if($objCost){
            $channel_model = Pdcc_channel::model();
            foreach($objCost as $cost){
                $start_time = $cost['record_begin_date'];
                $end_time = $cost['record_end_date'];
                $channel_name = Pdcc_channel::model()->find("id='{$cost['channel_id']}'")->channel_name;
                $cost = $cost['cost'];
                $row .= $cost['channel_id']."\t".$start_time."\t".$end_time."\t".$channel_name."\t".$cost."\n";
            }
        }
        $content = $fileTop.$row;
        echo $content;

    }

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
            $model = new Pdc_user_channel;
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
