<?php
/**
 * 网站后台 发布apk 到线上环境
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2012
 *
 */

	class UpdateController extends MyAdminController{
		
		private $arrUAuth = array();

		// 初始化
		public function init(){
			parent::init();
        }

        // publish
        public function actionPublish_apk()
        {
            echo "<br/>开始更新apk到线上环境...<br/>";
            echo "<br/>拷贝文件到发布目录...<br/>";
            $sdir = CDN_ROOT.'/upload_apk/';
            $ddir = CDN_ROOT.'/uapk/';

            $shell = "rsync -avz {$sdir} {$ddir}";
            $cmd = `{$shell}`;
            if($cmd){
                echo "<br/><font color=green>拷贝完成!</font><br/>";
            }else{
                echo "<br/><font color=red>拷贝失败</font>, 请联系技术人员!<br/>";    
                exit;
            }


            echo "<br/>更新完成!<br/>";
        }
    }
?>
