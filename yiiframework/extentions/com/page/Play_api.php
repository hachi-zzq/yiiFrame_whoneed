<?php
/**
 * 直播接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		play_api
 */
class Play_api{
	
	/**
	 * 获取最新的直播动态
	 *
	 * <b>使用示例：</b> Play_api::get_play_state();
	 *
	 * <b>返回数组:</b>
	 * <br/>s_id:			送礼物的用户id
	 * <br/>s_nickname:		送礼物的呢称
	 * <br/>r_id:			接收礼物的用户id
	 * <br/>r_nickname:		接收礼物的呢称
	 * <br/>gift_name:		礼物名称
	 * <br/>gift_num:		礼物数量
	 * <br/>gift_css_class:	礼物css class name
	 * <br/>time:			时间戳
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int	num	条数; 默认为3
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_play_state($num = 3){
		$arrR = array();
		
		$arrRR = Page::getContentByList('vchat_gift_change_log', 'order by id desc', '*', $num, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$arrT['s_id']			= $data['uid'];
				$arrUser = User_api::get_user_info($data['uid']);
				$arrT['s_nickname']		= $arrUser['nickname'] ? $arrUser['nickname'] : $arrUser['username'];
				
				$arrT['r_id']			= $data['receive_uid'];
				$arrUser = User_api::get_user_info($data['receive_uid']);
				$arrT['r_nickname']		=$arrUser['nickname'] ? $arrUser['nickname'] : $arrUser['username'];
				
				$arrGift = Gift_api::get_gift_info($data['gift_id']);
				$arrT['gift_name']		= $arrGift['gift_name'];
				$arrT['gift_num']		= $data['gift_count'];
				$arrT['gift_css_class']	= $arrGift['gift_ename'] ? $arrGift['gift_ename'].'_small' : '' ;
				$arrT['time']			= strtotime($data['create_time']);

				$arrR[] = $arrT; 
			}
		}

		return $arrR;
	}
}
?>