<?php
/**
 * PataBom Flow 相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		patabom
 */
class PBFlow
{
    // 获取游戏分类
    public static function funSetPAMd5($tid = 0, $field = '')
    {
        $strFName		= CF::getFName($tid);
        $field_md5      = $field.'_md5';
        
        if($_POST[$strFName][$field])
		    $_POST[$strFName][$field_md5] = $_POST[$strFName][$field];
    }

    // 根据地址，二维码生成
    public static function funCreateQRcode($tid = 0, $field = '')
    {
        $strFName		= CF::getFName($tid);
        
        if($_POST[$strFName][$field]){
            try{
                $qrcode_path = '/uqrcode/'.$_POST['id'].'/';

                if(!file_exists(CDN_ROOT.$qrcode_path))
                {
                    mkdir(CDN_ROOT.$qrcode_path);
                }

                $qrcode_path .= time().'.png';
                $url = 'http://www.patabom.com/package/dapk?apk_url='.urlencode($_POST[$strFName][$field]);
                QRcode::png($url, CDN_ROOT.$qrcode_path, QR_ECLEVEL_L, 3, 0);

                $_POST[$strFName]['qrcode_img'] = $qrcode_path;
            }catch(Exception $e){
                print_r($e);
            }
        }
    }

    public static function funCheckUserName($tid = 0, $field = '')
    {
        $strFName   = CF::getFName($tid);
        $user_name  = trim($_POST[$strFName][$field]);
        $user_id    =(int)$_POST['id'];
        $objDB      = Whoneed_admin::model()->find("user_name = '{$user_name}'");
        if($objDB && $objDB->id!=$user_id)
            MyController::alert_error('此用户名已经存在，请不要重复添加!'); 
    }    
}
?>
