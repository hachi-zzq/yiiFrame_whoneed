<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-13
 * Time: 下午6:13
 * To change this template use File | Settings | File Templates.
 */
class Channel_statisticController extends MyAdminController{
    // 初始化
    public function init(){
        parent::init();
    }

    //权限控制
    public function idStr(){
        $admin_id = Yii::app()->user->getState('admin_id');
        $user_channel = Pdcc_user_channel::model();
        $all_user_channel = $user_channel->findAll("user_id =$admin_id");
        $id_str = '';
        if($all_user_channel){
            //该用户在权限控制表中     进行权限控制
            foreach($all_user_channel as $a_u){
                $id_str .=$a_u['channel_id'].',';
            }
            $id_str = rtrim($id_str,',');
        }else{
            //不在表中       不进行权限控制
            $all_channel = Pdcc_channel::model()->findAll();
            foreach($all_channel as $a_u){
                $id_str .=$a_u['id'].',';
            }
            $id_str = rtrim($id_str,',');
        }
        return $id_str;
    }

    //father   channel
    public function actionChannelDailyFather(){
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        $now_time = date('Y-m-d',time());
        $now_time_beg = date('Y-m-d',time()).' 00:00:00';
        $now_time_end = date('Y-m-d',time()).' 23:59:59';
        //权限控制
        $id_str = $this->idStr();
        //分页
        $cdb = new CDbCriteria();
        $cdb->condition = "channel_id in ($id_str) and  record_date = '$now_time'";
        $cdb->group = 'channel_id';
        $count = Pds_channel_daily::model()->count($cdb);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->currentPage = $page;
        $pages->applyLimit($cdb);
        $offset = $pages->pageSize * ($pages->currentPage);

        $sql = "select
                        sum(reg_users)as reg_sum,
                        sum(click_nums) click_nums,
                        sum(new_run_nums) active_nums,
                        sum(pay_users) pay_users,
                        sum(week_active) as week_active_nums,
                        sum(login_twice_nums) as login_twice_nums,
                        sum(login_third_nums) as login_third_nums,
                        sum(login_fifth_nums) as login_fifth_nums,
                        id,
                        channel_id,
                        sub_id
                from
                        pds_channel_daily
                where
                        channel_id in ($id_str)
                        and  record_date = '$now_time'
                group by
                        channel_id
                limit
                        $offset,$pages->pageSize";
        $all = Page::funGetIntroBySql($sql,'',Yii::app()->db_data_statistics);

        foreach($all as &$v){
            $channel_id = $v['channel_id'];
            $pays = Yii::app()->db_data_statistics->createCommand("SELECT count(distinct user_id) pay_user_count , sum(pay_amount) as sum_account FROM pds_pay_atom_statistics WHERE reg_time BETWEEN '$now_time_beg' AND '$now_time_end' AND pay_time BETWEEN '$now_time_beg' AND '$now_time_end' AND channel_id = '$channel_id'")->queryRow();
            $channel_model = Pdcc_channel::model();
            $one = $channel_model->findByPk($channel_id);
            $v['channel_name'] = $one['channel_name'];
            $v['amount'] = $pays['sum_account'];
            $v['pay_users'] = $pays['pay_user_count'];
            //子渠道数目
            $count = Pdcc_sub_channel::model()->count("channel_id = {$channel_id}");
            $v['chlid_count'] = $count;
        }
        $data['all_father'] = $all;
        $data['pager'] = $pages;
        $data['time'] = array('start_time'=>$now_time,'end_time'=>$now_time);
        $data['type'] = Yii::app()->request->getParam('type');
//        $data['pay_time'] = array('pay_start_time'=>$now_time_beg,'pay_end_time'=>$now_time_end);
        $this->display('channel_daily_father',$data);
    }

