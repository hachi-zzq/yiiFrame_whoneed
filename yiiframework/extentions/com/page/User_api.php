<?php
/**
 * 用户--主播 相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		user_api
 */
class User_api{

	/**
	 * 根据指定数字, 得到主播等级(明星等级) css class name 
	 *
	 * <b>使用示例：</b> User_api::get_user_anchor_level(5000);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$num	收到的游戏币
	 * @time	2013-01-24
	 * @return	string
	 */
	public static function get_user_anchor_level($num = 0){
		// init
		$strClass = 'heart_0';
		$num = intval($num);
		if(!$num) return $strClass;
			
		// 得到主播等级相应换算数据
		$objDB = self::get_user_level(1);
		if($objDB){
			foreach($objDB as $obj){
				if($num >= $obj->num){
					$strClass = $obj->class_name;
					break;
				}
			}
		}
		
		return $strClass;
	}

	/**
	 * 根据主播id, 得到主播等级(明星等级) css class name 
	 *
	 * <b>使用示例：</b> User_api::get_user_anchor_level_by_userid(36);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$userid	用户id
	 * @time	2013-01-24
	 * @return	string
	 */
	public static function get_user_anchor_level_by_userid($userid = 0){
		// init
		$strClass = '';
		$userid = intval($userid);
		if(!$userid) return $strClass;
		
		// 得到用户信息
		$objDB = Vchat_user::model()->find("id = {$userid}");
		if($objDB){
			$strClass = self::get_user_anchor_level($objDB->get_game_coin);
		}
		
		return $strClass;
	}

	/**
	 * 根据指定数字, 得到富豪等级 css class name 
	 *
	 * <b>使用示例：</b> User_api::get_user_rich_level(5000);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$num	消耗的平台币
	 * @time	2013-01-24
	 * @return	string
	 */
	public static function get_user_rich_level($num = 0){
		// init
		$strClass = 'rich_0';
		$num = intval($num);
		if(!$num) return $strClass;
			
		// 得到富豪等级相应换算数据
		$objDB = $objDB = self::get_user_level(2);
		if($objDB){
			foreach($objDB as $obj){
				if($num >= $obj->num){
					$strClass = $obj->class_name;
					break;
				}
			}
		}
		
		return $strClass;
	}

	/**
	 * 根据主播id, 得到富豪等级 css class name 
	 *
	 * <b>使用示例：</b> User_api::get_user_rich_level_by_userid(36);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$userid	用户id
	 * @time	2013-01-24
	 * @return	string
	 */
	public static function get_user_rich_level_by_userid($userid = 0){
		// init
		$strClass = '';
		$userid = intval($userid);
		if(!$userid) return $strClass;
		
		// 得到用户信息
		$objDB = Vchat_user::model()->find("id = {$userid}");
		if($objDB){
			$strClass = self::get_user_rich_level($objDB->use_platform_coin);
		}
		
		return $strClass;
	}

	/**
	 * 根据主播id, 得到主播家族 
	 *
	 * <b>使用示例：</b> User_api::get_user_family_by_userid(36);
	 *
	 * <b>返回</b>
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$userid	用户id
	 * @time	2013-01-24
	 * @return	string
	 */
	public static function get_user_family_by_userid($userid = 0){
		// init
		$strClass = '';
		$userid = intval($userid);
		if(!$userid) return $strClass;
		
		return $strClass;
	}

