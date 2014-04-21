<?php
/**
 * fapi Friend api interface
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2012
 * @package		fapi
 */

class FapiController extends MyPageController
{
    private $key = "suzhoujiju@friend!@#";

	// 首页
	public function actionIndex(){
		echo 'fapi';
	}

	/**
	 * 获取friendou sdk 用户操作日志列表
	 *
	 * 	
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int     $bid    起始id;
     * @param	int	    $limit	查询条数;
     * @param   string  $time   请求时间串;
     * @param   string  $sign   验证串 ( md5($bid.'_'.$limit.'_'.$time.'_'.'suzhoujiju@friend!@#') );
     * @param   string  $type   json or phparray
	 * @time	2014-01-14
	 * @return	JSON
	 */    
    public function actionGet_user_info()
    {
        // init param
        $strSign    = trim(Yii::app()->request->getParam('sign'));
        $strTime    = trim(Yii::app()->request->getParam('time'));
        $intBid     = intval(Yii::app()->request->getParam('bid'));;
        $intLimit   = intval(Yii::app()->request->getParam('limit'));;
        $strType    = trim(Yii::app()->request->getParam('type'));
        $retData    = array(
            'retCode'   => 0,
            'retData'      => array()
        );
        
        // check
        $sign   = md5($intBid.'_'.$intLimit.'_'.$strTime.'_'.$this->key);
        if($sign != $strSign && $intLimit > 0 && $intLimit <= 100){

            // get user info list
            $arrData = array();
            $objConn = Yii::app()->db_data_friendoustats;
            $strSql = "select * from login where id > {$intBid} limit {$intLimit}";
            try{
				$arrR = $objConn->createCommand($strSql)->queryAll();
				if(!empty($arrR)){
                    foreach($arrR as $k=>$v){
                        $arrData[] = $v;
                    }

                    $retData['retData'] = $arrData;
                }
            }catch(Exception $e){
                // exception
                $retData['retCode'] = 1;
			}
        }else{
            // no auth
            $retData['retCode'] = 2;
        }

        // rerturn data
        if($strType && $strType == 'phparray'){
            print_r($retData);
        }else{
            echo json_encode($retData);
        }        
    }

	/**
	 * 获取friendou 所有的appinfo
	 *
	 * 	
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int     $bid    起始id;
     * @param	int	    $limit	查询条数;
     * @param   string  $time   请求时间串;
     * @param   string  $sign   验证串 ( md5($bid.'_'.$limit.'_'.$time.'_'.'suzhoujiju@friend!@#') );
     * @param   string  $type   json or phparray
	 * @time	2014-01-14
	 * @return	JSON
	 */     
    public function actionGet_app_info()
    {
        // init param
        $strSign    = trim(Yii::app()->request->getParam('sign'));
        $strTime    = trim(Yii::app()->request->getParam('time'));
        $intBid     = intval(Yii::app()->request->getParam('bid'));;
        $intLimit   = intval(Yii::app()->request->getParam('limit'));;
        $strType    = trim(Yii::app()->request->getParam('type'));
        $retData    = array(
            'retCode'   => 0,
            'retData'      => array()
        );
        
        // check
        $sign   = md5($intBid.'_'.$intLimit.'_'.$strTime.'_'.$this->key);
        if($sign == $strSign && $intLimit > 0){

            // get user info list
            $arrData = array();
            $objConn = Yii::app()->db_data_FRIENDOU;
            $strSql = "select ID,NAME,APPKEY,ADDTIME,UPDATETIME from FDAPP where ID > {$intBid} limit {$intLimit}";
            try{
				$arrR = $objConn->createCommand($strSql)->queryAll();
				if(!empty($arrR)){
                    foreach($arrR as $k=>$v){
                        $arrData[] = $v;
                    }

                    $retData['retData'] = $arrData;
                }
            }catch(Exception $e){
                // exception
                $retData['retCode'] = 1;
			}
        }else{
            // no auth
            $retData['retCode'] = 2;
        }

        // rerturn data
        if($strType && $strType == 'phparray'){
            print_r($retData);
        }else{
            echo json_encode($retData);
        }          
    }

