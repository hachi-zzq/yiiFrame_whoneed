<?php
/**
 * 礼物相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		gift_api
 */

class Gift_api{

	/**
	 * 获取礼物列表
	 *
	 * <b>使用示例：</b> Gift_api::get_may_send_gift_by_type();
	 *
	 * <b>返回二维数组:</b>
	 * <br/>id:					分类id
	 * <br/>type_name:			分类名称
	 * <br/>gift_list:			礼物列表 (数组:内容如下)
	 * <br/>
	 * <br/>|----id:					礼物id
	 * <br/>|----type:				礼物类型id
	 * <br/>|----gift_name:			礼物名称
	 * <br/>|----gift_price:		礼物价格
	 * <br/>|----gift_class:		前端class名称
	 * <br/>|----gift_flash_addr:	礼物特效flash地址
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$type	分类id; 默认获取所有分类;
	 * @time	2013-01-23
	 * @return	array
	 */
	public static function get_may_send_gift_by_type($type = 0){
		// init
		$intType	= intval($type);
		$arrReturn	= array();
		
		// query
		$cdb = new CDbCriteria();
		$cdb->select	= "id,type_name";
		if($intType)	$cdb->condition = "id = {$intType}";
		$cdb->order		= "sorder desc";
		
		// 取得分类id,分类名称
		$strTypeIds = '';
		$objDB = Vchat_gift_type::model()->findAll($cdb);
		if($objDB){
			foreach($objDB as $obj){
				$strTypeIds .= $strTypeIds == '' ? $obj->id : ','.$obj->id ;

				$arrT = array();
				$arrT['id']			= $obj->id;
				$arrT['type_name']	= $obj->type_name;

				$arrReturn[$obj->id]=  $arrT;
			}
		}
		
		// 根据分类id,取得相关礼物
		if($arrReturn && $strTypeIds){
			// query
			$cdb = new CDbCriteria();
			$cdb->select	= "*";
			if($intType)	$cdb->condition = "type in ({$strTypeIds})";
			$cdb->order		= "gorder desc";

			$objDB = Vchat_gift::model()->findAll($cdb);
			if($objDB){
				foreach($objDB as $obj){
					$arrT = array();
					$arrT['id']			= $obj->id;
					$arrT['type']		= $obj->type;
					$arrT['gift_name']	= $obj->gift_name;
					$arrT['gift_price']	= $obj->gift_price;
					$arrT['gift_class']	= $obj->gift_ename;
					$arrT['gift_flash_addr'] = $obj->gift_flash_addr;

					if($arrReturn[$obj->type]) $arrReturn[$obj->type]['gift_list'][] = $arrT;
				}
			}
		}
		
		// return
		return $arrReturn;
	}

	/**
	 * 获取礼物信息
	 *
	 * <b>使用示例：</b> Gift_api::get_gift_info(36);
	 *
	 * <b>返回数组:</b>
	 * <br/>id:					礼物id
	 * <br/>type:				礼物类型
	 * <br/>gift_name:			礼物名称
	 * <br/>gift_img:			礼物图片(暂时弃用)
	 * <br/>gift_price:			礼物价格
	 * <br/>gift_ename:			礼物前端css name
	 * <br/>gorder:				排序
	 * <br/>gift_flash_addr:	flash特效地址
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$id					礼物id
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_gift_info($id=0){
		// init
		$id = intval($id);
		$arrR = array();
		if(!$id) return $arrR;
		
		$data = Page::getContentByOne('vchat_gift', "where id = {$id}", '*', Yii::app()->db_www);
		if($data){
			$arrR = $data;
		}

		return $arrR;
	}
	
	/**
	 * 得到 送/接收 礼物日记列表
	 *
	 * <b>使用示例：</b> Gift_api::get_gift_log_list(36, 'send', 20, true);
	 *
	 * <b>返回数组:</b>
	 * <br/>nickname:		用户呢称
	 * <br/>create_time:	记录时间
	 * <br/>gift_name:		礼物名称
	 * <br/>gift_class:		礼物前端css class name
	 * <br/>gift_count:		礼物数量
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid	用户id
	 * @param	string	$type	类型：send:送礼物; receive:收到礼物
	 * @param	int		$limit	数据条数；默认:20
	 * @param	boolean	$page	是否需要分页；默认：false
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_gift_log_list($uid = 0, $type = 'send', $limit = 20, $page = false){
		$arrR = array();
		$uid  = intval($uid);
		$strUid = '';	// 送/收礼物 相应的相反用户字段
		if(!$uid || !$type) return $arrR;
		
		$where = '';
		// 得到用户用的礼物
		if($type == 'send'){
			$where = " where uid = {$uid}";
			$strUid = 'receive_uid';
		}
		// 得到用户收到的礼物
		else if($type == 'receive'){
			$where = " where receive_uid = {$uid}";
			$strUid = 'uid';
		}

		$where .= ' order by id desc';
		$arrRR = Page::getContentByList('vchat_gift_change_log', $where, '*', $limit, $page, Yii::app()->db_www);
		if($arrRR && $arrRR['data']){
			
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$arrUser = User_api::get_user_info($data[$strUid]);
				$arrT['nickname']		= $arrUser['nickname'];
				$arrT['create_time']	= $data['create_time'];
				$arrGift = self::get_gift_info($data['gift_id']);
				$arrT['gift_name']		= $arrGift['gift_name'];
				$arrT['gift_class']		= $arrGift['gift_ename'];
				$arrT['gift_count']		= $data['gift_count'];

				$arrR[] = $arrT;
			}

			if($page){
				$arrT = array();
				$arrT = $arrR;
				$arrR = array();
				$arrR['data'] = $arrT;
				$arrR['page'] = $arrRR['page'];
			}
		}

		return $arrR;
	}
}
?>