	/**
	 * 根据主播id, 得到用户信息
	 *
	 * <b>使用示例：</b> User_api::get_user_info(36);
	 *
	 * <b>返回数组:</b>
	 * <br/>photo		: 用户头像
	 * <br/>username	: 用户登录名
	 * <br/>nickname	: 用户呢称
	 *
	 * <br/>如果 $isPlay 设置为true,将返回下面的直播信息
	 * <br/>is_play		: 直接状态 1:直播 0:非直播
	 * <br/>play_title	: 直播标题
	 * <br/>play_time	: 直播开始时间
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$userid	用户id
	 * @param	boolean	$isPlay	是否需要直播信息
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_user_info($userid = 0, $isPlay = false){
		// init
		$arrUser = '';
		$userid = intval($userid);
		if(!$userid) return $strClass;
		
		// 得到用户信息
		$objDB = Vchat_user::model()->find("id = {$userid}");
		if($objDB){
			$arrUser['photo']	 = self::replace_photo_path($objDB->photo);
			$arrUser['username'] = $objDB->username;
			$arrUser['nickname'] = $objDB->nickname ? $objDB->nickname : $objDB->username;
		}
		
		// 得到直播状态
		if($isPlay){
			$objDB = Vchat_user_play::model()->find("id = {$userid}");
			if($objDB){
				$arrUser['is_play']		= $objDB->is_play;
				$arrUser['play_title']	= $objDB->play_title;
				$arrUser['play_time']	= $objDB->play_time;
			}
		}
		
		return $arrUser;
	}
	
	//根据用户id,获取用户昵称
	public static function get_user_nickname($uid=0) {
		$objDB = Vchat_user::model()->find("id = {$uid}");
		if($objDB) {
			$nickname = $objDB->nickname ? $objDB->nickname : $objDB->username;
		}
		else {
			$nickname = '' ;
		}
		return $nickname ;
	}

	//根据用户id,获取用户头像
	public static function get_user_photo($uid=0) {
		$objDB = Vchat_user::model()->find("id = {$uid}");
		$photo = self::replace_photo_path($objDB->photo);
		return $photo ;
	}
	//用户id和房间号之间的转化
	public static function change_rid_to_uid($rid) {
		$uid = '' ;
		$user = Vchat_user::model()->find("id='{$rid}' or short_number='{$rid}'") ;
		if($user) {
			$uid = $user->id ;
		}
		return $uid ;
	}
	//获取主播房间号
	public static function get_room_number($uid) {
		$room_number = 0 ;
		$user = Vchat_user::model()->find("id='{$uid}'") ;
		if($user) {
			if($user->short_number>0) {
				$room_number = $user->short_number ;
			}
			else {
				$room_number = $uid ;
			}
		}
		return $room_number ;
	}
	
	
	//获取转发数
	public static function get_transpond_count($id) {
		$count = 0 ;
		$count = Vchat_user_trends::model()->count("msg_id='{$id}'") ;
		return $count ;
	}
	
	//更新用户评论数
	public static function update_comment_count($id,$type,$tid) {
		if($type=='photo') {
			$user_photo = Vchat_user_photo::model()->find("id='{$id}'") ;
			if($user_photo) {
				$user_photo->comment_count += 1  ;
				$user_photo->save() ;
			}
		}
		elseif($type=='song') {
			$user_song = Vchat_user_song::model()->find("id='{$id}'") ;
			if($user_song) {
				$user_song->comment_count += 1 ;
				$user_song->save() ;
			}
		}
		elseif($type=='video') {
			$user_video = Vchat_user_video::model()->find("id='{$id}'") ;
			if($user_video) {
				$user_video->comment_count += 1 ;
				$user_video->save() ;
			}
		}
		elseif($type=='trend') {
			$user_trend = Vchat_user_trends::model()->find("id='{$tid}'") ;
			if($user_trend) {
				$user_trend->comment_count += 1 ;
				$user_trend->save() ;
			}
		}
		return $id ;
	}

	//更新用户转发数
	public static function update_transpond_count($tid) {
		$user_trends = Vchat_user_trends::model()->find("id='{$tid}'") ;
		if($user_trends) {
			$user_trends->transpond_count +=1 ;
			$user_trends->save() ;
		}
		return $id ;
	}
	
	//删除动态和评论
	public static function del_user_trend_comment($msg_id,$type) {
		$rows = Vchat_user_trends::model()->findAll("msg_id='{$msg_id}' AND type='{$type}'") ;
		if($rows) {
			$is_delete = Vchat_user_trends::model()->deleteAll("msg_id='{$msg_id}' AND type='{$type}'") ;
			foreach($rows as $row) {
				$comment = Vchat_comment::model()->find("tid='{$row->id}'") ;
				if($comment) {
					$comment->delete();
				}
			}
			return $is_delete ;
		}
	}

	//判断是否在直播
	public static function get_user_live($uid) {
		$is_play = 0 ;
		$row = Vchat_user_play::model()->find("uid='{$uid}'") ;
		if($row) {
			$is_play = $row->is_play ;
		}
		return $is_play ;
	}
	

	/**
	 * 根据主播id, 得到主播距离下一个明星等级数据
	 *
	 * <b>使用示例：</b> User_api::get_user_next_anchor_level_by_userid(36);
	 *
	 * <b>返回数组:</b>
	 * <br/>next_class_name		: 下一个等级css class name
	 * <br/>next_num	: 距离下一个等级，还差的差额
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$userid	用户id
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_user_next_anchor_level_by_userid($userid = 0){
		// init
		$arrR = array();
		$arrR['next_class_name']	= '';
		$arrR['next_num']			= 0;
		$userid = intval($userid);
		if(!$userid) return $strClass;
		
		// 得到用户数据
		$objDB = Vchat_user::model()->find("id = {$userid}");
		if($objDB){
			// 得到主播等级数据
			$lastClassName	= '';
			$lastNum		= 0;
			$num = $objDB->get_game_coin;

			$objDB = self::get_user_level(1);
			if($objDB){
				foreach($objDB as $obj){
					if($num >= $obj->num){
						// 记录找到的class
						$strClass = $obj->class_name;
						break;
					}else{
						// 记录上一次数据
						$lastClassName	= $obj->class_name;
						$lastNum		= $obj->num;
					}
				}
			}

			// 设置下一个等级classname
			$arrR['next_class_name'] = $lastClassName;

			// 计算差距
			if( ($lastNum - $num) > 0 ) $arrR['next_num'] = $lastNum - $num;
		}

		return $arrR;
	}

	/**
	 * 根据主播id, 得到主播距离下一个富豪等级数据
	 *
	 * <b>使用示例：</b> User_api::get_user_next_rich_level_by_userid(36);
	 *
	 * <b>返回数组:</b>
	 * <br/>next_class_name		: 下一个等级css class name
	 * <br/>next_num	: 距离下一个等级，还差的差额
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$userid	用户id
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_user_next_rich_level_by_userid($userid = 0){
		// init
		$arrR = array();
		$arrR['next_class_name']	= '';
		$arrR['next_num']			= 0;
		$userid = intval($userid);
		if(!$userid) return $strClass;
		
		// 得到用户数据
		$objDB = Vchat_user::model()->find("id = {$userid}");
		if($objDB){
			// 得到主播等级数据
			$lastClassName	= '';
			$lastNum		= 0;
			$num = $objDB->use_platform_coin;

			$objDB = self::get_user_level(2);
			if($objDB){
				foreach($objDB as $obj){
					if($num >= $obj->num){
						// 记录找到的class
						$strClass = $obj->class_name;
						break;
					}else{
						// 记录上一次数据
						$lastClassName	= $obj->class_name;
						$lastNum		= $obj->num;
					}
				}
			}

			// 设置下一个等级classname
			$arrR['next_class_name'] = $lastClassName;

			// 计算差距
			if( ($lastNum - $num) > 0 ) $arrR['next_num'] = $lastNum - $num;
		}

		return $arrR;
	}

	/**
	 * 得到等级数据
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$type	分类
	 * @time	2013-01-24
	 * @return	object
	 */ 
	private static function get_user_level($type = 1){
		// init
		$type = intval($type);
		if(!$type) return '';

		// 得到等级相应数据
		$cdb = new CDbCriteria();
		$cdb->select	= "name,num,class_name";
		$cdb->condition = "type = {$type}";
		$cdb->order		= "num desc";

		$objDB = Vchat_level::model()->findAll($cdb);
		
		return $objDB;
	}