    //child channel
    public function actionChannelDailyChild(){
        $arrCondition = array();
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        //权限控制
        $id_str = $this->idStr();

        $fid = Yii::app()->request->getParam('fid');
        $start_time = Yii::app()->request->getParam('start_time');
        $end_time = Yii::app()->request->getParam('end_time');
        $full_start_time = $start_time.' 00:00:00';
        $full_end_time = $end_time.' 23:59:59';
        $pay_start_time = Yii::app()->request->getParam('pay_start_time').' 00:00:00';
        $pay_end_time = Yii::app()->request->getParam('pay_end_time').' 23:59:59';

        //addCondition
        $arrCondition['fid'] = $fid;
        $arrCondition['start_time'] = $start_time;
        $arrCondition['end_time'] = $end_time;
        $arrCondition['pay_start_time'] = $pay_start_time;
        $arrCondition['pay_end_time'] = $pay_end_time;

        //分页
        $cdb = new CDbCriteria();
        $cdb->condition = "channel_id='{$fid}' and record_date between '$start_time' and '$end_time'  and  channel_id in ($id_str)";
        $cdb->group = 'sub_id';
        $count = Pds_channel_daily::model()->count($cdb);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->currentPage = $page;
        $pages->applyLimit($cdb);
        $offset = $pages->pageSize * ($pages->currentPage);
        $sql_all_child = "select sub_id,
                                sum(click_nums) click_nums,
                                sum(new_run_nums) active_nums,
                                sum(reg_users) reg_users,
                                sum(pay_users) pay_users ,
                                sum(pay_amount) pay_amount,
                                sum(login_twice_nums) login_twice_nums,
                                sum(login_third_nums) login_third_nums,
                                sum(login_fifth_nums) login_fifth_nums,
                                sum(week_active) week_active
                                from pds_channel_daily
                         where
                                channel_id ='{$fid}'
                                and record_date between '$start_time'
                                and '$end_time'
                                and  channel_id in ($id_str)
                        group by sub_id
                        limit
                                $offset,$pages->pageSize";
        $all_child = Page::funGetIntroBySql($sql_all_child,'',Yii::app()->db_data_statistics);
        foreach($all_child as &$c){
            $id = $c['sub_id'];
            $sql = "SELECT id,count(distinct user_id) pay_user_count ,sum(pay_amount) as pay_amount FROM pds_pay_atom_statistics WHERE reg_time BETWEEN '$full_start_time' AND '$full_end_time' AND pay_time BETWEEN '$pay_start_time' AND '$pay_end_time' AND sub_id = '$id' AND channel_id = '$fid' ";
            $pays = Yii::app()->db_data_statistics->createCommand($sql)->queryRow();
            $child_pay_account = $pays['pay_amount'];
            if($id==0){
                $one = Pdcc_channel::model()->find('id=:channel_id',array(':channel_id'=>$fid));
                $c['channel_name'] = $one['channel_name'];
            }else{
                $one = Pdcc_sub_channel::model()->find('channel_id=:channel_id and sub_id=:sub_id',array(':channel_id'=>$fid,':sub_id'=>$id));
                $c['channel_name'] = $one['sub_channel_name'];
            }
            $c['pay_amount'] = $child_pay_account;
            $c['pay_user_count'] = $pays['pay_user_count'];
        }
        $data['all_child'] = $all_child;
        $data['type'] = Yii::app()->request->getParam('type');
        $data['pager'] = $pages;
        $data['time'] = array('start_time'=>$start_time,'end_time'=>$end_time);
        $data['arrcondition'] = $arrCondition;
        $this->display('channel_daily_child',$data);
    }


