<?php
/**
 * shell rsync
 * update the apk to the online!
 *
 * @author		嬴益虎 <Yingyh@whoneed.com>
 * @copyright	Copyright 2014
 *
 */
class Shell_rsyncCommand extends CConsoleCommand
{
    public function actionTest()
    {
        echo "This is shell_rsync test! \t\n";
    }

    // do rsync
    public function actionDo_rsync()
    {
        echo "begin do_rsync ......\t\n";
        set_time_limit(0);

        //step0: check rsync status
        if(!$this->checkThread('/data/wwwroot/project/project.data_admin/protected/yiic shell_rsync do_rsync', false, 1)) exit;

        //step1: get the waiting rsync status;
        $objDB = Pdc_package::model()->findAll("status = 4 and rsync_status = 0");
        if(!$objDB){
            echo "exit: the pdc_package obj is NULL! \t\n";
            exit;
        } 

        //step2: save the waiting rsync file;
        $strRFName  = WEB_ROOT.'/runtime/auto_rsync.list'; 
        $arrIds     = array();
        $strContent = '';
        $strApkPath = '';

        foreach($objDB as $obj){
            $arrIds[] = $obj->id;
            
            $strApkPath = str_replace('/upload_apk/', '', $obj->package_path);
            $strContent.= "{$strApkPath}\n";
        }

	    if(!$handle = fopen($strRFName, 'w+')) {
		    echo "ERROR：can't open the $strRFName ! \t\n";
            exit;
	    }

	    if(fwrite($handle, $strContent) === FALSE) {
		    echo "ERROR：can't write the $strRFName ! \t\n";
            exit;
        }

	    fclose($handle);

        //step3: do rsync;
        $sdir = CDN_ROOT.'/upload_apk/';
        $ddir = '/data/wwwroot/project/project.cdn/uapk/';

        $shell = "rsync -avz --progress --files-from={$strRFName} {$sdir} {$ddir}";
        $cmd = `{$shell}`; 
        if($cmd && strpos($cmd, 'total') !== false && strpos($cmd, 'speedup') !== false){
            echo "\n".$cmd."\t\n";
            echo "do rsync ok! \t\n";
        }else{
            echo "ERROR: do rsync. \t\n";
        }

        //step4: save the apk record status;
        if($arrIds){
            $id = 0;
            foreach($arrIds as $id){
                $obj = Pdc_package::model()->find("id = {$id}");
                if($obj){
                    $obj->rsync_status = 1;
                    $obj->save();
                }
            } 
        }else{
            echo "ERROR: update the apk status! \t\n";
        }

        echo "end do_rsync!\t\n";
    }

    public function actionDo_rsync_to_online()
    {
        $arrROnline = array();

        $apkRPath = $_SERVER['argv']['3'];
        $apkRPath = substr($apkRPath, strpos($apkRPath, '/uapk/'));
        $apkRPath = str_replace('/uapk/', '/upload_apk/', $apkRPath);

        // step1: get obj
        $objDB = Pdc_package::model()->find("package_path = '{$apkRPath}'");
        if(!$objDB){
            echo "exit: the pdc_package obj is NULL! \t\n";
            exit;
        }

        if($obj = $objDB){
            $obj->rsync_status = 2;
            $obj->status = 5;
            $obj->save();

            // save apk info
            $arrT = array();
            $arrT['id']                 = $obj->id;
            $arrT['title']              = $obj->title;
            $arrT['package_path']       = str_replace('/upload_apk', '/uapk', $obj->package_path);
            $arrT['package_path_md5']   = '';
            $arrT['create_time']        = date('Y-m-d H:i:s', time());
            $arrT['status']             = $obj->status;
            
            $arrROnline[] = $arrT;
        } 

        // step2: do rsync to online
        if($arrROnline){
            $arrROnline = json_encode($arrROnline);
            
            $postData = array('apk_data' => $arrROnline);
            $url = "http://www.patabom.com/interface/save_apk_info?type=POST";
            $arr =  MyController::get_url($url, true, $postData);                                                                    
            if($arr['code'] == 200){
                echo "INFO: rsync the online database success! \t\n"; 
            }else{
                echo "ERROR: rysnc the online database failed! \t\n";
            }
        }
    }

	/**
	* 常用函数，限制脚本运行个数
	* @param	string	$strName		需要检测的脚本名称
	* @param	boolean	$isChannelDay	默认检测channelday里的脚本,否则需要写上全路径
	* @param	int		$intNum			默认不超过的线程数1个(不包含)
	* @return  boolean					true:可以继续	false:已经达到最大脚本限制
	*/
	public function checkThread($strName = '', $isChannelDay = true, $intNum = 2){
		// 定义将要运行的语句
		$strExec = '';
		$isReturn = true;

		// 是否在channelday里运行
		if($isChannelDay){
			$strExec = "ps -ef | grep php | grep -v cgi | grep -o '/usr/local/php/bin/php /data/wwwroot/project.admanage/protected/yiic channel {$strName}' | wc -l";
		}else{
			$strExec = "ps -ef | grep php | grep -v cgi | grep -o '/usr/local/php/bin/php {$strName}' | wc -l";
		}

		$count = exec($strExec);
		echo "进程数:".($count - 1)."\t\n";
		if($count > $intNum)
		{
			$isReturn = false;
		}

		return $isReturn;
	}    
}
?>