	/**
	 * 得到主播直播列表
	 *
	 * <b>使用示例：</b> User_api::get_user_play_list();
	 *
	 * <b>返回数组:</b>
	 * <br/>id:					主播id
	 * <br/>nickname:			昵称
	 * <br/>photo:				缩略图
	 * <br/>user_anchor_level:	主播星级css class
	 * <br/>play_time:			距离当前时间
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$type	分类
	 * @param	int		$limit	条数; 默认: 20
	 * @param	boolean	$page	分类; 默认: false; 如果设置为true,需要保证当前$_GET['page']有效
	 * @param	string	$order	排序条件; 默认：order by get_game_coin desc, play_time desc
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_user_play_list($type = 0, $limit = 20, $page = false){
		$type = intval($type);
		$arrR = array();
		
		$where = 'where  is_play=1';
		if($type) $where .= " AND  type_id='{$type}'";
		if($order)$where .= $order;
		$arrRR = Page::getContentByList('vchat_user_play', $where, '*', $limit, $page, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$user = Vchat_user::model()->find("id='{$data['id']}'") ;
				if($user->short_number>0) {
					$arrT = array();
					$arrT['id']					= $data['id'];
					$arrT['nickname']			= User_api::get_user_nickname($data['id']);
					$arrT['photo']				= User_api::get_user_photo($data['id']);
					$arrT['user_anchor_level']	= User_api::get_user_anchor_level_by_userid($data['id']) ;
					$arrT['play_time']			= MyFunction::funRangeTimeZh(strtotime($data['play_time']));
					$arrR[] = $arrT;
				}
			}
		}

		// 分页返回
		if($page){
			$arrData = array();
			$arrData['data'] = $arrR;
			$arrData['page'] = $arrRR['page'];

			$arrR = array();
			$arrR = $arrData;
		}

		return $arrR;
	}

	/**
	 * 明星排行榜
	 *
	 * <b>使用示例：</b> User_api::get_star_user_rank_list('day');
	 *
	 * <b>分类：</b>
	 * <br/>day		: 日榜
	 * <br/>week	: 周榜
	 * <br/>month	: 月榜
	 * <br/>total	: 总榜
	 *
	 * <b>返回数组:</b>
	 * <br/>id:					主播id
	 * <br/>nickname:			昵称
	 * <br/>photo:				头像
	 * <br/>user_anchor_level:	主播星级css class
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	string	$type	分类
	 * @param	int		$limit	条数; 默认: 6
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_star_user_rank_list($type = 'day', $limit = 6){
		// init
		$arrR = array();
		if($type=='day') {
			$time = date('Y-m-d 00:00:00') ;
			$where = " where create_time>='{$time}'" ;
		}
		elseif($type=='week') {
			//获取一周前的日期
			$time=date("Y-m-d 00:00:00",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			$where = " where create_time>='{$time}'" ;
		}
		elseif($type=='month') {
			//获取一个月前的日期
			$time=date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
			$where = " where create_time>='{$time}'" ;
		}
		elseif($type=='total') {
			$where = '' ;
		}
		$arrRR = Page::getContentByList('vchat_gift_change_log', $where.' group by receive_uid order by SUM(`game_coin`) desc', 'receive_uid', $limit, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$user_row = Vchat_user::model()->find("id='{$data['receive_uid']}'") ;
				if($user_row->id) {
					$arrT['id']					= $user_row->id;
					$arrT['photo']				= self::replace_photo_path($user_row->photo);
					$arrT['nickname']			= $user_row->nickname ? $user_row->nickname : $user_row->username;
					$arrT['user_anchor_level']	= self::get_user_anchor_level($user_row->use_platform_coin);
				}
				$arrR[] = $arrT;
			}
		}
		return $arrR;
	}

	/**
	 * 富豪排行榜
	 *
	 * <b>使用示例：</b> User_api::get_rich_user_rank_list('day');
	 *
	 * <b>分类：</b>
	 * <br/>day		: 日榜
	 * <br/>week	: 周榜
	 * <br/>month	: 月榜
	 * <br/>total	: 总榜
	 *
	 * <b>返回数组:</b>
	 * <br/>id:					主播id
	 * <br/>nickname:			昵称
	 * <br/>photo:				头像
	 * <br/>user_anchor_level:	主播星级css class
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	string	$type	分类
	 * @param	int		$limit	条数; 默认: 6
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_rich_user_rank_list($type = '', $limit = 6){
		// init
		$arrR = array();
		if($type=='day') {
			$date = date('Y-m-d 00:00:00') ;
			$where = " where create_time>='{$date}'" ;
		}
		elseif($type=='week') {
			//获取一周前的日期
			$time=date("Y-m-d 00:00:00",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			$where = " where create_time>='{$time}'" ;
		}
		elseif($type=='month') {
			//获取一个月前的日期
			$time=date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
			$where = " where create_time>='{$time}'" ;
		}
		elseif($type=='total') {
			$where = '' ;
		}
		$arrRR = Page::getContentByList('vchat_gift_change_log', $where.' group by uid order by SUM(`game_coin`) desc', 'uid', $limit, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$user_row = Vchat_user::model()->find("id='{$data['uid']}'") ;
				if($user_row->id) {
					$arrT['id']					= $user_row->id;
					$arrT['photo']				= self::replace_photo_path($user_row->photo);
					$arrT['nickname']			= $user_row->nickname ? $user_row->nickname : $user_row->username;
					$arrT['user_rich_level']	= self::get_user_rich_level($user_row->use_platform_coin);
				}
				$arrR[] = $arrT;
			}
		}
		return $arrR;
	}

	/**
	 * 人气排行榜
	 *
	 * <b>使用示例：</b> User_api::get_hot_user_rank_list('day');
	 *
	 * <b>分类：</b>
	 * <br/>day		: 日榜
	 * <br/>week	: 周榜
	 * <br/>month	: 月榜
	 * <br/>total	: 总榜
	 *
	 * <b>返回数组:</b>
	 * <br/>id:					主播id
	 * <br/>nickname:			昵称
	 * <br/>photo:				头像
	 * <br/>user_anchor_level:	主播星级css class
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	string	$type	分类
	 * @param	int		$limit	条数; 默认: 6
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_hot_user_rank_list($type = '', $limit = 6){
		// init
		$arrR = array();
		
		$arrR = array();
		if($type=='day') {
			$date = date('Y-m-d') ;
			$where = " where date>='{$date}'" ;
		}
		elseif($type=='week') {
			//获取一周前的日期
			$date=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			$where = " where date>='{$date}'" ;
		}
		elseif($type=='month') {
			//获取一个月前的日期
			$date=date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
			$where = " where date>='{$date}'" ;
		}
		elseif($type=='total') {
			$where = '' ;
		}
		$arrRR = Page::getContentByList('vchat_user_visit', $where.' group by uid order by SUM(`count`) desc', 'uid', $limit, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$user_row = Vchat_user::model()->find("id='{$data['uid']}'") ;
				$arrT['id']					= $user_row->id;
				$arrT['photo']				= self::replace_photo_path($user_row->photo);
				$arrT['nickname']			= $user_row->nickname ? $user_row->nickname : $user_row->username;
				$arrT['user_rich_level']	= self::get_user_rich_level($user_row->use_platform_coin);
				$arrR[] = $arrT;
			}
		}
		return $arrR;
	}

	/**
	 * 获取用户平台币,游戏币
	 *
	 * <b>使用示例：</b> User_api::get_user_coin(36);
	 *
	 * <b>返回数组:</b>
	 * <br/>uid				: 用户id
	 * <br/>game_coin		: 游戏币
	 * <br/>platform_coin	: 平台币
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid	用户id
	 * @time	2013-01-24
	 * @return	array
	 */ 
	public static function get_user_coin($uid = 0){
		// init
		$uid = intval($uid);
		$arrR = array();
		if(!$uid) return $arrR;
		
		// 获取用户平台币
		$objDB = Vchat_user_coin::model()->find("id = {$uid}");
		if($objDB){
			$arrR['id']				= $objDB->id;
			$arrR['game_coin']		= $objDB->game_coin;
			$arrR['platform_coin']	= $objDB->platform_coin;
		}

		return $arrR;
	}

