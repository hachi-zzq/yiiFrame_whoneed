<?php
/**
 * 网站package后台首页
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2014
 *
 */

	class PackageController extends MyAdminController{
		
		// 初始化
		public function init(){
			parent::init();
		}

        public function actionAddPackage()
        {
            echo "<br/>开始批量处理包资源... <br/><br/>";

            $time = time();
            for($i=0; $i<10; $i++){
                $path           = '/upload_apk/'.date('Ymd', $time - 86400 * $i).'/';
                $apk_path       = CDN_ROOT.$path;
                $package_path   = '';

                $cur_dir = @opendir($apk_path);
                if($cur_dir){
                    //readdir()返回打开目录句柄中的一个条目
                    while(($file = readdir($cur_dir)) !== false) {     
                        $package_path = '';
                        $package_path_md5 = '';

                        if($file == '.' || $file == '..') {
                            continue;
                        }else if(is_dir($sub_dir)) {    
                            continue;
                        }else{    
                            //如果是文件,check input database
                            $package_path = trim($path.$file);
                            $package_path_md5 = md5($package_path);

                            $objDB = Pdc_package::model()->find("package_path_md5 = '{$package_path_md5}'");
                            if(!$objDB){
                                $objDB = new Pdc_package();
                                $objDB->title   = '游戏包';
                                $objDB->package_path    = $package_path;
                                $objDB->package_path_md5= $package_path_md5;
                                $objDB->status          = 0;

                                $objDB->save();
                                echo "deal apk:".$package_path."<br/>";
                            }                        
                        }
                    }
                }
            }

            echo "<br/>此次扫描执行完成!<br/><br/>";
            echo "<font color=red>友情提醒：请先使用ftp工具，上传相应的游戏包，再执行此操作!</font>";
        }

        // 批量更新包到上线的状态
        public function actionUpdate_apk_to_online()
        {
            $ids = trim($_GET['ids']);
            if($ids){
                $objDB = Pdc_package::model()->findAll("id in ({$ids})");
                if($objDB){
                    foreach($objDB as $obj){
                        $obj->status = 4;
                        $obj->save(); 
                    }
                    
                    $this->alert_ok();
                }else{
                    $this->alert_error('更新失败!');
                }
            }else{
                $this->alert_error('操作失败!');
            }
        }

        // 批量指定包到渠道发布的匹配
        public function actionDistribute_apk_channel()
        {
            $ids = trim($_GET['ids']);
            $isok= true;

            if($ids){
                //step1: get the apk into
                $arrApk = array();
                $objDB = Pdc_package::model()->findAll("id in ({$ids}) and status = 5");
                if($objDB && $isok){
                    foreach($objDB as $obj){
                        $arrT = array();
                        $arrT['id']             = $obj->id;
                        $arrT['package_path']   = $obj->package_path;
                        $arrApk[$obj->id] = $arrT;
                    }
                }else{
                    $isok = false;
                }
                //step2: distribute
                if($arrApk && $isok){
                    foreach($arrApk as $apk){
                        $channelinfo =array();
                        if( preg_match('/(?:_([\d]+))?_([\d]+).apk$/',$apk['package_path'],$result) ){
                            if( $result[1] !=='' ){
                                $channelinfo['channel_id'] = $result[1];
                                $channelinfo['sub_id']     = $result[2];
                                $objChannel = Pdcc_sub_channel::model()->find("channel_id = {$channelinfo['channel_id']} and sub_id = {$channelinfo['sub_id']}");
                                if(!$objChannel && $channelInfo['sub_id']==0){
                                    $objChannel = Pdcc_channel::model()->find("id = {$channelInfo['channel_id']}");
                                }
                                if(!$objChannel) $channelinfo = false;
                            }else{
                                $channelinfo = MyFunction::getChannelByServerid($result[2]);
                            }
                        }
                        if( !empty($channelinfo) ){
                            $objDB = Pdc_channel_distribute::model()->find("channel_id = {$channelinfo['channel_id']} and sub_id = {$channelinfo['sub_id']}"); 
                            if($objDB && $objDB->game_id){
                                $objDB->package_id      = $apk['id'];
                                $objDB->package_path    = $apk['package_path'];
                                $objDB->update_time     = date('Y-m-d H:i:s', time());
                                $objDB->save();
                            }else{
                                $isok = false;
                            }
                        }else{
                            $isok = false;
                        }
                        
                    }
                }else{
                    $isok = false;
                }
            }else{
                $isok = false;
            }

            if($isok){
                $this->alert_ok();
            }else{
                $this->alert_error('操作失败!');
            }
        }
    }
?>
