<?php
/**
 * 分类接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		type_api
 */
class Type_api{
	
	/**
	 * 首页频道分类
	 *
	 * <b>使用示例：</b> Type_api::get_channel_type_list();
	 *
	 * <b>返回二维数组:</b>
	 * <br/>id:			分类id
	 * <br/>fid:		父id
	 * <br/>type_name:	频道分类名称
	 * <br/>type_url:	频道分类指定url
	 * <br/>count:		相应主播数量统计
	 * <br/>child:		子类(数组)
	 *
	 * <br/>|----id:		分类id
	 * <br/>|----fid:		父id
	 * <br/>|----type_name:	频道分类名称
	 * <br/>|----type_url:	频道分类指定url
	 * <br/>|----count:		相应主播数量统计
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	boolean	$statistics	是否开启数据统计; 默认开启
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_channel_type_list($statistics = true){
		// 得到分类数据
		$arrR = array();
		
		$arrR = self::get_type_array();
		if($arrR){
			foreach($arrR as $k1=>$v1){
				if($v1['child']){
					foreach($v1['child'] as $k2=>$v2){
						$arrR[$k1]['child'][$k2]['count'] = 0;
						unset($arrR[$k1]['child'][$k2]['child']);
					}
				}else{
					unset($v1['child']);
				}

				$arrR[$k1]['count'] = 0;
			}
		}

		return $arrR;
	}

	// 循环得到分类
	private static function get_type_array($type=0){
		// init
		$arrR = array();
		$arrRR= array();

		$arrRR = Page::getContentByList('vchat_channel_type', "where fid = {$type}", 'id,fid,type_name,type_url', 100, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$data['child'] = self::get_type_array($data['id']);
				$arrR[] = $data;
			}
		}

		return $arrR;
	}
}
?>