    //time search
    public function actionTime_search(){
        $arrCondition = array();
        $page = intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        //权限控制
        $id_str = $this->idStr();
        //channel_from
        $channel_from = Yii::app()->request->getParam('channel_from');
        //channel_type
        $channel_type = Yii::app()->request->getParam('channel_type');
        //app_id
        $appId = Yii::app()->request->getParam('app_id');
        //过滤channel_from
        if($channel_from != '0'){
            $arrId = $this->filterChannelFrom(explode(',',$id_str),$channel_from);
            $id_str = implode(',',$arrId);
            //ajaxPost分页条件传递
            $arrCondition['channel_from'] = $channel_from;
        }
        //过滤channel_type
        if($channel_type != '0'){
            $arrId = $this->filterChannelType(explode(',',$id_str),$channel_type);
            $id_str = implode(',',$arrId);
            //ajaxPost分页条件传递
            $arrCondition['channel_type'] = $channel_type;
        }

        //过滤app_name
        if($appId != '0'){
            $productId = Pdcc_product::model()->find("appid='{$appId}'")->id;
            $objChannelId = Pdcc_channel::model()->findAll("product_id  = '{$productId}'");
            $arrTmpid = array();
            if($objChannelId){
                foreach($objChannelId as $tempId){
                    array_push($arrTmpid,$tempId['id']);
                }
            }
            $arrId = array_intersect(explode(',',$id_str),$arrTmpid);
            $id_str = implode(',',$arrId);
            //ajaxPost分页条件传递
            $arrCondition['app_id'] = $appId;

            $strWhereAppid = "and appid = '$appId' ";
//            exit($strWhereAppid);
        }

        if( ! $id_str){
            //防止id为空时，sql出错
            $id_str = '-100';
        }

        $time_start = date('Y-m-d',Yii::app()->request->getParam('time_start')?strtotime(Yii::app()->request->getParam('time_start')):time());
        $time_end = date('Y-m-d',Yii::app()->request->getParam('time_end')?strtotime(Yii::app()->request->getParam('time_end')):time());
        $full_time_start = Yii::app()->request->getParam('time_start').' 00:00:00';
        $full_time_end = Yii::app()->request->getParam('time_end').' 23:59:59';
        //ajaxPost分页条件传递
        $arrCondition['time_start'] = Yii::app()->request->getParam('time_start');
        $arrCondition['time_end'] = Yii::app()->request->getParam('time_end');

        $pay_start_time = Yii::app()->request->getParam('pay_start_time')?Yii::app()->request->getParam('pay_start_time').' 00:00:00':date('Y-m-d').' 00:00:00';
        $pay_end_time = Yii::app()->request->getParam('pay_end_time')?Yii::app()->request->getParam('pay_end_time').' 23:59:59':date('Y-m-d').' 23:59:59';
        $short_pay_start = Yii::app()->request->getParam('pay_start_time');
        $short_pay_end = Yii::app()->request->getParam('pay_end_time');
        //ajaxPost分页条件传递
        $arrCondition['pay_start_time'] = Yii::app()->request->getParam('pay_start_time');
        $arrCondition['pay_end_time'] = Yii::app()->request->getParam('pay_end_time');
//        echo $time_start.'||'.$time_end.'||'.$pay_start_time.'||'.$pay_end_time;
        //get channel data
        //分页
        $cdb = new CDbCriteria();
        $cdb->condition = " channel_id in ($id_str) and record_date between '$time_start' and '$time_end'";
        $cdb->group = 'channel_id';
        $count = Pds_channel_daily::model()->count($cdb);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->currentPage = $page;
        $pages->applyLimit($cdb);
        $offset = $pages->pageSize * ($pages->currentPage);

        $sql = "select
                        sum(reg_users)as reg_sum,
                        sum(click_nums) click_nums,
                        sum(new_run_nums) active_nums,
                        sum(pay_users) pay_users,
                        sum(week_active) as week_active_nums,
                        sum(login_twice_nums) as login_twice_nums,
                        sum(login_third_nums) as login_third_nums,
                        sum(login_fifth_nums) as login_fifth_nums,
                        id,
                        channel_id,
                        sub_id
                from
                        pds_channel_daily
                where
                        channel_id in ($id_str)
                        and record_date between '$time_start'
                        and '$time_end'
                group by
                        channel_id
                limit
                        $offset,$pages->pageSize";
        $objChannel = Page::funGetIntroBySql($sql,'',Yii::app()->db_data_statistics);
//        print_r($objChannel);
        //get pay data
        $pay_sql = "select count(distinct user_id) pay_user_count,sum(pay_amount) as pay_sum_amount,channel_id from pds_pay_atom_statistics where reg_time between '{$full_time_start}' and '{$full_time_end}' and pay_time between '{$pay_start_time}' and '{$pay_end_time}' {$strWhereAppid} GROUP BY channel_id ";
//        echo $pay_sql;
        $objPay = Page::funGetIntroBySql($pay_sql,'',Yii::app()->db_data_statistics);
//        echo '<pre>';
//        print_r($objPay);
//        echo '</pre>';
        $arrChannel =array();
        $channel_model = Pdcc_channel::model();
        if($objChannel){
            foreach($objChannel as $channel){
                $channel_name = $channel_model->find("id = {$channel['channel_id']}")->channel_name;
                //统计子渠道的数量
                $child_count = Pdcc_sub_channel::model()->count("channel_id = {$channel['channel_id']}");
                $arrChannel[$channel['channel_id']] = $channel;
                $arrChannel[$channel['channel_id']]['channel_name'] = $channel_name;
                $arrChannel[$channel['channel_id']]['chlid_count'] = $child_count;
            }
        }

        if($objPay){
            foreach($objPay as $pay){
                if($arrChannel[$pay['channel_id']]){
                    $arrChannel[$pay['channel_id']]['amount'] = $pay['pay_sum_amount'];
                    $arrChannel[$pay['channel_id']]['pay_user_count'] = $pay['pay_user_count'];
                }
            }
        }
//        echo '<pre>';
//        print_r($arrChannel);
//        echo '</pre>';
        $data['all_father'] = $arrChannel;
        $data['time'] = array('start_time'=>$time_start,'end_time'=>$time_end);
        $data['pay_time'] = array('pay_start_time'=>$short_pay_start,'pay_end_time'=>$short_pay_end);
        $data['type'] = Yii::app()->request->getParam('type');
        $data['channel_from'] = $channel_from;
        $data['channel_type'] = $channel_type;
        $data['app_id'] = $appId;
        $data['pager'] = $pages;
        //传递condition
        $data['arrCondition'] = $arrCondition;
        $this->display('channel_daily_father',$data);
    }

