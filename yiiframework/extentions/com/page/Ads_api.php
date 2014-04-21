<?php
/**
 * 广告相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		ads_api
 */
class Ads_api{

	/**
	 * 获取广告列表
	 *
	 * <b>使用示例：</b> Ads_api::get_ads_list_by_type(1, 5);
	 *
	 * <b>分类id:</b>
	 * <br/>1: 首页幻灯片[中间]
	 *
	 * <b>返回数组:</b>
	 * <br/>id:			广告id
	 * <br/>type:		广告类型
	 * <br/>ads_title:	广告标题
	 * <br/>ads_image:	广告图片
	 * <br/>ads_url:	广告url
	 * 	
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$type	分类id;
	 * @param	int		$num	广告个数;
	 * @time	2013-01-24
	 * @return	array
	 */
	public static function get_ads_list_by_type($type, $num){
		//init
		$type	= intval($type);
		$num	= intval($num);
		$arrR	= array();

		if($type && $num){
			$cdb = new CDbCriteria();
			$cdb->select	= "id, type, ads_title, ads_image, ads_url";
			$cdb->condition = "type = {$type}";
			$cdb->order		= "corder desc";
			
			$objDB = Vchat_ads::model()->findAll($cdb);
			if($objDB){
				foreach($objDB as $obj){
					$arrT = array();
					$arrT['id']			= $obj->id;
					$arrT['type']		= $obj->type;
					$arrT['ads_title']	= $obj->ads_title;
					$arrT['ads_image']	= $obj->ads_image;
					$arrT['ads_url']	= $obj->ads_url;

					$arrR[] = $arrT;
				}
			}
		}

		return $arrR;
	}
}
?>