	/**
	 * 操作平台币,游戏币
	 *
	 * <b>使用示例：</b> User_api::ope_user_coin(36, 100);
	 *
	 * <b>币种：</b>
	 * <br/>game_coin		: 游戏币
	 * <br/>platform_coin	: 平台币
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid		用户id
	 * @param	int		$coin_num	数量: 正为加，负为减
	 * @param	string	$coin		币种
	 * @time	2013-01-24
	 * @return	boolean
	 */ 
	public static function ope_user_coin($uid = 0, $coin_num = 0, $coin = 'game_coin'){
		// init
		$isFlag = false;
		$uid = intval($uid);
		if(!$uid || !$coin_num || !$coin) return $isFlag;

		$objDB = Vchat_user_coin::model()->find("id = {$uid}");
		if($objDB){
			$objDB->$coin = $objDB->$coin + $coin_num;
			if($objDB->$coin >= 0 && $objDB->save()){
				$isFlag = true;
			}
		}
		
		return $isFlag;
	}

	/**
	 * 操作用户 得到游戏币 或者 消耗平台币的 总数
	 *
	 * <b>使用示例：</b> User_api::ope_user_coin_total(36, 100);
	 *
	 * <b>币种：</b>
	 * <br/>get_game_coin		: 得到的总游戏币
	 * <br/>use_platform_coin	: 消耗的总平台币
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid		用户id
	 * @param	int		$coin_num	数量: 正为加，负为减
	 * @param	string	$coin		币种
	 * @time	2013-01-24
	 * @return	boolean
	 */ 
	public static function ope_user_coin_total($uid = 0, $coin_num = 0, $coin = 'get_game_coin'){
		// init
		$isFlag = false;
		$uid = intval($uid);
		if(!$uid || !$coin_num || !$coin) return $isFlag;

		$objDB = Vchat_user::model()->find("id = {$uid}");
		if($objDB){
			$objDB->$coin = $objDB->$coin + $coin_num;
			if($objDB->$coin >= 0 && $objDB->save()){
				$isFlag = true;
			}
		}
		
		return $isFlag;	
	}