    //filter channel_from
    public function filterChannelFrom($arrIds,$channelFrom){
        $arrChannel = array();
        if(is_array($arrIds)){
            foreach($arrIds as $id){
                if(Pdcc_channel::model()->find("id='{$id}'")->channel_from == $channelFrom)
                    array_push($arrChannel,$id);
            }
        }
        return $arrChannel;
    }

    //filter channel_type
    public function filterChannelType($arrIds,$channelType){
        $arrChannel = array();
        if(is_array($arrIds)){
            foreach($arrIds as $id){
                if(Pdcc_channel::model()->find("id='{$id}'")->channel_type == $channelType)
                    array_push($arrChannel,$id);
            }
        }
        return $arrChannel;
    }

    //app look back
    public function actionAppLookBack(){
        $data = array();
        $arrCondition = array();
        //current page
        $page = Yii::app()->request->getParam('pageNum')-1;
        $cdb = new CDbCriteria();
        //search
        if(Yii::app()->request->isPostRequest){
            $appName = Yii::app()->request->getParam('app_name');
            $cdb->addCondition("appname like '%$appName%'");
            $arrCondition['app_name'] = $appName;
        }

        $count = Pdc_app::model()->count($cdb);
        //page
        $pager = new CPagination($count);
        $pager->setCurrentPage($page);
        $pager->setPageSize(self::PAGE_SIZE);
        $pager->applyLimit($cdb);
        $objApp = Pdc_app::model()->findAll($cdb);
        $data['apps'] = $objApp;
        $data['pager'] = $pager;
        $data['arrCondition'] = $arrCondition;
        $this->display('app_look_back',$data);
    }

}