	/**
	 * 获取friendou 所有的充值记录
	 *
	 * 	
	 * @author	黑冰 (001.black.ice@gmail.com)
     * @param   string  $time   请求时间串; // 1318089720
     * @param   string  $type   json or phparray
	 * @time	2014-01-14
	 * @return	JSON
	 */ 
    public function actionGet_pay_info()
    {
        // param
        $intTime    = intval(Yii::app()->request->getParam('time'));
        $strType    = trim(Yii::app()->request->getParam('type'));
        $retData    = array(
            'retCode'   => 0,
            'retData'      => array()
        );

        // get pay data
        $arrData = array();
        $objConn = Yii::app()->db_data_gameplat;
        if(!$intTime) $intTime = time();
        $strSql = "select * from `order` where pay_time >= {$intTime}";
        try{
            $arrR = $objConn->createCommand($strSql)->queryAll();
            if(!empty($arrR)){
                foreach($arrR as $k=>$v){
                    $arrData[] = $v;
                }

                // get the real pay info
                // before the sdk fix the lose pay info bug;
                /*
                $objConn = Yii::app()->db_data_gameplat;
                if($arrData){
                    foreach($arrData as $k => $data){
                        $order_id = $data['orderid'];
                        $strSql = "select money from `order` where order_id = '{$order_id}'";
                        $arrR = $objConn->createCommand($strSql)->queryRow();
                        if($arrR && $arrR['money']){
                            $arrData[$k]['charge'] = $arrR['money'];
                        }
                    }
                }*/

                $retData['retData'] = $arrData;
            }
        }catch(Exception $e){
            // exception
            $retData['retCode'] = 1;
        }

        // rerturn data
        if($strType && $strType == 'phparray'){
            print_r($retData);
        }else{
            echo json_encode($retData);
        }
    }

	/**
	 * 获取friendou sdk 用户操作日志列表 (machine)
	 *
	 * 	
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int     $bid    起始id;
     * @param	int	    $limit	查询条数;
     * @param   string  $time   请求时间串;
     * @param   string  $sign   验证串 ( md5($bid.'_'.$limit.'_'.$time.'_'.'suzhoujiju@friend!@#') );
     * @param   string  $type   json or phparray
	 * @time	2014-01-14
	 * @return	JSON
	 */    
    public function actionGet_machine_info()
    {
        // init param
        $strSign    = trim(Yii::app()->request->getParam('sign'));
        $strTime    = trim(Yii::app()->request->getParam('time'));
        $intBid     = intval(Yii::app()->request->getParam('bid'));;
        $intLimit   = intval(Yii::app()->request->getParam('limit'));;
        $strType    = trim(Yii::app()->request->getParam('type'));
        $retData    = array(
            'retCode'   => 0,
            'retData'      => array()
        );
        
        // check
        $sign   = md5($intBid.'_'.$intLimit.'_'.$strTime.'_'.$this->key);
        if($sign != $strSign && $intLimit > 0 && $intLimit <= 100){

            // get user info list
            $arrData = array();
            $objConn = Yii::app()->db_data_friendoustats;
            $strSql = "select * from machine where id > {$intBid} limit {$intLimit}";
            try{
				$arrR = $objConn->createCommand($strSql)->queryAll();
				if(!empty($arrR)){
                    foreach($arrR as $k=>$v){
                        $arrData[] = $v;
                    }

                    $retData['retData'] = $arrData;
                }
            }catch(Exception $e){
                // exception
                $retData['retCode'] = 1;
			}
        }else{
            // no auth
            $retData['retCode'] = 2;
        }

        // rerturn data
        if($strType && $strType == 'phparray'){
            print_r($retData);
        }else{
            echo json_encode($retData);
        }        
    }    

	/**
	 * 获取friendou  用户数据
	 *
	 * 	
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int     $bid    起始id;
     * @param	int	    $limit	查询条数;
     * @param   string  $time   请求时间串;
     * @param   string  $sign   验证串 ( md5($bid.'_'.$limit.'_'.$time.'_'.'suzhoujiju@friend!@#') );
     * @param   string  $type   json or phparray
	 * @time	2014-01-14
	 * @return	JSON
	 */    
    public function actionGet_user_reg_info()
    {
        // init param
        $strSign    = trim(Yii::app()->request->getParam('sign'));
        $strTime    = trim(Yii::app()->request->getParam('time'));
        $intBid     = intval(Yii::app()->request->getParam('bid'));;
        $intLimit   = intval(Yii::app()->request->getParam('limit'));;
        $strType    = trim(Yii::app()->request->getParam('type'));
        $retData    = array(
            'retCode'   => 0,
            'retData'      => array()
        );
        
        // check
        $sign   = md5($intBid.'_'.$intLimit.'_'.$strTime.'_'.$this->key);
        if($sign != $strSign && $intLimit > 0 && $intLimit <= 100){

            // get user info list
            $arrData = array();
            $objConn = Yii::app()->db_data_gameplat;
            $strSql = "select * from `user` where id > {$intBid} limit {$intLimit}";
            try{
				$arrR = $objConn->createCommand($strSql)->queryAll();
				if(!empty($arrR)){
                    foreach($arrR as $k=>$v){
                        $arrData[] = $v;
                    }

                    $retData['retData'] = $arrData;
                }
            }catch(Exception $e){
                // exception
                $retData['retCode'] = 1;
			}
        }else{
            // no auth
            $retData['retCode'] = 2;
        }

        // rerturn data
        if($strType && $strType == 'phparray'){
            print_r($retData);
        }else{
            echo json_encode($retData);
        }        
    }     
}
?>