	/**
	 * 星主播
	 *
	 * <b>使用示例：</b> User_api::get_star_user_list();
	 *
	 * <b>返回数组:</b>
	 * <br/>id:			主播id
	 * <br/>nickname:	昵称
	 * <br/>photo:		头像
	 * <br/>fans:		粉丝数量
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$num	条数; 默认: 3
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_star_user_list($num = 3){
		// init
		$arrR = array();
		
		$arrRR = Page::getContentByList('vchat_user', 'where short_number>0', '*', $num, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$arrT['id']			= $data['id'];
				$arrT['photo']		= self::replace_photo_path($data['photo']);
				$arrT['nickname']	= $data['nickname'] ? $data['nickname'] : $data['username'];
				$arrR[] = $arrT;
			}
		}

		return $arrR;
	}

	//获取用户粉丝数
	public static function get_fans_count($uid) {
		$fans_count= Vchat_user_attention::model()->count("attention_uid='{$uid}'");
		if(!$fans_count) {
			$fans_count = 0 ;
		}
		return $fans_count ;
	}
	
	/**
	 * 替换实际头像地址 (如果为空，返回空头像地址)
	 *
	 * <b>使用示例：</b> User_api::replace_photo_path();
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	string	$photo	头像地址
	 * @time	2013-01-29
	 * @return	string
	 */ 
	public static function replace_photo_path($photo){
		$strR = '';
		if(!$photo) $photo = '/user/nophoto8080.gif';

		if($photo && strpos($photo, 'http://') === false){
			$strR = Yii::app()->params['img_domain'].$photo;
		}else{
			$strR = $photo;
		}

		return $strR;
	}

