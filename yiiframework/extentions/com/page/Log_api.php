<?php
/**
 * Log 接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		log_api
 */
class Log_api{

	/**
	 * 记录相应的礼物消费日记
	 *
	 * <b>使用示例：</b> Log_api::log_gift_consume(36, 1, 10, 50, 37, '玫瑰');
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid			用户id
	 * @param	int		$gift_id		礼物id
	 * @param	int		$gift_count		礼物数量
	 * @param	int		$game_coin		游戏币消耗数量
	 * @param	int		$receive_uid	接收人用户id
	 * @param	string	$description	描述
	 * @time	2013-01-30
	 * @return	boolean
	 */ 
	public static function log_gift_consume($uid, $gift_id, $gift_count, $game_coin, $receive_uid, $description){
		$isFlag = true;
		
		$objDB = new Vchat_gift_change_log();
		$objDB->uid = $uid;
		$objDB->gift_id = $gift_id;
		$objDB->gift_count = $gift_count;
		$objDB->game_coin = $game_coin;
		$objDB->receive_uid = $receive_uid;
		$objDB->description = $description;
		$objDB->create_time = date('Y-m-d H:i:s', time());
		
		if(!$objDB->save()) 
			$isFlag = false;
		
		return $isFlag;
	}

	//
}
?>