	/**
	 * 判断指定用户, 是否是指定房间的管理员
	 *
	 * <b>使用示例：</b> User_api::is_user_play_admin(1, 100);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid	主播id, 房间id
	 * @param	int		$aid	需要判断的用户id
	 * @time	2013-01-29
	 * @return	boolean
	 */ 
	public static function is_user_play_admin($uid, $aid){
		if($aid == 36 || $aid == 37) return true;
		return false;
	}

	/**
	 * 判断指定用户, 是否开启了直播状态
	 *
	 * <b>使用示例：</b> User_api::is_user_play_status(1);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid	主播id, 房间id
	 * @time	2013-01-29
	 * @return	boolean
	 */ 
	public static function is_user_play_status($uid){
		if($uid == 36 || $uid == 37) return true;
		return false;
	}

	/**
	 * 用户直播--fans排行榜
	 *
	 * <b>使用示例：</b> User_api::get_user_paly_fans_list();
	 *
	 * <b>分类id:</b>
	 * <br/>1: 本场直播
	 * <br/>2: 过去30天
	 * <br/>3: 超级粉丝
	 *
	 * <b>返回数组:</b>
	 * <br/>id:				用户id
	 * <br/>nickname:		昵称
	 * <br/>photo:			头像
	 * <br/>consume_coin:	贡献值
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$type	分类id; 默认:1
	 * @param	int		$num	条数; 默认:5
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function get_user_paly_fans_list($type = 1, $num = 5){
		// init
		$arrR = array();
		
		$arrRR = Page::getContentByList('vchat_user', '', '*', $num, false, Yii::app()->db_www);
		if($arrRR['data']){
			foreach($arrRR['data'] as $data){
				$arrT = array();
				$arrT['id']				= $data['id'];
				$arrT['photo']			= self::replace_photo_path($data['photo']);
				$arrT['nickname']		= $data['nickname'] ? $data['nickname'] : $data['username'];
				$arrT['consume_coin']	= $data['game_coin'];

				$arrR[] = $arrT;
			}
		}

		return $arrR;
	}

	/**
	 * 会员关注操作
	 *
	 * <b>使用示例：</b> User_api::ope_user_attention(36, 100, 'add');
	 *
	 * <b>操作类型:</b>
	 * <br/>add:	加关注
	 * <br/>cancel:	取消关注
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid			关注用户id (点击关注按钮的那个人)
	 * @param	int		$attentionuid	被关注用户id (通常是主播id)
	 * @param	string	$type			操作类型
	 * @time	2013-01-29
	 * @return	array
	 */ 
	public static function ope_user_attention($uid, $attentionuid, $type = 'add'){
		$isR = false;
		$uid = intval($uid);
		$attentionuid = intval($attentionuid);
		
		if($uid && $attentionuid && $type){
			// 加关注
			if($type == 'add'){
				$objDB = Vchat_user_attention::model()->find("uid = {$uid} and attention_uid = {$attentionuid}");
				if(!$objDB){
					$objDB = new Vchat_user_attention();
					$objDB->uid				= $uid;
					$objDB->attention_uid	= $attentionuid;
					$objDB->is_focus		= 0;
					$objDB->is_mutual		= 0;
					$objDB->create_time		= date('Y-m-d H:i:s');
					if($objDB->save()){
						$isR = true;
					}
				}
			}

			// 取消关注
			else if($type == 'cancel'){
				$objDB = Vchat_user_attention::model()->find("uid = {$uid} and attention_uid = {$attentionuid}");
				if($objDB){
					if($objDB->delete()){
						$isR = true;
					}
				}			
			}
		}

		return $isR;
	}

	/**
	 * 得到用户直播地址
	 *
	 * <b>使用示例：</b> User_api::get_user_play_url(36);
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	int		$uid	用户id
	 * @time	2013-01-31
	 * @return	string
	 */ 
	public static function get_user_play_url($uid = 0){
		$strR = '';
		$uid = intval($uid);
		$user = Vchat_user::model()->find("id='{$uid}'") ;
		if($user) {
			if($user->short_number>0) {
				$number = $user->short_number ;
			}
			else {
				$number = $uid ;
			}
			$strR = '/profile/room.html?rid='.$number;
		}
		return $strR;
	}
}
?>